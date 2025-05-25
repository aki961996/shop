<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    // Public Pages
    public function home()
    {
        $products = Product::with('shop')->where('status', true)->paginate(7);
        return view('frondend.product', compact('products'));
    }




    public function create()
    {
        $shops = Shop::all();
        return view('frondend.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);
        return response()->json(['success' => true, 'product' => $product]);
    }

    public function edit($id)
    {
        $id = decrypt($id);

        $product = Product::findOrFail($id);
        $shops = Shop::all();
        return view('frondend.edit', compact('product', 'shops'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return response()->json(['success' => true, 'product' => $product]);
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    // Admin Pages
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function adminShops()
    {
        $shops = Shop::all();

        return view('admin.shops', compact('shops'));
    }

    public function storeShop(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'required  |string|max:1000',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:shops,email',

        ]);

        $shop = Shop::create($validated);

        return response()->json(['success' => true, 'shop' => $shop]);
    }


    public function updateShop(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'description' => 'required  |string|max:1000',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:shops,email',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,

        ]);

        return response()->json(['success' => true, 'shop' => $shop]);
    }

    public function adminProducts()
    {
        $products = Product::all();
        $shops  = Shop::all();
        return view('admin.products', compact('products', 'shops'));
    }

    public function storeProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',

            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shop_id'     => 'required|exists:shops,id',
            'status'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['name', 'price',  'description', 'shop_id', 'status']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shop_id'     => 'required|exists:shops,id',
            'status'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['name', 'price', 'description', 'shop_id', 'status']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Store new image and save path
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return response()->json(['success' => true, 'product' => $product]);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }


        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }


    public function adminStocks()
    {
        return view('admin.stocks');
    }

    public function adminCustomers()
    {
        return view('admin.customers');
    }

    // Shop Pages
    public function shopDashboard()
    {
        return view('shop.dashboard');
    }

    public function shopProducts()
    {
        return view('shop.products');
    }

    public function shopStocks()
    {
        return view('shop.stocks');
    }

    // Customer Pages
    public function customerDashboard()
    {
        return view('customer.dashboard');
    }

    public function customerCart()
    {
        return view('customer.cart');
    }

    public function products()
    {
        $products = Product::with('shop')->where('status', true)->paginate(7);


        return view('frondend.product', compact('products'));
    }
}

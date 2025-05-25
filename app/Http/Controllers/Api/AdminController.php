<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
  // Shop Management
    public function getShops()
    {
        $shops = Shop::with('users', 'products')->get();
        return response()->json($shops);
    }
     public function createShop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:shops,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shop = Shop::create($request->all());
        return response()->json(['message' => 'Shop created successfully', 'shop' => $shop], 201);
    }
public function updateShop(Request $request, Shop $shop)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:shops,email,' . $shop->id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shop->update($request->all());
        return response()->json(['message' => 'Shop updated successfully', 'shop' => $shop]);
    }

      public function deleteShop(Shop $shop)
    {
        $shop->delete();
        return response()->json(['message' => 'Shop deleted successfully']);
    }

      // Product Management
    public function getProducts()
    {
        $products = Product::with('shop', 'stock')->get();
        return response()->json($products);
    }

     public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productData = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $productData['image'] = $imagePath;
        }

        $product = Product::create($productData);
        
        // Create initial stock
        Stock::create([
            'product_id' => $product->id,
            'quantity' => 0,
            'min_quantity' => 0
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

      public function updateProduct(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productData = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $productData['image'] = $imagePath;
        }

        $product->update($productData);
        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

     // Stock Management
    public function getStocks()
    {
        $stocks = Stock::with('product.shop')->get();
        return response()->json($stocks);
    }


    public function createStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stock = Stock::create($request->all());
        return response()->json(['message' => 'Stock created successfully', 'stock' => $stock], 201);
    }

     public function updateStock(Request $request, Stock $stock)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stock->update($request->all());
        return response()->json(['message' => 'Stock updated successfully', 'stock' => $stock]);
    }

     public function deleteStock(Stock $stock)
    {
        $stock->delete();
        return response()->json(['message' => 'Stock deleted successfully']);
    }

      public function getCustomers()
    {
        $customers = User::where('role', 'customer')->with('cart.cartItems.product')->get();
        return response()->json($customers);
    }

}

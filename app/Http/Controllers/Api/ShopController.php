<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Stock;

use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function getProducts()
    {
        $shopId = auth()->user()->shop_id;
        $products = Product::where('shop_id', $shopId)->with('stock')->get();
        return response()->json($products);
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productData = $request->all();
        $productData['shop_id'] = auth()->user()->shop_id;
        
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
        // Check if product belongs to current shop
        if ($product->shop_id !== auth()->user()->shop_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
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
        // Check if product belongs to current shop
        if ($product->shop_id !== auth()->user()->shop_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function getStocks()
    {
        $shopId = auth()->user()->shop_id;
        $stocks = Stock::whereHas('product', function($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })->with('product')->get();
        
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

        // Check if product belongs to current shop
        $product = Product::find($request->product_id);
        if ($product->shop_id !== auth()->user()->shop_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $stock = Stock::create($request->all());
        return response()->json(['message' => 'Stock created successfully', 'stock' => $stock], 201);
    }

    public function updateStock(Request $request, Stock $stock)
    {
        // Check if stock belongs to current shop
        if ($stock->product->shop_id !== auth()->user()->shop_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

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
}

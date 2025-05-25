<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', true)
            ->with('shop', 'stock')
            ->paginate(12);
            
        return response()->json($products);
    }

    public function show(Product $product)
    {
        if (!$product->status) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->load('shop', 'stock');
        return response()->json($product);
    }
}

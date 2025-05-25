<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CustomerController extends Controller
{
   public function getProducts()
    {
        $products = Product::where('status', true)
            ->with('shop', 'stock')
            ->get();
            
        return response()->json($products);
    }
}

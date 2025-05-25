<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
  public function getCart()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('cartItems.product.shop')
            ->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        return response()->json($cart);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->product_id);
        
        // Check if product is active
        if (!$product->status) {
            return response()->json(['message' => 'Product is not available'], 400);
        }

        // Check stock availability
        if ($product->stock && $product->stock->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Check if item already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function updateCartItem(Request $request, CartItem $cartItem)
    {
        // Check if cart item belongs to current user
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check stock availability
        if ($cartItem->product->stock && $cartItem->product->stock->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Cart item updated successfully']);
    }

    public function removeFromCart(CartItem $cartItem)
    {
       
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart successfully']);
    }

    public function clearCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        
        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}

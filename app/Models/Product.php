<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $fillable = [
        'name', 'description', 'price', 'image', 'shop_id', 'status'
    ];

     public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
     public function stock()
    {
        return $this->hasOne(Stock::class);
    }
     public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}

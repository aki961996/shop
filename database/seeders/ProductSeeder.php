<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Product::insert([
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic and responsive wireless mouse',
                'price' => 25.99,
                'image' => 'products/mouse.jpg',
                'shop_id' => 1,
                'status' => true,
            ],
            [
                'name' => 'Bluetooth Headphones',
                'description' => 'Noise-cancelling over-ear headphones',
                'price' => 59.99,
                'image' => 'products/headphones.jpg',
                'shop_id' => 1,
                'status' => true,
            ],
            [
                'name' => 'USB-C Charger',
                'description' => 'Fast-charging adapter with USB-C support',
                'price' => 18.50,
                'image' => 'products/charger.jpg',
                'shop_id' => 2,
                'status' => true,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard',
                'price' => 75.00,
                'image' => 'products/keyboard.jpg',
                'shop_id' => 2,
                'status' => true,
            ],
            [
                'name' => 'Smartwatch Series 6',
                'description' => 'Fitness tracking with heart rate monitoring',
                'price' => 199.99,
                'image' => 'products/smartwatch.jpg',
                'shop_id' => 3,
                'status' => true,
            ],
        ]);
    }
}

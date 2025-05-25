<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a shop for shop user
        $shop = Shop::create([
            'name' => 'Tech Store',
            'description' => 'We sell electronics and accessories.',
            'address' => '123 Main St',
            'phone' => '123-456-7890',
            'email' => 'techstore@example.com',
            'status' => true,
        ]);

        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Shop user
        User::create([
            'name' => 'Shop Owner',
            'email' => 'shop@example.com',
            'password' => Hash::make('password'),
            'role' => 'shop',
            'shop_id' => $shop->id,
        ]);

        // Customer user
        User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //    Shop::truncate(); // Clear existing data (optional)

        $shops = [
            [
                'name' => 'Central Market',
                'description' => 'A large market with various goods.',
                'address' => '123 Main St, Cityville',
                'phone' => '123-456-7890',
                'email' => 'centralmarket@example.com',
                'status' => true,
            ],
            [
                'name' => 'Corner Store',
                'description' => 'Small convenient corner store.',
                'address' => '456 Side Rd, Townsville',
                'phone' => '234-567-8901',
                'email' => 'cornerstore@example.com',
                'status' => true,
            ],
            [
                'name' => 'Downtown Shop',
                'description' => 'Shop located in downtown area.',
                'address' => '789 Broadway, Metropolis',
                'phone' => '345-678-9012',
                'email' => 'downtownshop@example.com',
                'status' => false,
            ],
            [
                'name' => 'Uptown Outlet',
                'description' => 'Outlet store with discounted items.',
                'address' => '101 Uptown Ave, Bigcity',
                'phone' => '456-789-0123',
                'email' => 'uptownoutlet@example.com',
                'status' => true,
            ],
            [
                'name' => 'Mall Kiosk',
                'description' => 'Kiosk located in the shopping mall.',
                'address' => 'Mall Plaza, Level 2',
                'phone' => '567-890-1234',
                'email' => 'mallkiosk@example.com',
                'status' => true,
            ],
        ];

        foreach ($shops as $shop) {
            Shop::create($shop);
        }
    }
 }


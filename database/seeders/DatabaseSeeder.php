<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Seed admin ────────────────────────────────────────────────────────
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
        ]);

        // ── Seed customer ─────────────────────────────────────────────────────
        User::create([
            'name'     => 'Test Customer',
            'email'    => 'customer@gmail.com',
            'password' => Hash::make('cust@123'),
        ]);

        // ── Seed products ─────────────────────────────────────────────────────
        $products = [
            ['name' => 'Wireless Headphones', 'description' => 'Noise-cancelling over-ear headphones.', 'price' => 2999.00, 'stock' => 50],
            ['name' => 'Mechanical Keyboard',  'description' => 'TKL layout, blue switches.',           'price' => 4499.00, 'stock' => 30],
            ['name' => 'USB-C Hub',            'description' => '7-in-1 USB-C hub with HDMI.',          'price' => 1299.00, 'stock' => 75],
            ['name' => 'Webcam 1080p',         'description' => 'Full HD webcam with built-in mic.',    'price' => 1799.00, 'stock' => 40],
            ['name' => 'Mouse Pad XL',         'description' => 'Extended desk mat, 90x40cm.',          'price' =>  599.00, 'stock' => 100],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✓ Admin:    admin@example.com / password');
        $this->command->info('✓ Customer: customer@example.com / password');
        $this->command->info('✓ 5 products seeded');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@poachy.com'],
            ['name' => 'Admin', 'password' => Hash::make('password123')]
        );

        $products = [
            ['name' => 'Rice 2kg',          'sku' => 'GRN-001', 'category' => 'Grains',     'image' => '🌾', 'price' => 450,  'stock' => 24,  'reorder_level' => 10],
            ['name' => 'Cooking Oil 1L',     'sku' => 'CKG-002', 'category' => 'Cooking',    'image' => '🛢️', 'price' => 280,  'stock' => 3,   'reorder_level' => 10],
            ['name' => 'Sugar 1kg',          'sku' => 'BSC-003', 'category' => 'Basics',     'image' => '🧂', 'price' => 150,  'stock' => 5,   'reorder_level' => 10],
            ['name' => 'Bread',              'sku' => 'BKY-004', 'category' => 'Bakery',     'image' => '🍞', 'price' => 50,   'stock' => 45,  'reorder_level' => 15],
            ['name' => 'Milk 500ml',         'sku' => 'DRY-005', 'category' => 'Dairy',      'image' => '🥛', 'price' => 70,   'stock' => 30,  'reorder_level' => 10],
            ['name' => 'Eggs (tray)',        'sku' => 'DRY-006', 'category' => 'Dairy',      'image' => '🥚', 'price' => 450,  'stock' => 15,  'reorder_level' => 5],
            ['name' => 'Tomatoes 1kg',       'sku' => 'VEG-007', 'category' => 'Vegetables', 'image' => '🍅', 'price' => 120,  'stock' => 0,   'reorder_level' => 5],
            ['name' => 'Onions 1kg',         'sku' => 'VEG-008', 'category' => 'Vegetables', 'image' => '🧅', 'price' => 100,  'stock' => 20,  'reorder_level' => 8],
            ['name' => 'Flour 2kg',          'sku' => 'GRN-009', 'category' => 'Grains',     'image' => '🌾', 'price' => 200,  'stock' => 8,   'reorder_level' => 10],
            ['name' => 'Tea Leaves 250g',    'sku' => 'BEV-010', 'category' => 'Beverages',  'image' => '🍵', 'price' => 180,  'stock' => 35,  'reorder_level' => 10],
            ['name' => 'Soap Bar',           'sku' => 'HYG-011', 'category' => 'Hygiene',    'image' => '🧼', 'price' => 80,   'stock' => 4,   'reorder_level' => 10],
            ['name' => 'Salt 1kg',           'sku' => 'BSC-012', 'category' => 'Basics',     'image' => '🧂', 'price' => 60,   'stock' => 28,  'reorder_level' => 10],
            ['name' => 'Unga Dola 2kg',      'sku' => 'GRN-013', 'category' => 'Grains',     'image' => '🌽', 'price' => 175,  'stock' => 40,  'reorder_level' => 15],
            ['name' => 'Soda 500ml',         'sku' => 'BEV-014', 'category' => 'Beverages',  'image' => '🥤', 'price' => 60,   'stock' => 60,  'reorder_level' => 20],
            ['name' => 'Water 500ml',        'sku' => 'BEV-015', 'category' => 'Beverages',  'image' => '💧', 'price' => 30,   'stock' => 100, 'reorder_level' => 30],
            ['name' => 'Toothpaste 100g',    'sku' => 'HYG-016', 'category' => 'Hygiene',    'image' => '🪥', 'price' => 120,  'stock' => 18,  'reorder_level' => 8],
            ['name' => 'Airtime Safaricom',  'sku' => 'AIR-017', 'category' => 'Airtime',    'image' => '📱', 'price' => 50,   'stock' => 999, 'reorder_level' => 100],
            ['name' => 'Blue Band 250g',     'sku' => 'DRY-018', 'category' => 'Dairy',      'image' => '🧈', 'price' => 135,  'stock' => 12,  'reorder_level' => 8],
            ['name' => 'Matches',            'sku' => 'HME-019', 'category' => 'Household',  'image' => '🔥', 'price' => 20,   'stock' => 50,  'reorder_level' => 20],
            ['name' => 'Royco Mchuzi Mix',   'sku' => 'CKG-020', 'category' => 'Cooking',    'image' => '🍲', 'price' => 25,   'stock' => 40,  'reorder_level' => 15],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }

        $this->command->info('Seeded: 1 admin user + 20 products');
    }
}

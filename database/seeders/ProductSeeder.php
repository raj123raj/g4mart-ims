<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'sku' => 'G4-RICE-001',
                'name' => 'Premium Rice 5kg',
                'category' => 'Groceries',
                'price' => 650.00,
                'quantity' => 24,
                'reorder_level' => 10,
            ],
            [
                'sku' => 'G4-SOAP-001',
                'name' => 'Bathing Soap',
                'category' => 'Personal Care',
                'price' => 42.00,
                'quantity' => 6,
                'reorder_level' => 10,
            ],
            [
                'sku' => 'G4-NOTE-001',
                'name' => 'Ruled Notebook',
                'category' => 'Stationery',
                'price' => 55.00,
                'quantity' => 40,
                'reorder_level' => 12,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}

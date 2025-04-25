<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Teclado Mecánico RGB',
                'price' => 200000.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mouse Inalámbrico',
                'price' => 79500.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor 24 pulgadas FullHD',
                'price' => 1200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Dell i5 16GB RAM',
                'price' => 4200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silla Ergonómica Oficina',
                'price' => 98000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

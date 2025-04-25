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
                'description' => 'Teclado mecánico con retroiluminación RGB, ideal para gamers.',
                'price' => 200000.99,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mouse Inalámbrico',
                'description' => 'Mouse ergonómico inalámbrico con precisión ajustable.',
                'price' => 79500.50,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor 24 pulgadas FullHD',
                'description' => 'Monitor de 24 pulgadas con resolución Full HD y panel IPS.',
                'price' => 1200000.00,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Dell i5 16GB RAM',
                'description' => 'Laptop Dell con procesador i5, 16GB de RAM y 512GB de SSD.',
                'price' => 4200000.00,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silla Ergonómica Oficina',
                'description' => 'Silla ergonómica para oficina con soporte lumbar ajustable.',
                'price' => 98000.00,
                'stock' => 130,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Modern Leather Sofa',
                'description' => 'A luxurious 3-seater leather sofa with a contemporary design. Perfect for modern living rooms, featuring premium Italian leather and solid wood frame.',
                'price' => 1299.99,
                'category' => 'Sofa',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Professional office chair with lumbar support and adjustable armrests. Breathable mesh back and comfortable cushioned seat for long working hours.',
                'price' => 349.99,
                'category' => 'Chair',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Rustic Dining Table',
                'description' => 'Handcrafted solid wood dining table with natural finish. Seats 6-8 people comfortably. Perfect for family gatherings and dinner parties.',
                'price' => 899.99,
                'category' => 'Table',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Minimalist Bookshelf',
                'description' => 'Five-tier open bookshelf with modern design. Made from engineered wood with a smooth finish. Great for displaying books, plants, and decorative items.',
                'price' => 199.99,
                'category' => 'Storage',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Velvet Accent Chair',
                'description' => 'Elegant accent chair upholstered in soft velvet fabric. Features gold-finished metal legs and comfortable cushioning. Adds a touch of luxury to any room.',
                'price' => 449.99,
                'category' => 'Chair',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Industrial Coffee Table',
                'description' => 'Modern coffee table with a metal frame and wooden top. Industrial design with clean lines. Perfect centerpiece for living room seating areas.',
                'price' => 299.99,
                'category' => 'Table',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Platform Storage Bed',
                'description' => 'Queen-size platform bed with built-in storage drawers. Solid construction with a modern design. Includes storage for bedding and other items.',
                'price' => 699.99,
                'category' => 'Bed',
                'ar_enabled' => false,
            ],
            [
                'name' => 'Scandinavian TV Stand',
                'description' => 'Mid-century modern TV stand with cable management. Features open shelving and closed cabinets. Accommodates TVs up to 65 inches.',
                'price' => 379.99,
                'category' => 'Storage',
                'ar_enabled' => false,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Sample products created successfully!');
        $this->command->info('To enable AR, upload GLB and USDZ models for any product.');
    }
}

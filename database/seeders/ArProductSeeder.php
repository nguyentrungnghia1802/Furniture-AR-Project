<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use App\Models\Product\Category;
use Illuminate\Database\Seeder;

class ArProductSeeder extends Seeder
{
    /**
     * Run the database seeds for AR products.
     */
    public function run(): void
    {
        // Tạo hoặc lấy category cho furniture
        $categories = [
            'Seating' => Category::firstOrCreate(['name' => 'Seating']),
            'Tables' => Category::firstOrCreate(['name' => 'Tables']),
            'Storage' => Category::firstOrCreate(['name' => 'Storage']),
        ];

        // Sample AR products data
        $arProducts = [
            [
                'name' => 'Modern Office Chair',
                'descriptions' => 'Ergonomic office chair with lumbar support and adjustable height. Perfect for modern workspaces.',
                'price' => 299.99,
                'stock_quantity' => 25,
                'category_id' => $categories['Seating']->id,
                'image_url' => 'office-chair.jpg',
                'ar_enabled' => true,
                'width_cm' => 60.0,
                'height_cm' => 120.0,
                'depth_cm' => 60.0,
                'ar_placement_instructions' => 'Place on flat floor surface. Best viewed from sitting position height.',
                'discount_percent' => 15,
                'view_count' => 156,
            ],
            [
                'name' => 'Scandinavian Dining Table',
                'descriptions' => 'Minimalist wooden dining table seats 6 people. Made from sustainable oak wood.',
                'price' => 899.99,
                'stock_quantity' => 8,
                'category_id' => $categories['Tables']->id,
                'image_url' => 'dining-table.jpg',
                'ar_enabled' => true,
                'width_cm' => 180.0,
                'height_cm' => 75.0,
                'depth_cm' => 90.0,
                'ar_placement_instructions' => 'Requires large flat surface. Ensure 1 meter clearance around table.',
                'discount_percent' => 0,
                'view_count' => 89,
            ],
            [
                'name' => 'Industrial Bookshelf',
                'descriptions' => 'Modern industrial style bookshelf with metal frame and wooden shelves.',
                'price' => 449.99,
                'stock_quantity' => 12,
                'category_id' => $categories['Storage']->id,
                'image_url' => 'bookshelf.jpg',
                'ar_enabled' => true,
                'width_cm' => 80.0,
                'height_cm' => 200.0,
                'depth_cm' => 35.0,
                'ar_placement_instructions' => 'Place against wall. Check ceiling height before placement.',
                'discount_percent' => 20,
                'view_count' => 234,
            ],
            [
                'name' => 'Velvet Accent Chair',
                'descriptions' => 'Luxurious velvet accent chair in emerald green. Perfect for reading corners.',
                'price' => 599.99,
                'stock_quantity' => 15,
                'category_id' => $categories['Seating']->id,
                'image_url' => 'accent-chair.jpg',
                'ar_enabled' => true,
                'width_cm' => 75.0,
                'height_cm' => 85.0,
                'depth_cm' => 80.0,
                'ar_placement_instructions' => 'Great for corners or beside existing furniture. Allow space for reclining.',
                'discount_percent' => 0,
                'view_count' => 67,
            ],
            [
                'name' => 'Glass Coffee Table',
                'descriptions' => 'Modern tempered glass coffee table with chrome legs. Scratch and heat resistant.',
                'price' => 399.99,
                'stock_quantity' => 20,
                'category_id' => $categories['Tables']->id,
                'image_url' => 'coffee-table.jpg',
                'ar_enabled' => true,
                'width_cm' => 120.0,
                'height_cm' => 45.0,
                'depth_cm' => 60.0,
                'ar_placement_instructions' => 'Center in front of seating area. Consider leg clearance underneath.',
                'discount_percent' => 10,
                'view_count' => 145,
            ],
            [
                'name' => 'Classic Wooden Wardrobe',
                'descriptions' => 'Traditional wooden wardrobe with mirror doors and multiple compartments.',
                'price' => 1299.99,
                'stock_quantity' => 5,
                'category_id' => $categories['Storage']->id,
                'image_url' => 'wardrobe.jpg',
                'ar_enabled' => true,
                'width_cm' => 180.0,
                'height_cm' => 220.0,
                'depth_cm' => 60.0,
                'ar_placement_instructions' => 'Requires large bedroom space. Check door opening clearance.',
                'discount_percent' => 25,
                'view_count' => 78,
            ],
        ];

        // Insert AR products
        foreach ($arProducts as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ Created ' . count($arProducts) . ' AR-enabled products');
        $this->command->info('🎯 Products have AR dimensions and placement instructions');
        $this->command->info('📱 Ready for AR testing on mobile devices');
    }
}
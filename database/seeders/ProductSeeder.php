<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Wireless Mouse', 'price' => 150.00, 'quantity' => 15, 'category' => 'Computers & Tech'],
            ['name' => 'Standing Desk', 'price' => 40.00, 'quantity' => 4, 'category' => 'Computers & Tech'],
            ['name' => 'Notebook Set', 'price' => 300.00, 'quantity' => 30, 'category' => 'Computers & Tech'],
            ['name' => 'Samsung Galaxy S24', 'price' => 150.00, 'quantity' => 15, 'category' => 'Mobile Phones & Gadgets'],
            ['name' => 'iPhone 17 Pro Max', 'price' => 40.00, 'quantity' => 4, 'category' => 'Mobile Phones & Gadgets'],
            ['name' => 'King Size Bed Frame', 'price' => 300.00, 'quantity' => 30, 'category' => 'Furniture & Home Living'],
            ['name' => 'Coffee Table', 'price' => 150.00, 'quantity' => 15, 'category' => 'Furniture & Home Living'],
            ['name' => 'Cetaphil Gentle Skin Cleanser', 'price' => 40.00, 'quantity' => 4, 'category' => 'Beauty & Personal Care'],
            ['name' => 'Neutrogena Sunscreen SPF50', 'price' => 300.00, 'quantity' => 30, 'category' => 'Beauty & Personal Care'],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->firstOrFail();

            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'category_id' => $category->id,
                ]
            );
        }
    }
}

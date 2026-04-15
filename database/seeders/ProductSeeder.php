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
            ['name' => 'Wireless Mouse', 'quantity' => 15, 'category' => 'Electronics'],
            ['name' => 'Standing Desk', 'quantity' => 4, 'category' => 'Furniture'],
            ['name' => 'Notebook Set', 'quantity' => 30, 'category' => 'Office Supplies'],
            ['name' => 'USB-C Hub', 'quantity' => 9, 'category' => 'Accessories'],
            ['name' => 'Monitor Arm', 'quantity' => 6, 'category' => 'Accessories'],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->firstOrFail();

            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'quantity' => $item['quantity'],
                    'category_id' => $category->id,
                ]
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'category_id' => $request->string('category_id')->toString(),
            'sort_by' => $request->string('sort_by')->toString() ?: 'name',
            'direction' => $request->string('direction')->toString() ?: 'asc',
        ];

        $allowedSorts = ['name', 'quantity'];
        $sortBy = in_array($filters['sort_by'], $allowedSorts, true) ? $filters['sort_by'] : 'name';
        $direction = $filters['direction'] === 'desc' ? 'desc' : 'asc';

        $products = Product::query()
            ->with('category:id,name')
            ->when($filters['category_id'], fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->orderBy($sortBy, $direction)
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'category' => $product->category?->name,
                'category_id' => $product->category_id,
            ]);

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('category:id,name');

        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'category_id' => $product->category_id,
            ],
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

        public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
}

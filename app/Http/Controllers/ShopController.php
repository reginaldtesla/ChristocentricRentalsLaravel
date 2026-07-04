<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $query = $request->query('q');

        $products = Product::query()
            ->with('category')
            ->inStock()
            ->forCategorySlug($category)
            ->search($query)
            ->orderBy('name')
            ->get()
            ->map->toCardArray();

        return view('shop.index', [
            'products' => $products,
            'activeCategory' => $category,
            'searchQuery' => $query,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');

        $related = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->limit(8)
            ->get();

        $prevProduct = Product::query()
            ->where('id', '<', $product->id)
            ->inStock()
            ->orderByDesc('id')
            ->first();

        $nextProduct = Product::query()
            ->where('id', '>', $product->id)
            ->inStock()
            ->orderBy('id')
            ->first();

        return view('shop.show', [
            'product' => $product,
            'maxQuantity' => max(1, (int) ($product->quantity ?: 1)),
            'related' => $related,
            'prevProduct' => $prevProduct,
            'nextProduct' => $nextProduct,
        ]);
    }
}

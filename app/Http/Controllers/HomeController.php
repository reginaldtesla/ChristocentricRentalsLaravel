<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'popularProducts' => Product::inStock()->with('category')->orderByDesc('rating')->limit(12)->get()->map->toCardArray(),
            'featuredProducts' => Product::featured()->inStock()->with('category')->limit(8)->get()->map->toCardArray(),
            'productTabs' => [
                'new' => 'New',
                'featured' => 'Featured',
                'top_rated' => 'Top Rated',
            ],
            'productPanels' => [
                'new' => Product::newest()->inStock()->with('category')->limit(6)->get()->map->toCardArray(),
                'featured' => Product::featured()->inStock()->with('category')->limit(6)->get()->map->toCardArray(),
                'top_rated' => Product::inStock()->with('category')->orderByDesc('rating')->limit(6)->get()->map->toCardArray(),
            ],
            'widgetLists' => [
                'new' => Product::newest()->inStock()->limit(3)->get()->map->toCardArray(),
                'featured' => Product::featured()->inStock()->limit(3)->get()->map->toCardArray(),
                'best_week' => Product::inStock()->orderByDesc('rating')->limit(3)->get()->map->toCardArray(),
                'popular' => Product::inStock()->latest()->limit(3)->get()->map->toCardArray(),
            ],
        ]);
    }
}

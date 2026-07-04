<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\AdminImageStore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product,
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('products', 'slug')->ignore($request->route('product'))],
            'description' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            ...AdminImageStore::rules('image_file'),
            'is_new' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'in_stock' => ['nullable', 'boolean'],
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]) + [
            'is_new' => $request->boolean('is_new'),
            'is_featured' => $request->boolean('is_featured'),
            'in_stock' => $request->boolean('in_stock'),
        ];

        if ($request->hasFile('image_file')) {
            $validated['image'] = AdminImageStore::storeForProduct(
                $request->file('image_file'),
                $validated['slug'],
            );
        } elseif (blank($validated['image'] ?? null)) {
            $existing = $request->route('product');
            $validated['image'] = $existing?->image;
        }

        unset($validated['image_file']);

        return $validated;
    }
}

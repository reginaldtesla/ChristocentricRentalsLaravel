<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(30),
        ]);
    }

    public function create()
    {
        return view('admin.categories.form', [
            'category' => new Category,
        ]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request));

        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has products.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($request->route('category')),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]) + [
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}

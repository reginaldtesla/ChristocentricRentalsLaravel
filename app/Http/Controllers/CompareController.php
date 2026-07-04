<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CompareService;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function __construct(private CompareService $compare) {}

    public function index()
    {
        return view('compare.index', [
            'products' => $this->compare->products(),
            'maxItems' => $this->compare->maxItems(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($this->compare->has($product->slug)) {
            return back()->with('success', 'Already in your compare list.');
        }

        if (! $this->compare->add($product)) {
            return back()->with('error', 'You can compare up to '.$this->compare->maxItems().' products at a time. Remove one to add another.');
        }

        return back()->with('success', 'Added to compare. ('.$this->compare->count().'/'.$this->compare->maxItems().')');
    }

    public function destroy(string $slug)
    {
        $this->compare->remove($slug);

        return back()->with('success', 'Removed from compare.');
    }

    public function clear()
    {
        $this->compare->clear();

        return redirect()->route('compare.index')->with('success', 'Compare list cleared.');
    }
}

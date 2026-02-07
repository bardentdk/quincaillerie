<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Welcome', [
            // On utilise with('category') pour charger la relation
            'products' => Product::with('category')
                ->when($request->category, function ($query, $slug) {
                    $query->whereHas('category', fn($q) => $q->where('slug', $slug));
                })
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->paginate(12)
                ->withQueryString(),
            
            'categories' => Category::all(),
            'filters' => $request->only(['category']),
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => $product->load('category')
        ]);
    }
}
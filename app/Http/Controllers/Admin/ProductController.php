<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::with('category')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
        ]);

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Création du produit
        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'price_cents' => (int) ($validated['price'] * 100),
            'stock_quantity' => $validated['stock_quantity'],
            'sku' => 'QC-' . strtoupper(Str::random(8)),
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
            'seo_metadata' => [
                'title' => $validated['seo_title'],
                'description' => $validated['seo_description'],
            ],
            'is_active' => true,
        ]);

        return redirect()->route('admin.products.index')
            ->with('message', 'La perceuse a bien été ajoutée au catalogue !');
    }
}
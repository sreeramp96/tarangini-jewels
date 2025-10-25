<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'discount_price' => 'nullable|numeric|lt:price',
            'is_featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $isPrimary = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $isPrimary = false;
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // ... (other rules) ...
            'is_featured' => 'nullable|boolean',

            // --- ADD VALIDATION FOR NEW FIELDS ---
            'images' => 'nullable|array', // For new uploads
            'images.*' => 'image|mimes:jpeg,png,jpg,webp',
            'delete_images' => 'nullable|array', // For deletions
            'delete_images.*' => 'integer|exists:product_images,id' // Must be valid image IDs
        ]);

        // ... (Handle slug and 'is_featured' checkbox) ...
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        // --- NEW LOGIC FOR HANDLING IMAGES ---

        // 1. Delete selected images
        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)->get();
            foreach ($imagesToDelete as $image) {
                // Delete the file from storage
                Storage::disk('public')->delete($image->image_path);
                // Delete the record from the database
                $image->delete();
            }
        }

        // 2. Add any new images
        if ($request->hasFile('images')) {
            // Re-check if a primary image exists after potential deletions
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => !$hasPrimary, // Only set as primary if one doesn't exist
                ]);
                $hasPrimary = true; // Ensure only the first new image is set as primary
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
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
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $isPrimary = true;

            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = $product->slug . '-' . $product->id . '-' . uniqid() . '.' . $extension;
                $product->addMedia($image)
                    ->usingFileName($filename)
                    ->withCustomProperties(['primary' => $isPrimary])
                    ->toMediaCollection('products', 's3');
                $isPrimary = false;
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('s3')->delete($image->image_path);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('products', 's3');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => !$hasPrimary,
                ]);
                $hasPrimary = true;
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function showImportForm()
    {
        //might want a simpler dedicated import view later.
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function handleImport(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('import_file'));
            return redirect()->route('admin.products.index')->with('success', 'Products imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::error('Import Validation Failed: ', $failures);
            return back()->withErrors(['import_file' => 'Import failed. Check logs for details.']);
        } catch (\Exception $e) {
            Log::error('Product Import Failed: ' . $e->getMessage());
            return back()->withErrors(['import_file' => 'An error occurred during import. Please check the file format and data.']);
        }
    }
}

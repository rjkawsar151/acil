<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $isFeatured = $request->query('is_featured');
        $tab = $request->query('tab', 'all');

        $query = Product::with(['category', 'images']);

        if ($tab === 'trashed') {
            $query->onlyTrashed();
        }

        if ($search) {
            $query->search($search);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($isFeatured !== null && $isFeatured !== '') {
            $query->where('is_featured', (bool)$isFeatured);
        }

        $products = $query->orderBy('sort_order', 'asc')->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        $trashedCount = Product::onlyTrashed()->count();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId', 'status', 'tab', 'trashedCount'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:products,slug',
            'sku' => 'nullable|string|max:100',
            'brand' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage_information' => 'nullable|string',
            'ingredients_information' => 'nullable|string',
            'packaging_information' => 'nullable|string',
            'available_sizes' => 'nullable|string|max:200',
            'ph_level' => 'nullable|string|max:100',
            'color_appearance' => 'nullable|string|max:200',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'brochure' => 'nullable|mimes:pdf|max:10240',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'sort_order' => 'integer|min:0',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $count = Product::where('slug', 'like', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        if ($request->hasFile('brochure')) {
            $validated['brochure'] = $request->file('brochure')->store('brochures', 'public');
        }

        $product = Product::create($validated);

        if ($request->hasFile('gallery_images')) {
            $order = 1;
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'sort_order' => $order++,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', "Product '{$product->name}' created successfully.");
    }

    public function edit(int $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products,slug,' . $product->id,
            'sku' => 'nullable|string|max:100',
            'brand' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage_information' => 'nullable|string',
            'ingredients_information' => 'nullable|string',
            'packaging_information' => 'nullable|string',
            'available_sizes' => 'nullable|string|max:200',
            'ph_level' => 'nullable|string|max:100',
            'color_appearance' => 'nullable|string|max:200',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'brochure' => 'nullable|mimes:pdf|max:10240',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'sort_order' => 'integer|min:0',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        if ($request->hasFile('brochure')) {
            $validated['brochure'] = $request->file('brochure')->store('brochures', 'public');
        }

        $product->update($validated);

        if ($request->hasFile('gallery_images')) {
            $maxOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'sort_order' => ++$maxOrder,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function destroy(int $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->trashed()) {
            $product->forceDelete();
            return back()->with('success', 'Product permanently deleted.');
        }

        $product->delete();
        return back()->with('success', "Product moved to trash.");
    }

    public function restore(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return back()->with('success', "Product restored successfully.");
    }

    public function toggleFeatured(int $id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();

        return response()->json(['success' => true, 'is_featured' => $product->is_featured]);
    }

    public function toggleStatus(int $id)
    {
        $product = Product::findOrFail($id);
        $product->status = ($product->status === 'active') ? 'inactive' : 'active';
        $product->save();

        return response()->json(['success' => true, 'status' => $product->status]);
    }

    public function deleteImage(int $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        $image->delete();

        return back()->with('success', 'Gallery image removed.');
    }
}

@extends('layouts.admin')

@section('page_title', 'Edit Formulation')
@section('page_subtitle', "Editing: {$product->name}")

@section('content')

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-flask text-brand-blue"></i>
                <span>Basic Product Information</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SKU Code</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Overview</label>
                <textarea name="short_description" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('short_description', $product->short_description) }}</textarea>
            </div>
        </div>

        <!-- Detailed Specifications Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-brand-scientific"></i>
                <span>Chemical & Technical Specifications</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Available Sizes</label>
                    <input type="text" name="available_sizes" value="{{ old('available_sizes', $product->available_sizes) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">pH Level Spec</label>
                    <input type="text" name="ph_level" value="{{ old('ph_level', $product->ph_level) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Color & Appearance</label>
                    <input type="text" name="color_appearance" value="{{ old('color_appearance', $product->color_appearance) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Key Product Benefits</label>
                    <textarea name="benefits" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('benefits', $product->benefits) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Usage Instructions</label>
                    <textarea name="usage_information" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('usage_information', $product->usage_information) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">INCI Ingredients</label>
                    <textarea name="ingredients_information" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs">{{ old('ingredients_information', $product->ingredients_information) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Packaging Information</label>
                    <textarea name="packaging_information" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('packaging_information', $product->packaging_information) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Media & Gallery Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-images text-purple-600"></i>
                <span>Media & Gallery</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Change Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>

                <div class="flex items-center gap-4">
                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                    <span class="text-xs text-slate-400">Current Featured Image</span>
                </div>
            </div>

            <!-- Existing Gallery Images List with Delete Action -->
            @if($product->images->count() > 0)
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Current Gallery Images</label>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                        @foreach($product->images as $gImg)
                            <div class="relative rounded-2xl overflow-hidden border border-slate-200 group">
                                <img src="{{ $gImg->image_url }}" alt="Gallery" class="w-full h-20 object-cover">
                                <form action="{{ route('admin.products.delete-image', $gImg->id) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition" onsubmit="return confirmDelete(event, 'Remove this gallery image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] shadow">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload More Gallery Images</label>
                <input type="file" name="gallery_images[]" multiple accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-800 hover:file:text-white transition">
            </div>
        </div>

        <!-- Publication & SEO Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-globe text-emerald-600"></i>
                <span>Publication & SEO Settings</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Publishing Status *</label>
                    <select name="status" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sort Priority (Order)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                        <span class="text-xs font-bold text-navy">Feature on Homepage</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description', $product->meta_description) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3.5 !px-8 shadow-xl shadow-blue-600/30">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Formulation</span>
            </button>
        </div>

    </form>

@endsection

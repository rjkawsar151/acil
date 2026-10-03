@extends('layouts.admin')

@section('page_title', 'Add New Formulation')
@section('page_subtitle', 'Create a new SINODA product with specifications and gallery')

@section('content')

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl space-y-8">
        @csrf

        <!-- Basic Information Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-flask text-brand-blue"></i>
                <span>Basic Product Information</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. SINODA Professional Keratin Restoring Shampoo">
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SKU Code</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="ACL-SND-SH01">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', 'SINODA') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Custom Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="auto-generated-if-blank">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Overview / Subtitle</label>
                <textarea name="short_description" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Concise 1-2 sentence description for product cards...">{{ old('short_description') }}</textarea>
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
                    <input type="text" name="available_sizes" value="{{ old('available_sizes') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. 250ml, 500ml, 1000ml (Salon Bulk)">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">pH Level Spec</label>
                    <input type="text" name="ph_level" value="{{ old('ph_level', '5.5 ± 0.2') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. 5.5 ± 0.2 (Isodermic)">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Color & Physical Appearance</label>
                    <input type="text" name="color_appearance" value="{{ old('color_appearance') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Pearly opalescent viscous fluid">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Scientific Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="In-depth chemical mechanism and formulation properties...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Key Product Benefits (Bullet points)</label>
                    <textarea name="benefits" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="• Deeply strengthens damaged hair cuticles&#10;• Restores lipid balance">{{ old('benefits') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Usage & Application Instructions</label>
                    <textarea name="usage_information" rows="4" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Massage into wet scalp for 2 minutes and rinse...">{{ old('usage_information') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">INCI Ingredients / Formulation</label>
                    <textarea name="ingredients_information" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs" placeholder="Aqua, Sodium Laureth Sulfate, Hydrolyzed Keratin...">{{ old('ingredients_information') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Packaging & Storage Specifications</label>
                    <textarea name="packaging_information" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="HDPE recyclable bottle with precision dispensing pump...">{{ old('packaging_information') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Media & PDF Brochure Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-heading font-bold text-base text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-images text-purple-600"></i>
                <span>Product Media & Documentation</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Primary Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">PDF Technical Brochure</label>
                    <input type="file" name="brochure" accept=".pdf" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-600 hover:file:text-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Additional Gallery Images (Multiple)</label>
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
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (Visible)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sort Priority (Order)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                        <span class="text-xs font-bold text-navy">Feature on Homepage</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Custom page title for Google">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Summary snippet for search engines">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3.5 !px-8 shadow-xl shadow-blue-600/30">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Formulation</span>
            </button>
        </div>

    </form>

@endsection

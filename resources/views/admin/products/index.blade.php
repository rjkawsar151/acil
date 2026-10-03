@extends('layouts.admin')

@section('page_title', 'Product Formulations')
@section('page_subtitle', 'Manage SINODA catalog, specifications, gallery, and stock status')

@section('content')

    <!-- Top Action Bar & Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab !== 'trashed' ? 'bg-brand-blue text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Active Products ({{ \App\Models\Product::count() }})
            </a>
            <a href="{{ route('admin.products.index', ['tab' => 'trashed']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'trashed' ? 'bg-rose-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                <i class="fa-solid fa-trash-can mr-1"></i> Trash ({{ $trashedCount }})
            </a>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Formulation</span>
        </a>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="sm:col-span-5 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, SKU, or ingredient..." class="w-full text-xs py-2.5 pl-9 pr-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </div>

            <div class="sm:col-span-4">
                <select name="category_id" onchange="this.form.submit()" class="w-full text-xs py-2.5 px-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3 flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="w-full text-xs py-2.5 px-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    <option value="">All Statuses</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                @if($search || $categoryId || $status)
                    <a href="{{ route('admin.products.index', ['tab' => $tab]) }}" class="p-2.5 text-slate-400 hover:text-rose-500" title="Reset Filters">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Product</th>
                        <th class="py-4 px-4">Category</th>
                        <th class="py-4 px-4">SKU / Sizes</th>
                        <th class="py-4 px-4 text-center">Featured</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-navy leading-snug">{{ $product->name }}</h4>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $product->brand ?? 'SINODA' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                    {{ $product->category->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-mono font-bold text-slate-800">{{ $product->sku ?: '—' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $product->available_sizes ?: 'Standard' }}</p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if(!$product->trashed())
                                    <button onclick="toggleFeatured({{ $product->id }}, this)" class="text-lg transition {{ $product->is_featured ? 'text-amber-400 hover:text-slate-300' : 'text-slate-300 hover:text-amber-400' }}" title="Toggle Featured">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $product->status === 'active' ? 'bg-emerald-100 text-emerald-700' : ($product->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                                @if(!$product->trashed())
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="View live">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Move this product to trash?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Trash">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white font-bold transition text-xs">
                                            <i class="fa-solid fa-rotate-left"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Permanently delete this product from database? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white font-bold transition text-xs">
                                            <i class="fa-solid fa-trash-can"></i> Delete Permanently
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-600">No products found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function toggleFeatured(id, btn) {
        fetch(`/admin/products/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.is_featured) {
                btn.classList.add('text-amber-400');
                btn.classList.remove('text-slate-300');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-slate-300');
            }
        });
    }
</script>
@endpush

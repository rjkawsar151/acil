@extends('layouts.admin')

@section('page_title', 'Add New Hero Slide')
@section('page_subtitle', 'Create a new slide for the homepage hero carousel')

@section('content')

    <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf

        <!-- 1. Main Heading & Subtitle -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <h3 class="text-sm font-bold text-navy uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-heading text-brand-blue"></i>
                <span>Slide Heading & Information</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Slide Title / Main Heading *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Adonis Chemical Industries Ltd" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $nextOrder ?? 1) }}" min="0" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle / Descriptive Paragraph</label>
                <textarea name="subtitle" rows="3" placeholder="e.g. Leading manufacturer of premium personal care, cosmetics, and industrial chemical formulations in Savar, Bangladesh." class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('subtitle') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                    <span class="text-xs font-bold text-navy">Slide is Active and visible in carousel</span>
                </label>
            </div>
        </div>

        <!-- 2. Badges & Tags -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <h3 class="text-sm font-bold text-navy uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-tags text-cyan-600"></i>
                <span>Badges & Highlights (Top Pill Tags)</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Primary Badge Text</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text') }}" placeholder="e.g. Plant: Genda, Savar, Dhaka" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge FontAwesome Icon</label>
                    <input type="text" name="badge_icon" value="{{ old('badge_icon', 'fa-solid fa-industry') }}" placeholder="e.g. fa-solid fa-industry" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Color Theme</label>
                    <select name="badge_color" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="blue" {{ old('badge_color') == 'blue' ? 'selected' : '' }}>Corporate Blue</option>
                        <option value="cyan" {{ old('badge_color') == 'cyan' ? 'selected' : '' }}>SINODA Cyan</option>
                        <option value="emerald" {{ old('badge_color') == 'emerald' ? 'selected' : '' }}>Lab Emerald Green</option>
                        <option value="amber" {{ old('badge_color') == 'amber' ? 'selected' : '' }}>Amber / Gold</option>
                        <option value="purple" {{ old('badge_color') == 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="red" {{ old('badge_color') == 'red' ? 'selected' : '' }}>Rose Red</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Secondary Pill / Tag (Optional)</label>
                <input type="text" name="badge_subtext" value="{{ old('badge_subtext') }}" placeholder="e.g. A Concern of Adonis Group or 450+ Partner Salons" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
            </div>
        </div>

        <!-- 3. Call to Action (CTA) Buttons -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="text-sm font-bold text-navy uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-arrow-pointer text-brand-red"></i>
                <span>Slide Action Buttons</span>
            </h3>

            <!-- Button 1 -->
            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 space-y-4">
                <h4 class="text-xs font-bold text-navy uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span> Primary Action Button
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Button Label</label>
                        <input type="text" name="button_text" value="{{ old('button_text', 'Explore Our Products') }}" placeholder="e.g. Explore Our Products" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Destination URL / Route</label>
                        <input type="text" name="button_url" value="{{ old('button_url', '/products') }}" placeholder="e.g. /products or https://..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Button Icon</label>
                        <input type="text" name="button_icon" value="{{ old('button_icon', 'fa-solid fa-flask') }}" placeholder="fa-solid fa-flask" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Color Theme</label>
                        <select name="button_style" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                            <option value="primary" {{ old('button_style') == 'primary' ? 'selected' : '' }}>Corporate Blue</option>
                            <option value="cyan" {{ old('button_style') == 'cyan' ? 'selected' : '' }}>Cyan</option>
                            <option value="emerald" {{ old('button_style') == 'emerald' ? 'selected' : '' }}>Emerald</option>
                            <option value="red" {{ old('button_style') == 'red' ? 'selected' : '' }}>Red</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Button 2 -->
            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 space-y-4">
                <h4 class="text-xs font-bold text-navy uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-600"></span> Secondary Action Button
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Button Label</label>
                        <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text', 'Products Catalogue') }}" placeholder="e.g. Products Catalogue" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Destination URL / Route</label>
                        <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', '/catalogue') }}" placeholder="e.g. /catalogue" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Button Icon</label>
                        <input type="text" name="secondary_button_icon" value="{{ old('secondary_button_icon', 'fa-solid fa-file-pdf') }}" placeholder="fa-solid fa-file-pdf" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Color Theme</label>
                        <select name="secondary_button_style" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                            <option value="red" {{ old('secondary_button_style') == 'red' ? 'selected' : '' }}>Corporate Red</option>
                            <option value="dark" {{ old('secondary_button_style') == 'dark' ? 'selected' : '' }}>Slate Dark Outline</option>
                            <option value="primary" {{ old('secondary_button_style') == 'primary' ? 'selected' : '' }}>Corporate Blue</option>
                            <option value="cyan" {{ old('secondary_button_style') == 'cyan' ? 'selected' : '' }}>Cyan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Button 3 -->
            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 space-y-4">
                <h4 class="text-xs font-bold text-navy uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-slate-600"></span> Tertiary Link / Contact Button (Optional)
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Button Label</label>
                        <input type="text" name="tertiary_button_text" value="{{ old('tertiary_button_text') }}" placeholder="e.g. Contact Factory" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Destination URL / Route</label>
                        <input type="text" name="tertiary_button_url" value="{{ old('tertiary_button_url') }}" placeholder="e.g. /contact" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Background Image -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <h3 class="text-sm font-bold text-navy uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-image text-purple-600"></i>
                <span>Slide Background Image</span>
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload High-Res Photo (Recommended: 1600×900 or 1920×1080 WebP/JPG)</label>
                    <input type="file" name="image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>

                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-slate-400 text-xs uppercase font-bold">OR Direct Image URL</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Image Web Link / Unsplash URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.hero-slides.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6 inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Slide</span>
            </button>
        </div>

    </form>

@endsection

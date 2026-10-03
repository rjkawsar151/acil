<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMediaController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Media::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('file_name', 'like', "%{$search}%");
        }

        $media = $query->latest()->paginate(24)->withQueryString();
        $categories = Media::select('category')->distinct()->pluck('category');

        return view('admin.media.index', compact('media', 'categories', 'category', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,gif,pdf,svg|max:10240',
            'category' => 'nullable|string|max:50',
        ]);

        $category = $request->input('category', 'general');

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('media/' . $category, 'public');

                Media::create([
                    'name' => pathinfo($originalName, PATHINFO_FILENAME),
                    'file_name' => $originalName,
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'category' => $category,
                ]);
            }
        }

        return back()->with('success', 'Media file(s) uploaded successfully.');
    }

    public function destroy(Media $medium)
    {
        if (Storage::disk('public')->exists($medium->file_path)) {
            Storage::disk('public')->delete($medium->file_path);
        }

        $medium->delete();
        return back()->with('success', 'Media file deleted.');
    }
}

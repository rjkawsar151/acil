<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        // Helper to mirror file to public/storage
        $mirrorToPublic = function ($relativePath) {
            $source = storage_path('app/public/' . $relativePath);
            $target = public_path('storage/' . $relativePath);
            $targetDir = dirname($target);
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            if (file_exists($source) && !is_link($target)) {
                @copy($source, $target);
            }
        };

        // Handle uploaded images (e.g. logos & homepage images)
        $fileFields = ['site_logo', 'sinoda_logo', 'adonis_group_logo', 'about_image_1', 'about_image_2', 'sinoda_banner_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                Setting::set($field, $path, 'images', 'image');
                $mirrorToPublic($path);
            }
        }

        if ($request->hasFile('catalogue_pdf')) {
            $path = $request->file('catalogue_pdf')->store('catalogue', 'public');
            Setting::set('catalogue_pdf', $path, 'catalogue', 'file');
            $mirrorToPublic($path);
        }

        return back()->with('success', 'Website settings updated successfully.');
    }
}

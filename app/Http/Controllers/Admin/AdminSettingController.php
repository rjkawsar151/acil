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

        // Handle uploaded images (e.g. logos)
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('logos', 'public');
            Setting::set('site_logo', $path, 'logos', 'image');
        }

        if ($request->hasFile('sinoda_logo')) {
            $path = $request->file('sinoda_logo')->store('logos', 'public');
            Setting::set('sinoda_logo', $path, 'logos', 'image');
        }

        if ($request->hasFile('adonis_group_logo')) {
            $path = $request->file('adonis_group_logo')->store('logos', 'public');
            Setting::set('adonis_group_logo', $path, 'logos', 'image');
        }

        if ($request->hasFile('catalogue_pdf')) {
            $path = $request->file('catalogue_pdf')->store('catalogue', 'public');
            Setting::set('catalogue_pdf', $path, 'catalogue', 'file');
        }

        return back()->with('success', 'Website settings updated successfully.');
    }
}

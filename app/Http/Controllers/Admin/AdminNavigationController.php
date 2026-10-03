<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class AdminNavigationController extends Controller
{
    public function index()
    {
        $headerItems = NavigationItem::where('location', 'header')->whereNull('parent_id')->with('children')->orderBy('sort_order', 'asc')->get();
        $footerItems = NavigationItem::where('location', 'footer')->orderBy('sort_order', 'asc')->get();

        return view('admin.navigation.index', compact('headerItems', 'footerItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:250',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'location' => 'required|in:header,footer',
            'target' => 'required|in:_self,_blank',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        NavigationItem::create($validated);

        return redirect()->route('admin.navigation.index')->with('success', 'Navigation link created successfully.');
    }

    public function update(Request $request, $id)
    {
        $navigation = NavigationItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:250',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'location' => 'required|in:header,footer',
            'target' => 'required|in:_self,_blank',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $navigation->update($validated);

        return redirect()->route('admin.navigation.index')->with('success', 'Navigation link updated successfully.');
    }

    public function destroy($id)
    {
        $navigation = NavigationItem::find($id);

        if ($navigation) {
            // Unlink or delete all child items
            NavigationItem::where('parent_id', $navigation->id)->delete();
            $navigation->delete();
            return redirect()->route('admin.navigation.index')->with('success', 'Navigation item deleted successfully.');
        }

        return redirect()->route('admin.navigation.index')->with('error', 'Navigation item not found.');
    }
}

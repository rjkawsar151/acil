<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductInquiry;
use Illuminate\Http\Request;

class AdminProductInquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $productId = $request->query('product_id');
        $search = $request->query('search');

        $query = ProductInquiry::with('product');

        if ($status) {
            $query->where('status', $status);
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()->paginate(15)->withQueryString();
        $products = Product::all();
        $unreadCount = ProductInquiry::unread()->count();

        return view('admin.inquiries.index', compact('inquiries', 'products', 'status', 'productId', 'search', 'unreadCount'));
    }

    public function show(ProductInquiry $productInquiry)
    {
        if (!$productInquiry->is_read) {
            $productInquiry->update(['is_read' => true]);
        }
        return view('admin.inquiries.show', ['inquiry' => $productInquiry]);
    }

    public function updateStatus(Request $request, ProductInquiry $productInquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,contacted,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $productInquiry->update($validated);

        return back()->with('success', 'Inquiry status updated.');
    }

    public function destroy(ProductInquiry $productInquiry)
    {
        $productInquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}

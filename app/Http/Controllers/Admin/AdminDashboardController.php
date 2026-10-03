<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'total_inquiries' => ProductInquiry::count(),
            'unread_inquiries' => ProductInquiry::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'published_blogs' => Blog::where('status', 'published')->count(),
            'draft_blogs' => Blog::where('status', 'draft')->count(),
            'admin_users' => User::count(),
        ];

        $recentInquiries = ProductInquiry::with('product')->latest()->take(6)->get();
        $recentMessages = ContactMessage::latest()->take(6)->get();
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        // Monthly inquiries statistics for visual chart
        $monthlyInquiries = ProductInquiry::select(
            DB::raw('MONTH(created_at) as month_num'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_num')
        ->pluck('total', 'month_num')
        ->toArray();

        $categoryDistribution = Category::withCount('products')->get()->pluck('products_count', 'name')->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'recentInquiries',
            'recentMessages',
            'recentProducts',
            'monthlyInquiries',
            'categoryDistribution'
        ));
    }
}

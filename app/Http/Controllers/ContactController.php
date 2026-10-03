<?php

namespace App\Http\Controllers;

use App\Mail\ProductInquiryAlert;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\SeoSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function index()
    {
        $settings = [
            'factory_location' => Setting::get('factory_location', 'Genda, Savar, Dhaka, Bangladesh'),
            'corporate_office' => Setting::get('corporate_office', 'Adonis Tower, Uttara, Dhaka, Bangladesh'),
            'contact_email' => Setting::get('contact_email', 'info@adonischemical.com'),
            'sales_email' => Setting::get('sales_email', 'sales@adonischemical.com'),
            'contact_phone' => Setting::get('contact_phone', '+880 1810-000000'),
            'hotline_phone' => Setting::get('hotline_phone', '+880 9612-000000'),
            'working_hours' => Setting::get('working_hours', 'Sunday – Thursday: 9:00 AM – 6:00 PM'),
            'google_maps_embed' => Setting::get('google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14596.126881792376!2d90.25268045!3d23.8529241'),
        ];
        $seo = SeoSetting::getForPage('contact');

        return view('frontend.contact', compact('settings', 'seo'));
    }

    public function inquiryPage(Request $request)
    {
        $selectedProduct = null;
        if ($request->filled('product')) {
            $selectedProduct = Product::where('slug', $request->query('product'))->first();
        } elseif ($request->filled('product_id')) {
            $selectedProduct = Product::find($request->query('product_id'));
        }

        $categories = Category::with(['activeProducts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])->active()->orderBy('sort_order', 'asc')->get();

        $settings = [
            'factory_location' => Setting::get('factory_location', 'Genda, Savar, Dhaka, Bangladesh'),
            'corporate_office' => Setting::get('corporate_office', 'Adonis Tower, Uttara, Dhaka, Bangladesh'),
            'contact_email' => Setting::get('contact_email', 'info@adonischemical.com'),
            'sales_email' => Setting::get('sales_email', 'sales@adonischemical.com'),
            'contact_phone' => Setting::get('contact_phone', '+880 1810-000000'),
            'hotline_phone' => Setting::get('hotline_phone', '+880 9612-000000'),
            'working_hours' => Setting::get('working_hours', 'Sunday – Thursday: 9:00 AM – 6:00 PM'),
        ];

        $seo = SeoSetting::getForPage('inquiry');

        return view('frontend.inquiry', compact('selectedProduct', 'categories', 'settings', 'seo'));
    }

    public function submitContact(Request $request)
    {
        // 1. Honeypot protection
        if (!empty($request->input('website_url_hp'))) {
            // Silently return success to bot
            return back()->with('success', 'Thank you! Your message has been received.');
        }

        // 2. Rate limiting (max 5 submissions per minute per IP)
        $ip = $request->ip();
        $key = 'contact_submission:' . $ip;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many submissions. Please wait {$seconds} seconds before sending another message.")->withInput();
        }
        RateLimiter::hit($key, 60);

        // 3. Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'company' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'required|email|max:150',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:10|max:3000',
        ]);

        $validated['company'] = !empty($validated['company']) ? trim($validated['company']) : null;
        $validated['phone'] = !empty($validated['phone']) ? trim($validated['phone']) : null;
        $validated['subject'] = !empty($validated['subject']) ? trim($validated['subject']) : null;
        $validated['ip_address'] = $ip;
        ContactMessage::create($validated);

        return back()->with('success', 'Thank you for reaching out! A representative from Adonis Chemical Limited will respond to your inquiry shortly.');
    }

    public function submitInquiry(Request $request)
    {
        // Honeypot check
        if (!empty($request->input('inquiry_bot_check'))) {
            return back()->with('success', 'Thank you for your product inquiry.');
        }

        // Rate limiting
        $ip = $request->ip();
        $key = 'product_inquiry:' . $ip;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many requests. Please wait {$seconds} seconds.")->withInput();
        }
        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'product_id' => 'nullable',
            'product_name' => 'nullable|string|max:200',
            'name' => 'required|string|max:100',
            'company' => 'nullable|string|max:150',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:150',
            'quantity_requirement' => 'nullable|string|max:150',
            'message' => 'required|string|min:10|max:3000',
        ]);

        $productId = !empty($validated['product_id']) && is_numeric($validated['product_id']) ? (int)$validated['product_id'] : null;
        $productName = !empty($validated['product_name']) ? trim($validated['product_name']) : null;

        if ($productId && empty($productName)) {
            $product = Product::find($productId);
            if ($product) {
                $productName = $product->name;
            }
        }

        $validated['product_id'] = $productId;
        $validated['product_name'] = $productName;
        $validated['company'] = !empty($validated['company']) ? trim($validated['company']) : null;
        $validated['quantity_requirement'] = !empty($validated['quantity_requirement']) ? trim($validated['quantity_requirement']) : null;
        $validated['ip_address'] = $ip;

        $inquiry = ProductInquiry::create($validated);

        // Send alert emails to configured recipients from .env (e.g. mail1@mail.com,mail2@mail.com)
        $alertEmailsConfig = env('INQUIRY_ALERT_EMAILS', config('mail.inquiry_alert_emails'));
        if ($alertEmailsConfig) {
            $recipients = array_filter(array_map('trim', explode(',', (string)$alertEmailsConfig)));
            if (!empty($recipients)) {
                try {
                    Mail::to($recipients)->send(new ProductInquiryAlert($inquiry));
                } catch (\Throwable $e) {
                    Log::error('Failed to send Product Inquiry alert email: ' . $e->getMessage(), [
                        'inquiry_id' => $inquiry->id,
                        'recipients' => $recipients
                    ]);
                }
            }
        }

        return back()->with('success', 'Your product requirement has been submitted. Our commercial division will reach out with technical details and quotation.');
    }
}

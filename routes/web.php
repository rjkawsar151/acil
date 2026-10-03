<?php

use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBlogCategoryController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCompanyStatisticController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Admin\AdminManufacturingController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminNavigationController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductInquiryController;
use App\Http\Controllers\Admin\AdminQualityController;
use App\Http\Controllers\Admin\AdminSeoController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSocialLinkController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SinodaController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{slug}', [ProductController::class, 'category'])->name('categories.show');
Route::get('/sinoda', [SinodaController::class, 'index'])->name('sinoda');
Route::get('/catalogue', [PageController::class, 'catalogue'])->name('catalogue');
Route::get('/manufacturing', [PageController::class, 'manufacturing'])->name('manufacturing');
Route::get('/quality', [PageController::class, 'quality'])->name('quality');
Route::get('/rd', [PageController::class, 'rd'])->name('rd');
Route::get('/sustainability', [PageController::class, 'sustainability'])->name('sustainability');
Route::get('/adonis-group', [PageController::class, 'adonisGroup'])->name('adonis-group');
Route::get('/applications', [PageController::class, 'applications'])->name('applications');
Route::get('/news', [BlogController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [BlogController::class, 'show'])->name('news.show');
Route::get('/news/category/{slug}', [BlogController::class, 'category'])->name('news.category');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitContact'])->name('contact.submit');
Route::post('/inquiry', [ContactController::class, 'submitInquiry'])->name('inquiry.submit');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [AdminAuthController::class, 'updatePassword'])->name('password.update');

        // Products & Categories
        Route::post('/products/{id}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::post('/products/{id}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
        Route::delete('/products/images/{id}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
        Route::resource('products', AdminProductController::class);

        Route::post('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::resource('categories', AdminCategoryController::class);

        // Content Management
        Route::resource('applications', AdminApplicationController::class);
        Route::resource('pages', AdminPageController::class);
        Route::resource('statistics', AdminCompanyStatisticController::class);
        Route::resource('manufacturing', AdminManufacturingController::class);
        Route::resource('quality', AdminQualityController::class);

        // Homepage CMS
        Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage.index');
        Route::get('/homepage/{homepage}/edit', [AdminHomepageController::class, 'edit'])->name('homepage.edit');
        Route::put('/homepage/{homepage}', [AdminHomepageController::class, 'update'])->name('homepage.update');
        Route::post('/homepage/{homepage}/toggle', [AdminHomepageController::class, 'toggle'])->name('homepage.toggle');

        // Blog CMS
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('blog-categories', AdminBlogCategoryController::class);

        // Messages & Inquiries
        Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::put('/messages/{contactMessage}/status', [AdminContactMessageController::class, 'updateStatus'])->name('messages.update-status');
        Route::delete('/messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('/inquiries', [AdminProductInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{productInquiry}', [AdminProductInquiryController::class, 'show'])->name('inquiries.show');
        Route::put('/inquiries/{productInquiry}/status', [AdminProductInquiryController::class, 'updateStatus'])->name('inquiries.update-status');
        Route::delete('/inquiries/{productInquiry}', [AdminProductInquiryController::class, 'destroy'])->name('inquiries.destroy');

        // Media Library
        Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{medium}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        // Site Navigation & Social
        Route::get('/navigation', [AdminNavigationController::class, 'index'])->name('navigation.index');
        Route::post('/navigation', [AdminNavigationController::class, 'store'])->name('navigation.store');
        Route::put('/navigation/{id}', [AdminNavigationController::class, 'update'])->name('navigation.update');
        Route::delete('/navigation/{id}', [AdminNavigationController::class, 'destroy'])->name('navigation.destroy');
        Route::post('/navigation/{id}/delete', [AdminNavigationController::class, 'destroy'])->name('navigation.destroy.post');

        Route::get('/social-links', [AdminSocialLinkController::class, 'index'])->name('social-links.index');
        Route::post('/social-links', [AdminSocialLinkController::class, 'store'])->name('social-links.store');
        Route::put('/social-links/{socialLink}', [AdminSocialLinkController::class, 'update'])->name('social-links.update');
        Route::delete('/social-links/{socialLink}', [AdminSocialLinkController::class, 'destroy'])->name('social-links.destroy');

        // Settings & SEO
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
        Route::get('/seo/{seo}/edit', [AdminSeoController::class, 'edit'])->name('seo.edit');
        Route::put('/seo/{seo}', [AdminSeoController::class, 'update'])->name('seo.update');

        // User Management
        Route::resource('users', AdminUserController::class);
    });
});

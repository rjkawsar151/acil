<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $products = Product::active()->get();
        $categories = Category::active()->get();
        $blogs = Blog::published()->get();
        $pages = Page::published()->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $staticRoutes = [
            '/',
            '/about',
            '/products',
            '/sinoda',
            '/manufacturing',
            '/quality',
            '/rd',
            '/sustainability',
            '/adonis-group',
            '/news',
            '/contact',
        ];

        foreach ($staticRoutes as $route) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($route) . '</loc>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        foreach ($products as $p) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/products/' . $p->slug) . '</loc>';
            $xml .= '<lastmod>' . $p->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        foreach ($categories as $c) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/categories/' . $c->slug) . '</loc>';
            $xml .= '<lastmod>' . $c->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        foreach ($blogs as $b) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/news/' . $b->slug) . '</loc>';
            $xml .= '<lastmod>' . $b->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($robots, 200)->header('Content-Type', 'text/plain');
    }
}

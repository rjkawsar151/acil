<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Adonis Chemical Industries Ltd',
                'subtitle' => 'Leading manufacturer of premium personal care, cosmetics, and industrial chemical formulations in Savar, Bangladesh.',
                'badge_text' => 'Plant: Genda, Savar, Dhaka',
                'badge_icon' => 'fa-solid fa-industry',
                'badge_color' => 'blue',
                'badge_subtext' => 'A Concern of Adonis Group',
                'button_text' => 'Explore Our Products',
                'button_url' => '/products',
                'button_icon' => 'fa-solid fa-flask',
                'button_style' => 'primary',
                'secondary_button_text' => 'Products Catalogue',
                'secondary_button_url' => '/catalogue',
                'secondary_button_icon' => 'fa-solid fa-file-pdf',
                'secondary_button_style' => 'red',
                'tertiary_button_text' => 'Contact Factory',
                'tertiary_button_url' => '/contact',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'SINODA Personal Care & Salon Line',
                'subtitle' => 'Formulated with bio-active keratin and pure botanicals for hair care, skin hydration, and professional salon grooming.',
                'badge_text' => 'Flagship Cosmetic Brand',
                'badge_icon' => 'fa-solid fa-star',
                'badge_color' => 'cyan',
                'badge_subtext' => '450+ Partner Salons',
                'button_text' => 'Discover SINODA Brand',
                'button_url' => '/sinoda',
                'button_icon' => 'fa-solid fa-sparkles',
                'button_style' => 'cyan',
                'secondary_button_text' => 'Download Catalogue (PDF)',
                'secondary_button_url' => '/catalogue',
                'secondary_button_icon' => 'fa-solid fa-file-pdf',
                'secondary_button_style' => 'red',
                'tertiary_button_text' => null,
                'tertiary_button_url' => null,
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Advanced Chemical Formulation & Lab',
                'subtitle' => 'Operating 316L stainless steel reaction vessels, multi-stage RO deionized water, and batch-by-batch laboratory validation.',
                'badge_text' => 'GMP & ISO Protocols',
                'badge_icon' => 'fa-solid fa-circle-check',
                'badge_color' => 'emerald',
                'badge_subtext' => '50,000+ L Monthly Capacity',
                'button_text' => 'Savar Facility Overview',
                'button_url' => '/manufacturing',
                'button_icon' => 'fa-solid fa-industry',
                'button_style' => 'primary',
                'secondary_button_text' => 'Quality Assurance Lab',
                'secondary_button_url' => '/quality',
                'secondary_button_icon' => 'fa-solid fa-vial-circle-check',
                'secondary_button_style' => 'dark',
                'tertiary_button_text' => null,
                'tertiary_button_url' => null,
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}

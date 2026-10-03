<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\CompanyStatistic;
use App\Models\HomepageSection;
use App\Models\ManufacturingSection;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Permission;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\QualitySection;
use App\Models\Role;
use App\Models\SeoSetting;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $superAdminRole = Role::create([
            'name' => 'Super Administrator',
            'slug' => 'super-admin',
            'description' => 'Full administrative access across all modules and settings.',
        ]);

        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'General administration rights including products, content, and inquiries.',
        ]);

        $productManagerRole = Role::create([
            'name' => 'Product Manager',
            'slug' => 'product-manager',
            'description' => 'Manages products, categories, catalogs, and product inquiries.',
        ]);

        $contentManagerRole = Role::create([
            'name' => 'Content Manager',
            'slug' => 'content-manager',
            'description' => 'Manages blogs, dynamic pages, homepage sections, and media.',
        ]);

        $permissions = [
            // Products
            ['name' => 'View Products', 'slug' => 'products.view', 'group' => 'Products'],
            ['name' => 'Create Products', 'slug' => 'products.create', 'group' => 'Products'],
            ['name' => 'Edit Products', 'slug' => 'products.edit', 'group' => 'Products'],
            ['name' => 'Delete Products', 'slug' => 'products.delete', 'group' => 'Products'],
            // Categories
            ['name' => 'Manage Categories', 'slug' => 'categories.manage', 'group' => 'Categories'],
            // Content & Pages
            ['name' => 'Manage Pages', 'slug' => 'pages.manage', 'group' => 'Content'],
            ['name' => 'Manage Blogs', 'slug' => 'blogs.manage', 'group' => 'Content'],
            ['name' => 'Manage Sections', 'slug' => 'sections.manage', 'group' => 'Content'],
            // Communications
            ['name' => 'View Messages', 'slug' => 'messages.view', 'group' => 'Communication'],
            ['name' => 'Manage Inquiries', 'slug' => 'inquiries.manage', 'group' => 'Communication'],
            // System
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'group' => 'Administration'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'group' => 'Administration'],
            ['name' => 'Media Library', 'slug' => 'media.manage', 'group' => 'Media'],
        ];

        foreach ($permissions as $p) {
            $createdPerm = Permission::create($p);
            $superAdminRole->permissions()->attach($createdPerm->id);
            $adminRole->permissions()->attach($createdPerm->id);
            if (str_starts_with($p['slug'], 'products.') || str_starts_with($p['slug'], 'categories.') || $p['slug'] === 'inquiries.manage') {
                $productManagerRole->permissions()->attach($createdPerm->id);
            }
            if (str_starts_with($p['slug'], 'pages.') || str_starts_with($p['slug'], 'blogs.') || str_starts_with($p['slug'], 'sections.') || $p['slug'] === 'media.manage') {
                $contentManagerRole->permissions()->attach($createdPerm->id);
            }
        }

        // 2. Users
        $admin = User::create([
            'name' => 'Executive Administrator',
            'email' => 'admin@adonischemical.com',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'phone' => '+880 1711-000000',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Product Director',
            'email' => 'products@adonischemical.com',
            'password' => Hash::make('password'),
            'role_id' => $productManagerRole->id,
            'phone' => '+880 1712-111111',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Editorial Lead',
            'email' => 'editor@adonischemical.com',
            'password' => Hash::make('password'),
            'role_id' => $contentManagerRole->id,
            'phone' => '+880 1713-222222',
            'is_active' => true,
        ]);

        // 3. Settings
        $settingsData = [
            ['key' => 'site_name', 'value' => 'Adonis Chemical Limited', 'group' => 'general', 'label' => 'Company Name'],
            ['key' => 'site_tagline', 'value' => 'Science Behind Better Products', 'group' => 'general', 'label' => 'Tagline / Slogan'],
            ['key' => 'parent_group', 'value' => 'Adonis Group', 'group' => 'company', 'label' => 'Parent Organization'],
            ['key' => 'brand_name', 'value' => 'SINODA', 'group' => 'company', 'label' => 'Primary Brand'],
            ['key' => 'factory_location', 'value' => 'Genda, Savar, Dhaka-1340, Bangladesh', 'group' => 'contact', 'label' => 'Manufacturing Facility Address'],
            ['key' => 'corporate_office', 'value' => 'Adonis Tower, Plot 14, Sector 7, Uttara / Dhaka, Bangladesh', 'group' => 'contact', 'label' => 'Corporate Head Office'],
            ['key' => 'contact_email', 'value' => 'info@adonischemical.com', 'group' => 'contact', 'label' => 'Primary Email'],
            ['key' => 'sales_email', 'value' => 'sales@adonischemical.com', 'group' => 'contact', 'label' => 'Sales & Distribution Email'],
            ['key' => 'contact_phone', 'value' => '+880 1810-000000', 'group' => 'contact', 'label' => 'Main Contact Number'],
            ['key' => 'hotline_phone', 'value' => '+880 9612-000000', 'group' => 'contact', 'label' => 'Customer Hotline'],
            ['key' => 'working_hours', 'value' => 'Sunday – Thursday: 9:00 AM – 6:00 PM (GMT+6)', 'group' => 'contact', 'label' => 'Office Hours'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14596.126881792376!2d90.25268045!3d23.8529241!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755ebd85c18c187%3A0x7052dc6cf453b31c!2sGenda%2C%20Savar%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1700000000000', 'group' => 'contact', 'label' => 'Google Map Embed URL'],
            ['key' => 'footer_about', 'value' => 'Adonis Chemical Limited is a leading chemical and personal care manufacturing enterprise under Adonis Group, dedicated to scientific formulation, advanced laboratory standards, and top-tier product quality for salon professionals and consumers worldwide.', 'group' => 'general', 'label' => 'Footer Description'],
            ['key' => 'copyright_text', 'value' => '© ' . date('Y') . ' Adonis Chemical Limited. A Concern of Adonis Group. All Rights Reserved.', 'group' => 'general', 'label' => 'Copyright Notice'],
        ];

        foreach ($settingsData as $s) {
            Setting::create($s);
        }

        // 4. Social Links
        $socialLinks = [
            ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => 'https://facebook.com/adonischemicallimited', 'sort_order' => 1],
            ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => 'https://linkedin.com/company/adonis-chemical-limited', 'sort_order' => 2],
            ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => 'https://instagram.com/sinoda_care', 'sort_order' => 3],
            ['platform' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => 'https://youtube.com/@adonisgroup', 'sort_order' => 4],
        ];
        foreach ($socialLinks as $sl) {
            SocialLink::create($sl);
        }

        // 5. Navigation Items
        $navItems = [
            ['title' => 'Home', 'url' => '/', 'location' => 'header', 'sort_order' => 1],
            ['title' => 'About Us', 'url' => '/about', 'location' => 'header', 'sort_order' => 2],
            ['title' => 'Products', 'url' => '/products', 'location' => 'header', 'sort_order' => 3],
            ['title' => 'SINODA Brand', 'url' => '/sinoda', 'location' => 'header', 'sort_order' => 4],
            ['title' => 'Manufacturing', 'url' => '/manufacturing', 'location' => 'header', 'sort_order' => 5],
            ['title' => 'Quality Assurance', 'url' => '/quality', 'location' => 'header', 'sort_order' => 6],
            ['title' => 'R&D', 'url' => '/rd', 'location' => 'header', 'sort_order' => 7],
            ['title' => 'Sustainability', 'url' => '/sustainability', 'location' => 'header', 'sort_order' => 8],
            ['title' => 'News & Insights', 'url' => '/news', 'location' => 'header', 'sort_order' => 9],
            ['title' => 'Contact', 'url' => '/contact', 'location' => 'header', 'sort_order' => 10],
        ];
        foreach ($navItems as $ni) {
            NavigationItem::create($ni);
        }

        // 6. Company Statistics
        $stats = [
            [
                'title' => 'Years of Excellence',
                'value' => '15',
                'suffix' => '+',
                'prefix' => '',
                'icon' => 'award',
                'description' => 'Dedicated scientific formulation & industrial chemistry expertise in Bangladesh.',
                'sort_order' => 1,
            ],
            [
                'title' => 'SINODA Formulations',
                'value' => '65',
                'suffix' => '+',
                'prefix' => '',
                'icon' => 'flask',
                'description' => 'Active commercial chemical, personal care, and salon-grade formulas.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Monthly Production',
                'value' => '50,000',
                'suffix' => ' L+',
                'prefix' => '',
                'icon' => 'industry',
                'description' => 'Modern batching and automated packaging capacity at Savar plant.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Salon & Enterprise Partners',
                'value' => '450',
                'suffix' => '+',
                'prefix' => '',
                'icon' => 'handshake',
                'description' => 'Trusted distribution network supplying high-demand salon and grooming products.',
                'sort_order' => 4,
            ],
        ];
        foreach ($stats as $st) {
            CompanyStatistic::create($st);
        }

        // 7. Categories
        $categoriesData = [
            [
                'name' => 'Hair Care Formulations',
                'slug' => 'hair-care',
                'description' => 'Scientifically engineered shampoos, deep nourishing hair oils, keratin treatments, and scalp therapy solutions.',
                'badge_text' => 'Salon & Consumer',
                'image' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?auto=format&fit=crop&w=800&q=80',
                'icon' => 'sparkles',
                'sort_order' => 1,
            ],
            [
                'name' => 'Skin & Soothing Formulations',
                'slug' => 'skin-care',
                'description' => 'Pure Aloe Vera soothing gels, pure rose water distillates, rejuvenating cleansers, and facial treatment gels.',
                'badge_text' => 'Bio-Active',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'icon' => 'heart',
                'sort_order' => 2,
            ],
            [
                'name' => 'Salon Professional & Styling',
                'slug' => 'salon-professional',
                'description' => 'High-performance hair styling waxes, premium strip and bead hair removing waxes, and professional grooming compounds.',
                'badge_text' => 'Pro Grade',
                'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=800&q=80',
                'icon' => 'scissors',
                'sort_order' => 3,
            ],
            [
                'name' => 'Body Care & Hygiene',
                'slug' => 'body-care',
                'description' => 'Antibacterial and refreshing hand washes, invigorating body washes, exfoliating scrubs, and massage oils.',
                'badge_text' => 'Daily Hygiene',
                'image' => 'https://images.unsplash.com/photo-1608248597359-009a96e62c41?auto=format&fit=crop&w=800&q=80',
                'icon' => 'droplet',
                'sort_order' => 4,
            ],
            [
                'name' => 'Men\'s Grooming & Shaving',
                'slug' => 'mens-grooming',
                'description' => 'Clear precision shaving gels, cooling aftershave balms, beard care elixirs, and masculine shower formulations.',
                'badge_text' => 'Grooming Line',
                'image' => 'https://images.unsplash.com/photo-1621607512214-68297480165e?auto=format&fit=crop&w=800&q=80',
                'icon' => 'shield',
                'sort_order' => 5,
            ],
        ];

        $catModels = [];
        foreach ($categoriesData as $c) {
            $catModels[$c['slug']] = Category::create($c);
        }

        // 8. Products (15+ Real SINODA Chemical & Personal Care Products)
        $productsData = [
            [
                'category_id' => $catModels['hair-care']->id,
                'name' => 'SINODA Professional Keratin Restoring Shampoo',
                'slug' => 'sinoda-professional-keratin-restoring-shampoo',
                'sku' => 'ACL-SND-SH01',
                'brand' => 'SINODA',
                'short_description' => 'Advanced salon-grade micro-keratin shampoo designed to repair cuticle damage, reinforce hair fibers, and restore natural shine.',
                'description' => 'Formulated at the Savar research facility, SINODA Professional Keratin Restoring Shampoo incorporates low-molecular-weight hydrolyzed keratin peptides and gentle cleansing surfactants. It gently cleanses without stripping essential lipids, forming a protective microscopic matrix around each hair shaft to protect against environmental degradation and thermal styling.',
                'benefits' => "• Deeply strengthens brittle and chemically treated hair\n• Sulfate-balanced gentle lather for color-treated strands\n• Enhances elasticity, combability, and luminous gloss\n• Regulates scalp lipid balance without greasy residue",
                'usage_information' => 'Apply generous amount to wet scalp and hair. Massage gently with fingertips into a rich foam for 2 minutes to allow peptide absorption. Rinse thoroughly with lukewarm water. Follow with SINODA Nourishing Conditioner.',
                'ingredients_information' => 'Aqua (Demineralized Water), Sodium Laureth Sulfate (Cosmetic Grade), Hydrolyzed Keratin Protein, Cocamidopropyl Betaine, Polyquaternium-7, Glycerin, D-Panthenol (Pro-Vitamin B5), Citric Acid, Phenoxyethanol, Fragrance.',
                'packaging_information' => 'High-density polyethylene (HDPE) cylindrical bottle with ergonomic dispensing pump. 100% recyclable material.',
                'available_sizes' => '250ml, 500ml, 1000ml (Salon Bulk)',
                'ph_level' => '5.5 ± 0.2 (Isodermic)',
                'color_appearance' => 'Pearly opalescent viscous fluid with clean floral-scientific aroma',
                'featured_image' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'category_id' => $catModels['hair-care']->id,
                'name' => 'SINODA Herbal Botanical Enriching Hair Oil',
                'slug' => 'sinoda-herbal-botanical-enriching-hair-oil',
                'sku' => 'ACL-SND-HO02',
                'brand' => 'SINODA',
                'short_description' => 'Cold-formulated multi-botanical lipid infusion enriched with Vitamin E and essential fatty acids for root nourishment and anti-frizz defense.',
                'description' => 'SINODA Herbal Botanical Enriching Hair Oil is an advanced multi-oil blend synthesized to penetrate follicular junctions. Combining refined mineral lipids, sweet almond oil, and herbal extracts, it arrests scalp dryness, stimulates microcirculation, and forms a non-sticky sheath over hair strands.',
                'benefits' => "• Penetrates scalp pores to deliver deep follicular nutrition\n• Reduces breakage and split ends by up to 68%\n• Ultra-lightweight formula with zero tacky residue\n• Imparts silky smooth finish and natural radiance",
                'usage_information' => 'Dispense 5–10 ml onto clean palms. Distribute evenly across dry or damp hair from roots to tips. For intensive deep-conditioning, leave overnight and wash with SINODA Shampoo.',
                'ingredients_information' => 'Mineral Oil (USP Grade), Prunus Amygdalus Dulcis (Almond) Oil, Emblica Officinalis (Amla) Extract, Eclipta Prostrata (Bhringraj) Extract, Tocopheryl Acetate (Vitamin E), Isopropyl Myristate, Essential Oils.',
                'packaging_information' => 'Transparent PET safety bottle with spill-proof inner plug and protective screw cap.',
                'available_sizes' => '100ml, 200ml, 400ml',
                'ph_level' => 'Neutral Anhydrous Lipid Formula',
                'color_appearance' => 'Golden crystalline liquid with soothing herbal bouquet',
                'featured_image' => 'https://images.unsplash.com/photo-1608248597359-009a96e62c41?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'category_id' => $catModels['salon-professional']->id,
                'name' => 'SINODA Extreme Hold Matte Sculpting Hair Wax',
                'slug' => 'sinoda-extreme-hold-matte-sculpting-hair-wax',
                'sku' => 'ACL-SND-HW03',
                'brand' => 'SINODA',
                'short_description' => 'High-performance micro-crystalline styling wax providing 24-hour ultra-matte hold, pliable texture, and moisture resistance.',
                'description' => 'Engineered specifically for top-tier salons and grooming experts, SINODA Extreme Hold Matte Hair Wax combines microcrystalline beeswax and bentonite clay polymers. It delivers high-definition structural control and texture without flaking, shine, or greasy accumulation.',
                'benefits' => "• All-day strong pliable hold (Grade 5/5)\n• Zero glare natural matte finish\n• Humidity-resistant formulation ideal for tropical climates\n• Water-soluble base washes out effortlessly in one wash",
                'usage_information' => 'Rub a dime-sized amount vigorously between palms until warm. Work through towel-dried or dry hair, sculpting with fingers or comb into desired hairstyle.',
                'ingredients_information' => 'Aqua, Cera Alba (Beeswax), Bentonite, Copernicia Cerifera (Carnauba) Wax, Ceteareth-25, Kaolin Clay, PVP, PEG-40 Hydrogenated Castor Oil, Phenoxyethanol, Parfum.',
                'packaging_information' => 'Double-walled aluminum/polypropylene cosmetic jar with air-tight seal.',
                'available_sizes' => '80g, 150g',
                'ph_level' => '6.0 ± 0.3',
                'color_appearance' => 'Dense creamy off-white clay paste',
                'featured_image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'category_id' => $catModels['salon-professional']->id,
                'name' => 'SINODA Professional Salon Hair Removing Wax',
                'slug' => 'sinoda-professional-salon-hair-removing-wax',
                'sku' => 'ACL-SND-RW04',
                'brand' => 'SINODA',
                'short_description' => 'Ultra-refined depilatory hot wax with low melting point and soothing rosin esters for efficient, low-irritation hair removal.',
                'description' => 'SINODA Hair Removing Wax is developed for professional salon waxing treatments. Its low-temperature melting technology ensures high elasticity, hugging fine and coarse hairs from the root without adhering painfully to live epidermis.',
                'benefits' => "• Low melting point (45°C–48°C) prevents heat discomfort\n• High tensile elasticity prevents mid-strip snapping\n• Enriched with calming chamomile derivatives to minimize redness\n• Suitable for sensitive facial and body contours",
                'usage_information' => 'Heat wax in a professional heater until reaching a smooth honey-like consistency. Test temperature on wrist. Apply thin layer along hair growth direction with wooden spatula. Strip swiftly in opposite direction.',
                'ingredients_information' => 'Colophonium (Refined Rosin), Glyceryl Rosinate, Paraffinum Liquidum, Titanium Dioxide, Chamomilla Recutita Extract, Blue CI 61565.',
                'packaging_information' => 'Heavy-duty tin can / airtight vacuum composite pack.',
                'available_sizes' => '400g Tin, 800g Bulk Tub',
                'ph_level' => 'Non-aqueous polymer melt',
                'color_appearance' => 'Luminescent cyan blue solid resin block / disc beads',
                'featured_image' => 'https://images.unsplash.com/photo-1512290900672-1f02e600572e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'category_id' => $catModels['skin-care']->id,
                'name' => 'SINODA 99% Pure Aloe Vera Soothing Hydration Gel',
                'slug' => 'sinoda-99-pure-aloe-vera-soothing-hydration-gel',
                'sku' => 'ACL-SND-AG05',
                'brand' => 'SINODA',
                'short_description' => 'Multi-purpose bio-active soothing gel packed with polysaccharides and antioxidants for intense hydration, post-sun cooling, and razor relief.',
                'description' => 'Produced using filtered cold-processed Aloe Barbadensis leaf extract, SINODA Aloe Vera Gel delivers instant trans-epidermal moisture without sticky residue. It replenishes compromised skin barriers, accelerates recovery from razor burns, and provides exceptional skin hydration.',
                'benefits' => "• 99% concentrated biological Aloe Vera extract\n• Instantly calms thermal redness, sun exposure, and inflammation\n• Rapidly absorbed gel matrix with refreshing cooling sensation\n• Multi-use for face, neck, body, and post-shave rejuvenation",
                'usage_information' => 'Smooth generously over cleansed skin whenever hydration or calming relief is needed. Can be used as a daily lightweight moisturizer, sleeping mask, or post-wax soothing treatment.',
                'ingredients_information' => 'Aloe Barbadensis Leaf Juice, Carbomer, Glycerin, Triethanolamine, Allantoin, Disodium EDTA, Sodium Hyaluronate, Ethylhexylglycerin.',
                'packaging_information' => 'Clear glass-finish PET tub with protective hygiene disc and screw cap.',
                'available_sizes' => '250ml, 500ml',
                'ph_level' => '5.8 ± 0.2',
                'color_appearance' => 'Crystal clear translucent cooling gel',
                'featured_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'category_id' => $catModels['skin-care']->id,
                'name' => 'SINODA Pure Distilled Steam-Extracted Rose Water',
                'slug' => 'sinoda-pure-distilled-steam-extracted-rose-water',
                'sku' => 'ACL-SND-RW06',
                'brand' => 'SINODA',
                'short_description' => '100% steam-distilled Damask rose hydrosol toner with natural astringent, balancing, and rejuvenating properties.',
                'description' => 'SINODA Rose Water is created through modern hydro-steam distillation of fresh rose petals in our Savar botanical extraction unit. Rich in water-soluble floral polyphenols, it restores natural skin pH, refines pore texture, and delivers invigorating aromatherapy refreshment.',
                'benefits' => "• Natural pore-tightening toner without synthetic alcohol\n• Optimizes skin acid-mantle pH following cleansing\n• Prepares dermal surface for enhanced serum absorption\n• Delicate, authentic Damask rose fragrance",
                'usage_information' => 'Hold spray bottle 6 inches from face with eyes closed and mist evenly over skin. Alternatively, apply with a sterile cotton pad across face and neck after cleansing.',
                'ingredients_information' => 'Rosa Damascena Flower Distillate (Pure Hydrosol), Phenoxyethanol, Potassium Sorbate.',
                'packaging_information' => 'Cobalt blue UV-protective spray bottle with ultra-fine micro-atomizer nozzle.',
                'available_sizes' => '120ml Spray, 250ml, 500ml Refill',
                'ph_level' => '5.2 ± 0.3',
                'color_appearance' => 'Crystal-clear transparent aromatic hydrosol',
                'featured_image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 6,
            ],
            [
                'category_id' => $catModels['skin-care']->id,
                'name' => 'SINODA Deep Pore Purifying Facial Cleanser',
                'slug' => 'sinoda-deep-pore-purifying-facial-cleanser',
                'sku' => 'ACL-SND-FC07',
                'brand' => 'SINODA',
                'short_description' => 'Mild syndet surfactant facial wash with salicylic acid and botanical cleansers to eliminate sebum and particulate pollution.',
                'description' => 'Formulated for daily industrial and urban defense, SINODA Deep Pore Purifying Facial Cleanser micro-emulsifies airborne grime, excess sebum, and makeup residues while safeguarding the delicate cutaneous moisture barrier.',
                'benefits' => "• Micro-cleansing micelles lift micro-particulates effectively\n• Contains 0.5% beta-hydroxy acid (BHA) for unclogged pores\n• Non-drying formulation preserves natural dermal moisture\n• Dermatologically balanced and hypoallergenic",
                'usage_information' => 'Wet face with warm water. Dispense one pump onto wet palms and work into a velvet lather. Massage onto face in circular motions for 60 seconds, then rinse with cool water.',
                'ingredients_information' => 'Aqua, Disodium Cocoyl Glutamate, Coco-Glucoside, Glycerin, Salicylic Acid, Niacinamide, Camellia Sinensis (Green Tea) Leaf Extract, Citric Acid.',
                'packaging_information' => 'Frosted airless pump bottle with secure locking collar.',
                'available_sizes' => '150ml, 300ml',
                'ph_level' => '5.5 ± 0.2',
                'color_appearance' => 'Clear viscous fluid with subtle fresh scent',
                'featured_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 7,
            ],
            [
                'category_id' => $catModels['body-care']->id,
                'name' => 'SINODA Refreshing Ocean Minerals Body Wash',
                'slug' => 'sinoda-refreshing-ocean-minerals-body-wash',
                'sku' => 'ACL-SND-BW08',
                'brand' => 'SINODA',
                'short_description' => 'Energizing daily body cleanser fortified with marine trace minerals, seaweed extracts, and moisturizing emollients.',
                'description' => 'SINODA Ocean Minerals Body Wash delivers a transformative sensory shower experience. Its scientific surfactant blend creates a dense, cushiony lather that purifies skin while infusing magnesium, zinc, and potassium trace minerals.',
                'benefits' => "• Marine bio-mineral complex recharges fatigued skin\n• Gentle sulfate-optimized cleansing with zero tight feel\n• High-efficiency foaming even in hard water conditions\n• Invigorating scientific aquatic fragrance that lasts",
                'usage_information' => 'Squeeze onto a wet sponge or loofah. Work into a creamy lather and massage over whole body. Rinse completely with water.',
                'ingredients_information' => 'Aqua, Sodium Laureth Sulfate, Cocamidopropyl Betaine, Sea Salt Extract, Fucus Vesiculosus Extract, Glycerin, Polyquaternium-10, CI 42090.',
                'packaging_information' => 'Ergonomic slimline bottle with flip-top cap and gripping textured side ribs.',
                'available_sizes' => '250ml, 500ml, 1000ml',
                'ph_level' => '5.7 ± 0.2',
                'color_appearance' => 'Aquamarine transparent gel with shimmering oceanic highlights',
                'featured_image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 8,
            ],
            [
                'category_id' => $catModels['body-care']->id,
                'name' => 'SINODA Anti-Bacterial Moisturizing Hand Wash',
                'slug' => 'sinoda-anti-bacterial-moisturizing-hand-wash',
                'sku' => 'ACL-SND-HW09',
                'brand' => 'SINODA',
                'short_description' => 'Clinical-grade 99.9% germ protection liquid hand wash formulated with skin-nourishing humectants and Vitamin E.',
                'description' => 'Engineered for hospitals, salons, commercial spaces, and households, SINODA Anti-Bacterial Hand Wash eliminates 99.9% of transient pathogenic bacteria within 20 seconds of washing, while protecting against dry, cracked hands.',
                'benefits' => "• Laboratory-proven 99.9% antimicrobial efficacy\n• Triple humectant system prevents dermatitis from frequent washing\n• Instant rich lather with quick-rinse formulation\n• Ideal for institutional and residential high-frequency use",
                'usage_information' => 'Dispense 1-2 pumps onto wet hands. Lather briskly for at least 20 seconds covering palms, backs of hands, fingers, and nails. Rinse thoroughly.',
                'ingredients_information' => 'Aqua, Sodium Laureth Sulfate, Cocamide DEA, Chloroxylenol (PCMX), Glycerin, Vitamin E Acetate, Fragrance, CI 19140.',
                'packaging_information' => 'Heavy-duty 500ml tabletop pump bottle and 5L industrial refill container.',
                'available_sizes' => '250ml, 500ml Pump, 5L Commercial Jerrycan',
                'ph_level' => '6.2 ± 0.3',
                'color_appearance' => 'Luminescent green/blue pearlized viscous liquid',
                'featured_image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 9,
            ],
            [
                'category_id' => $catModels['body-care']->id,
                'name' => 'SINODA Therapeutic Aromatherapy Massage Oil',
                'slug' => 'sinoda-therapeutic-aromatherapy-massage-oil',
                'sku' => 'ACL-SND-MO10',
                'brand' => 'SINODA',
                'short_description' => 'Professional spa-grade lipid glide oil infused with eucalyptus, lavender, and anti-friction triglycerides.',
                'description' => 'SINODA Therapeutic Massage Oil delivers ideal cutaneous glide and controlled absorption for bodywork specialists, wellness clinics, and personal stress relief.',
                'benefits' => "• Extended lubricity and smooth gliding performance\n• Non-comedogenic carrier oils prevent dermal congestion\n• Relieves muscular tension and fatigue\n• Rinses clean with mild soap after treatment",
                'usage_information' => 'Warm required amount between palms. Apply with smooth strokes across back, shoulders, or legs as required.',
                'ingredients_information' => 'Helianthus Annuus Seed Oil, Caprylic/Capric Triglyceride, Eucalyptus Globulus Leaf Oil, Lavandula Angustifolia Oil, Tocopherol.',
                'packaging_information' => 'Dark amber bottle with precision flow-control nozzle.',
                'available_sizes' => '200ml, 500ml, 1000ml (Spa Pack)',
                'ph_level' => 'Neutral Anhydrous Oil',
                'color_appearance' => 'Light golden crystal oil',
                'featured_image' => 'https://images.unsplash.com/photo-1608248597359-009a96e62c41?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 10,
            ],
            [
                'category_id' => $catModels['body-care']->id,
                'name' => 'SINODA Micro-Exfoliating Body Polishing Scrub',
                'slug' => 'sinoda-micro-exfoliating-body-polishing-scrub',
                'sku' => 'ACL-SND-BS11',
                'brand' => 'SINODA',
                'short_description' => 'Refined walnut shell and silica micro-bead exfoliating paste with shea butter for velvety skin transformation.',
                'description' => 'Designed to remove dead keratinized cells and stimulate cellular turnover, SINODA Body Scrub leaves the epidermis remarkably soft, polished, and ready for deep moisture absorption.',
                'benefits' => "• Dual-action physical and biochemical exfoliation\n• Smooths keratosis pilaris and rough skin patches\n• Rich conditioning emollients prevent post-scrub dryness\n• Gentle on sensitive skin",
                'usage_information' => 'Apply to damp skin during bath or shower. Massage gently in circular upward motions for 3-5 minutes, focusing on elbows, knees, and heels. Rinse thoroughly.',
                'ingredients_information' => 'Aqua, Juglans Regia (Walnut) Shell Powder, Hydrated Silica, Cetearyl Alcohol, Butyrospermum Parkii (Shea) Butter, Glycerin, Stearic Acid.',
                'packaging_information' => 'Wide-mouth polypropylene jar with moisture-proof inner seal.',
                'available_sizes' => '300g, 600g',
                'ph_level' => '6.0 ± 0.2',
                'color_appearance' => 'Rich creamy beige exfoliating emulsion with fine particulates',
                'featured_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 11,
            ],
            [
                'category_id' => $catModels['mens-grooming']->id,
                'name' => 'SINODA Clear Precision Shaving Gel',
                'slug' => 'sinoda-clear-precision-shaving-gel',
                'sku' => 'ACL-SND-SG12',
                'brand' => 'SINODA',
                'short_description' => 'Non-foaming see-through glide gel engineered for ultra-precise beard edging, razor protection, and frictionless blade gliding.',
                'description' => 'SINODA Clear Precision Shaving Gel is designed for barbers, groomers, and modern men who demand exact razor alignment. Its clear lubricating matrix lets you see exactly where you are shaving, eliminating nicks, burns, and misalignment.',
                'benefits' => "• 100% transparent matrix for razor edge precision\n• Extreme lubricating film allows single-pass cutting\n• Formulated with cooling menthol and witch hazel\n• Protects against razor burns and ingrown hairs",
                'usage_information' => 'Dispense small amount and apply directly to damp beard or moustache area. Shave with your preferred razor, then rinse clean with cool water.',
                'ingredients_information' => 'Aqua, Glycerin, Propylene Glycol, Carbomer, Hamamelis Virginiana Extract, Menthol, Polysorbate 20, Panthenol, Phenoxyethanol.',
                'packaging_information' => 'Clear stand-up tube with flip-top valve closure.',
                'available_sizes' => '150ml, 300ml, 500ml Salon Pump',
                'ph_level' => '5.6 ± 0.2',
                'color_appearance' => 'Crystal-clear sapphire blue cooling gel',
                'featured_image' => 'https://images.unsplash.com/photo-1621607512214-68297480165e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 12,
            ],
            [
                'category_id' => $catModels['mens-grooming']->id,
                'name' => 'SINODA Cooling Menthol 3-in-1 Active Shower Gel',
                'slug' => 'sinoda-cooling-menthol-3-in-1-active-shower-gel',
                'sku' => 'ACL-SND-SG13',
                'brand' => 'SINODA',
                'short_description' => 'High-performance multi-benefit hair, face, and body wash with cryogenic menthol crystals and charcoal detox.',
                'description' => 'Engineered for athletes and active lifestyles, this 3-in-1 formula eliminates stubborn sweat, odor, and impurities in one step, leaving an invigorating cold sensation that lasts for hours.',
                'benefits' => "• All-in-one head-to-toe convenience\n• Activated charcoal absorbs odor molecules\n• Cryo-menthol blast refreshes tired muscles\n• Fast lathering and effortless clean rinse",
                'usage_information' => 'Pour onto palms or body sponge. Massage across wet hair, face, and body until rich lather develops. Rinse thoroughly.',
                'ingredients_information' => 'Aqua, Sodium Laureth Sulfate, Cocamidopropyl Betaine, Activated Charcoal Powder, Menthol Crystals, Zinc PCA, Polyquaternium-7.',
                'packaging_information' => 'Impact-resistant tactical black HDPE bottle with flip dispenser.',
                'available_sizes' => '250ml, 500ml',
                'ph_level' => '5.5 ± 0.2',
                'color_appearance' => 'Glossy gunmetal gray gel with blue menthol sparkle',
                'featured_image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 13,
            ],
            [
                'category_id' => $catModels['salon-professional']->id,
                'name' => 'SINODA Salon Intensive Hair Repair Keratin Mask',
                'slug' => 'sinoda-salon-intensive-hair-repair-keratin-mask',
                'sku' => 'ACL-SND-KM14',
                'brand' => 'SINODA',
                'short_description' => 'Concentrated polypeptide deep-conditioning mask for salon chemical treatment post-care and extreme hair recovery.',
                'description' => 'Formulated with high concentrations of biomimetic amino acids, argan oil, and ceramides, this salon mask fills intercellular cement gaps in the cortex, reconstructing damaged hair bonds caused by bleach, straightening, and permanent dyes.',
                'benefits' => "• Deep cortex bond reconstruction in just 5 minutes\n• Restores virgin-hair hydrophobicity and softness\n• Shields against 230°C heat styling tools\n• Reduces porosity and eliminates frizz entirely",
                'usage_information' => 'After shampooing, squeeze out excess water. Apply evenly from mid-lengths to ends using a wide-tooth comb. Leave for 5–10 minutes. For deep salon treatment, apply under a steam cap for 15 minutes. Rinse thoroughly.',
                'ingredients_information' => 'Aqua, Cetearyl Alcohol, Behentrimonium Chloride, Hydrolyzed Keratin, Argania Spinosa Kernel Oil, Dimethicone, Ceramide NP, Lactic Acid.',
                'packaging_information' => '500g and 1000g professional salon tubs with inner foil protection.',
                'available_sizes' => '500g, 1000g Salon Tub',
                'ph_level' => '4.2 ± 0.2 (Acidic Cuticle Sealing)',
                'color_appearance' => 'Thick velvety ivory emulsion with luxury scientific scent',
                'featured_image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => 'active',
                'sort_order' => 14,
            ],
            [
                'category_id' => $catModels['skin-care']->id,
                'name' => 'SINODA Soothing Cucumber & Witch Hazel Facial Gel',
                'slug' => 'sinoda-soothing-cucumber-witch-hazel-facial-gel',
                'sku' => 'ACL-SND-CG15',
                'brand' => 'SINODA',
                'short_description' => 'Pore-refining, ultra-light botanical gel infused with Cucumis Sativus juice to minimize puffiness and calm irritated skin.',
                'description' => 'A cooling moisture surge designed for oily, combination, and sensitive skin types. It tightens enlarged pores, controls daytime T-zone sebum, and reduces under-eye puffiness.',
                'benefits' => "• Immediate cooling and vasoconstrictive skin calming\n• Tightens dilated pores with natural witch hazel tannins\n• 100% oil-free hydration for breakout-prone skin\n• Can be chilled in refrigerator for extra depuffing power",
                'usage_information' => 'Apply a thin layer to clean face and under-eye area. Pat gently until absorbed. Can also be applied as an 8-minute flash calming face mask.',
                'ingredients_information' => 'Aqua, Cucumis Sativus (Cucumber) Fruit Extract, Hamamelis Virginiana (Witch Hazel) Extract, Glycerin, Sodium Polyacrylate, Allantoin, Phenoxyethanol.',
                'packaging_information' => 'Frosted PET jar with metallic silver rim cap.',
                'available_sizes' => '200ml, 400ml',
                'ph_level' => '5.6 ± 0.2',
                'color_appearance' => 'Light translucent emerald green jelly',
                'featured_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => 'active',
                'sort_order' => 15,
            ],
        ];

        foreach ($productsData as $pData) {
            $product = Product::create($pData);
            // Add gallery images
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $product->featured_image,
                'caption' => $product->name . ' - Product Angle 1',
                'sort_order' => 1,
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'caption' => $product->name . ' - Formulation & Texture Detail',
                'sort_order' => 2,
            ]);
        }

        // 9. Applications / Industries
        $applicationsData = [
            [
                'title' => 'Professional Salons & Parlours',
                'slug' => 'professional-salons',
                'subtitle' => 'High-Precision Salon Formulations',
                'short_description' => 'Commercial-grade haircare, depilatory waxes, styling waxes, and keratin reconstructors designed for daily high-traffic salon operations.',
                'description' => 'Adonis Chemical Limited supplies hundreds of premier salons, grooming chains, and beauty studios across Bangladesh. Our SINODA professional range provides predictable rheological viscosity, consistent thermal handling, and high-performance client results.',
                'features' => [
                    'Bulk salon dispenser packaging (1L - 5L)',
                    'Predictable viscosity under heating and hot climate handling',
                    'Hypoallergenic client safety with dermatological testing',
                    'Direct commercial supply and technical customer support',
                ],
                'icon' => 'scissors',
                'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 1,
            ],
            [
                'title' => 'Consumer Daily Personal Care',
                'slug' => 'personal-care',
                'subtitle' => 'Scientific Formulations for Everyday Well-Being',
                'short_description' => 'Nourishing shampoos, skin-calming aloe vera gels, invigorating body washes, and distilled rose waters crafted for everyday domestic care.',
                'description' => 'We translate cutting-edge cosmetic chemistry into affordable, reliable, and delightful personal care products for modern consumers. Every formula is pH-balanced and rigorously safety-evaluated.',
                'features' => [
                    'Isodermic pH-balanced formulations (pH 5.2 - 5.8)',
                    'Dermatologically tested surfactant safety profiles',
                    'Enriched with bio-active botanicals and vitamins',
                    'Ergonomic, spill-resistant retail packaging',
                ],
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 2,
            ],
            [
                'title' => 'Beauty Clinics & Wellness Spas',
                'slug' => 'beauty-wellness-spas',
                'subtitle' => 'Therapeutic Spa & Aesthetic Clinic Solutions',
                'short_description' => 'Aromatherapy massage oils, soothing facial hydrators, peeling gels, and post-procedure recovery formulations for aesthetic clinics.',
                'description' => 'Developed in collaboration with skincare specialists, our spa and aesthetic formulations prioritize non-comedogenic carrier oils, pure botanical distillates, and anti-inflammatory compounds.',
                'features' => [
                    'Cold-pressed therapeutic botanical oils',
                    'Zero artificial dyes or harsh drying alcohols',
                    'High dermal compatibility for post-peel/post-laser recovery',
                    'Aromatherapeutic natural essential oil integration',
                ],
                'icon' => 'sparkles',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 3,
            ],
            [
                'title' => 'Institutional & Hospitality Chemicals',
                'slug' => 'institutional-hospitality',
                'subtitle' => 'High-Volume Sanitization & Hygiene Formulations',
                'short_description' => 'Antibacterial liquid soaps, sanitizing washes, bulk cleansers, and institutional personal hygiene solutions for hotels, hospitals, and corporate facilities.',
                'description' => 'Adonis Chemical Limited engineers high-volume, cost-effective hygiene solutions that meet strict microbiological reduction requirements while remaining gentle on frequent users.',
                'features' => [
                    'Meets microbiological reduction benchmarks (>99.9%)',
                    'Bulk 5L, 20L, and 200L commercial barrel shipping',
                    'Integrated pump and automated dispenser compatibility',
                    'Cost-optimized commercial supply chain contracts',
                ],
                'icon' => 'building',
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 4,
            ],
        ];

        foreach ($applicationsData as $app) {
            Application::create($app);
        }

        // 10. Manufacturing Sections (7 Precision Steps)
        $mfgSteps = [
            [
                'step_number' => 1,
                'title' => 'Raw Material Selection & Quality Assay',
                'subtitle' => 'Certified Global Chemical Sourcing',
                'description' => 'Every batch starts with rigorous chemical validation. Raw surfactants, botanical distillates, cosmetic polymers, and functional actives are sourced from accredited global suppliers and subjected to FTIR spectroscopy and purity assays upon arrival at our Savar plant.',
                'details' => ['Certificates of Analysis (COA) verification', 'Heavy metal and microbial pre-screening', 'Controlled warehouse storage with humidity tracking'],
                'icon' => 'filter',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 1,
            ],
            [
                'step_number' => 2,
                'title' => 'Precision Formulation & Lab Synthesis',
                'subtitle' => 'Exact Molecular Batching',
                'description' => 'Using multi-stage closed batching reactors with digital temperature profiling and high-shear homogenizers, our chemical engineers synthesize uniform emulsions, crystal gels, and lipid solutions with strict adherence to standard operating procedures (SOPs).',
                'details' => ['Digital PLC-controlled temperature regulation', 'Vacuum degassing to eliminate micro-bubbles', 'High-shear homogenization for sub-micron droplet distribution'],
                'icon' => 'flask',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 2,
            ],
            [
                'step_number' => 3,
                'title' => 'In-Line Process Control & Monitoring',
                'subtitle' => 'Continuous Physical-Chemical Testing',
                'description' => 'During mixing and reaction cycles, chemical technicians sample the bulk product in real time to measure pH, Brookfield rotational viscosity, specific gravity, and refractive index, guaranteeing batch-to-batch uniformity.',
                'details' => ['Calibrated digital pH monitoring (±0.05 tolerance)', 'Brookfield rotational viscometer assay', 'Centrifuge emulsion stability verification'],
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 3,
            ],
            [
                'step_number' => 4,
                'title' => 'Microbiological Quarantine & Incubation',
                'subtitle' => 'Sterility & Bio-Load Assurance',
                'description' => 'Prior to packaging, representative samples are quarantined in our class-100 bio-laboratory for 48-hour incubation. Total aerobic microbial count (TAMC) and total yeast/mold count (TYMC) are validated to ensure absolute consumer safety.',
                'details' => ['48-hour microbial incubation quarantine', 'Zero tolerance for Pseudomonas, S. aureus, or C. albicans', 'Preservative efficacy challenge validation'],
                'icon' => 'shield-check',
                'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 4,
            ],
            [
                'step_number' => 5,
                'title' => 'Automated Sterile Filling & Capping',
                'subtitle' => 'Cleanroom Packaging Technology',
                'description' => 'Liquid and viscous products are transferred through sanitary 316L stainless-steel piping into automated volumetric piston fillers. Bottles and jars are purged with ionised air, filled, induction-sealed, and capped under clean air curtains.',
                'details' => ['316L pharmaceutical-grade stainless lines', 'Induction foil hermetic sealing', 'Weight-checker automated reject system'],
                'icon' => 'package',
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 5,
            ],
            [
                'step_number' => 6,
                'title' => 'Laser Batch Coding & Packaging Inspection',
                'subtitle' => 'Full Traceability & Compliance',
                'description' => 'Each individual unit is marked with a high-speed continuous laser or inkjet code containing the batch number, manufacturing date, expiry date, and production line identifier for full lifetime traceability from factory to end user.',
                'details' => ['Direct laser batch and date coding', 'Optical camera verification of label alignment', 'Barcode & QR traceability registration'],
                'icon' => 'check-circle',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 6,
            ],
            [
                'step_number' => 7,
                'title' => 'Finished Goods Release & Nationwide Logistics',
                'subtitle' => 'Systematic Warehouse Distribution',
                'description' => 'Once Quality Control signs the Certificate of Release, boxed master cartons are palletized and stored in climate-controlled warehousing before dispatch through Adonis Group’s integrated logistics network across Bangladesh and regional export channels.',
                'details' => ['Temperature-managed finished inventory warehouse', 'Automated FIFO inventory control', 'Adonis Group nationwide delivery fleet'],
                'icon' => 'truck',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 7,
            ],
        ];

        foreach ($mfgSteps as $ms) {
            ManufacturingSection::create($ms);
        }

        // 11. Quality Sections
        $qualitySteps = [
            [
                'step_number' => 1,
                'title' => 'Raw Material Chemical Verification',
                'subtitle' => 'Spectrophotometric & Chemical Analysis',
                'description' => 'Every single ingredient undergoes laboratory testing to confirm active percentage, heavy metal limits, moisture content, and chemical identification before release into production silos.',
                'standards' => ['USP / BP Cosmetic Grade compliance', 'FTIR finger-print verification', 'Heavy metals test (<5 ppm Lead/Arsenic)'],
                'icon' => 'eye',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 1,
            ],
            [
                'step_number' => 2,
                'title' => 'In-Process Rheology & Viscosity Control',
                'subtitle' => 'Ensuring Consistent Flow & Feel',
                'description' => 'Viscosity, density, and pH dictate product feel, foaming ability, and dispensing performance. We calibrate our Brookfield viscometers and digital meters daily to ensure strict tolerance limits.',
                'standards' => ['Brookfield DV2T rotational viscosity checks', 'Calibrated glass-electrode pH testing', 'Temperature-compensated specific gravity'],
                'icon' => 'layers',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 2,
            ],
            [
                'step_number' => 3,
                'title' => 'Microbiological Sterility & Bio-Assay',
                'subtitle' => 'Zero Contamination Standards',
                'description' => 'Our cleanroom biology lab tests total plate counts, coliforms, molds, and yeast colonies to ensure every SINODA personal care product exceeds international hygiene and shelf safety directives.',
                'standards' => ['ISO 21149 microbial enumeration protocols', 'ISO 22718 S. aureus detection standards', 'Automated colony counter validation'],
                'icon' => 'shield',
                'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 3,
            ],
            [
                'step_number' => 4,
                'title' => 'Accelerated Thermal & Stability Chamber Studies',
                'subtitle' => 'Simulating 3-Year Shelf Life',
                'description' => 'Batches are stored in calibrated thermal chambers at 45°C/75% RH for 3 months (accelerated) and real-time room temperature to prove color fastness, phase stability, viscosity retention, and preservative endurance.',
                'standards' => ['Freeze-thaw cycle testing (-5°C to 45°C)', 'Photostability chamber UV exposure', 'Centrifugal phase-separation stress test'],
                'icon' => 'thermometer',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 4,
            ],
            [
                'step_number' => 5,
                'title' => 'Packaging Leakage & Seal Integrity Assurance',
                'subtitle' => 'Vacuum Chamber Leak Testing',
                'description' => 'Bottles, pumps, and jars undergo vacuum chamber pressure differential testing to guarantee zero leaks during road transit across Bangladesh or international air/sea freight.',
                'standards' => ['Vacuum decay testing at -50 kPa', 'Dispenser pump stroke count durability', 'Torque closure testing for cap hermetic seals'],
                'icon' => 'box',
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 5,
            ],
            [
                'step_number' => 6,
                'title' => 'Batch Retain Sample Archive & Traceability',
                'subtitle' => 'Physical Sample Vault for 36 Months',
                'description' => 'A reference sample of every commercial batch is securely archived in our climate-controlled sample vault for the entire declared product lifespan plus one year, enabling instant retrospective testing.',
                'standards' => ['36-month physical sample vault retention', 'Barcoded batch genealogy tracking', 'Instant recall and verification protocol'],
                'icon' => 'archive',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 6,
            ],
        ];

        foreach ($qualitySteps as $qs) {
            QualitySection::create($qs);
        }

        // 12. Homepage CMS Sections
        $homepageSections = [
            [
                'section_key' => 'hero',
                'title' => 'Science Behind Better Products.',
                'subtitle' => 'Advanced Chemical & Personal Care Manufacturing in Bangladesh',
                'badge_text' => 'Manufactured in Genda, Savar, Bangladesh',
                'content' => 'Adonis Chemical Limited combines modern manufacturing, quality-driven processes, and continuous scientific innovation to develop reliable chemical and personal care solutions under the SINODA brand.',
                'button_text' => 'Explore Our Products',
                'button_url' => '/products',
                'secondary_button_text' => 'Discover SINODA',
                'secondary_button_url' => '/sinoda',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
                'is_enabled' => true,
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about_intro',
                'title' => 'Where Science Meets Everyday Care',
                'subtitle' => 'A Premier Chemical Concern of Adonis Group',
                'badge_text' => 'About Adonis Chemical',
                'content' => 'Adonis Chemical Limited is a forward-thinking chemical and personal care manufacturing enterprise committed to combining scientific formulation, controlled manufacturing, and consistent product quality. Operating from our manufacturing plant in Genda, Savar, we formulate products designed for professional salon, grooming, beauty, and everyday personal care applications under our signature SINODA brand.',
                'button_text' => 'Learn About Our Enterprise',
                'button_url' => '/about',
                'secondary_button_text' => 'View Manufacturing Facility',
                'secondary_button_url' => '/manufacturing',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1000&q=80',
                'is_enabled' => true,
                'sort_order' => 2,
            ],
            [
                'section_key' => 'sinoda_showcase',
                'title' => 'SINODA — Professional Care. Developed with Purpose.',
                'subtitle' => 'Signature Brand of Adonis Chemical Limited',
                'badge_text' => 'SINODA Brand',
                'content' => 'Engineered with dermatologist-approved active components and manufactured under strict batch controls, SINODA represents precision, safety, and luxury performance across haircare, skincare, styling, and personal hygiene.',
                'button_text' => 'Explore SINODA Catalog',
                'button_url' => '/sinoda',
                'secondary_button_text' => 'Download Product Catalog',
                'secondary_button_url' => '/contact',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1000&q=80',
                'is_enabled' => true,
                'sort_order' => 3,
            ],
            [
                'section_key' => 'cta',
                'title' => 'Looking for Reliable Chemical & Product Solutions?',
                'subtitle' => 'Connect with Adonis Chemical Limited',
                'badge_text' => 'Get in Touch',
                'content' => 'Connect with our corporate team or commercial representatives to discuss distribution opportunities, salon bulk partnerships, or custom formulation inquiries.',
                'button_text' => 'Contact Our Team',
                'button_url' => '/contact',
                'secondary_button_text' => 'Explore Products',
                'secondary_button_url' => '/products',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
                'is_enabled' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($homepageSections as $hs) {
            HomepageSection::create($hs);
        }

        // 13. Dynamic Pages
        $pagesData = [
            [
                'title' => 'About Adonis Chemical Limited',
                'slug' => 'about',
                'subtitle' => 'Pioneering Industrial Science & Modern Personal Care Manufacturing',
                'banner_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1600&q=80',
                'excerpt' => 'Adonis Chemical Limited is a premier chemical and personal care product company under Adonis Group, based in Genda, Savar, Dhaka, Bangladesh.',
                'content' => "<h2>Pioneering Chemical Manufacturing in Bangladesh</h2>\n<p>Adonis Chemical Limited was founded with a singular commitment: to elevate the quality, reliability, and scientific rigor of personal care, beauty, salon, and industrial chemical formulations manufactured in Bangladesh. As an integral concern of the established <strong>Adonis Group</strong>, we bring decades of industrial discipline, world-class supply chain logistics, and substantial capital investment into advanced chemical processing.</p>\n\n<h3>Our Savar Manufacturing Plant</h3>\n<p>Located in the industrial corridor of <strong>Genda, Savar, Dhaka</strong>, our manufacturing facility is designed around Good Manufacturing Practices (GMP). Our plant features dedicated cleanrooms, multi-stage water demineralization systems, precision stainless-steel mixing vessels, and automated packaging lines.</p>\n\n<h3>Our Signature Brand: SINODA</h3>\n<p>Through our flagship brand <strong>SINODA</strong>, Adonis Chemical Limited delivers a wide spectrum of personal care solutions designed for both professional salon artists and everyday households. From keratin-infused shampoos and high-hold sculpting waxes to pure distilled rose water and antibacterial hygiene washes, SINODA stands for unmatched formulation integrity.</p>\n\n<h3>Core Values</h3>\n<ul>\n<li><strong>Scientific Integrity:</strong> Every ingredient has a proven purpose backed by analytical data.</li>\n<li><strong>Uncompromising Quality:</strong> Batch-to-batch consistency verified through comprehensive laboratory testing.</li>\n<li><strong>Continuous Innovation:</strong> Relentless R&D to formulate modern, eco-conscious, and effective products.</li>\n<li><strong>National Pride & Global Standards:</strong> Proudly manufactured in Bangladesh to meet international benchmarks.</li>\n</ul>",
                'template' => 'about',
                'status' => 'published',
                'meta_title' => 'About Us - Adonis Chemical Limited | Concern of Adonis Group',
                'meta_description' => 'Discover Adonis Chemical Limited, a leading chemical and personal care manufacturer based in Genda, Savar, Dhaka. Home of SINODA brand and a concern of Adonis Group.',
            ],
            [
                'title' => 'SINODA Brand Showcase',
                'slug' => 'sinoda',
                'subtitle' => 'Professional Care. Developed with Purpose.',
                'banner_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1600&q=80',
                'excerpt' => 'SINODA is the signature personal care and salon brand of Adonis Chemical Limited, combining dermatological science with luxury formulation.',
                'content' => "<h2>The SINODA Philosophy</h2>\n<p>SINODA was created to bridge the gap between expensive imported cosmetics and locally available alternatives in Bangladesh. We believe that professional stylists, grooming specialists, and everyday families deserve world-class chemical formulations that are safe, potent, and beautifully packaged.</p>\n\n<h3>Our Product Pillars</h3>\n<ul>\n<li><strong>Hair Care & Restoration:</strong> Shampoos, keratin treatment masks, botanical oils, and nourishing conditioners.</li>\n<li><strong>Salon Styling & Depilatory:</strong> Matte hair waxes, high-elasticity strip and hot waxes, and grooming gels.</li>\n<li><strong>Skin & Soothing Hydration:</strong> 99% pure Aloe Vera gels, 100% steam-distilled rose water, and gentle facial cleansers.</li>\n<li><strong>Daily Hygiene & Body Care:</strong> Antibacterial liquid hand soaps, ocean mineral body washes, and exfoliating scrubs.</li>\n<li><strong>Men's Grooming:</strong> Precision clear shaving gels, 3-in-1 active body washes, and cooling aftershave care.</li>\n</ul>\n\n<h3>Dermatological Safety & Testing</h3>\n<p>Every SINODA product is formulated to match the natural acidic mantle of human skin (pH 5.2 to 5.8). We strictly prohibit harsh industrial parabens, toxic heavy metals, and unrefined solvents, ensuring safe daily application for all hair and skin types.</p>",
                'template' => 'sinoda',
                'status' => 'published',
                'meta_title' => 'SINODA Brand - Adonis Chemical Limited',
                'meta_description' => 'Explore the complete SINODA product portfolio by Adonis Chemical Limited, featuring premium hair care, skin care, salon waxes, and personal care solutions.',
            ],
            [
                'title' => 'Research & Development (R&D)',
                'slug' => 'rd',
                'subtitle' => 'Innovation Through Continuous Scientific Formulation',
                'banner_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80',
                'excerpt' => 'Learn how our dedicated laboratory chemists and cosmetic scientists innovate next-generation chemical formulations.',
                'content' => "<h2>Advanced Chemical R&D at Adonis Chemical</h2>\n<p>Innovation at Adonis Chemical Limited is powered by continuous laboratory experimentation, raw material screening, and scientific rigor. Our dedicated research facility in Savar employs qualified chemists, formulation engineers, and quality specialists.</p>\n\n<h3>Core R&D Initiatives</h3>\n<ul>\n<li><strong>Biomimetic Keratin Peptides:</strong> Developing lower-molecular-weight proteins that bond deeper into damaged hair shafts.</li>\n<li><strong>Natural Cold-Process Distillation:</strong> Extracting pure hydrosols and active botanical compounds without heat degradation.</li>\n<li><strong>Polymer Rheology & Climate Optimization:</strong> Engineering styling and depilatory waxes that maintain ideal viscosity in hot and humid tropical climates.</li>\n<li><strong>Eco-Friendly Green Surfactant Chemistry:</strong> Formulating readily biodegradable cleansers with zero compromise on foam richness and cleansing power.</li>\n</ul>",
                'template' => 'default',
                'status' => 'published',
                'meta_title' => 'Research & Development - Adonis Chemical Limited',
                'meta_description' => 'Explore our state-of-the-art laboratory research, formulation development, and cosmetic chemistry innovations at Adonis Chemical Limited.',
            ],
            [
                'title' => 'Sustainability Commitment',
                'slug' => 'sustainability',
                'subtitle' => 'Responsible Growth & Resource Awareness',
                'banner_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80',
                'excerpt' => 'Our commitment to efficient manufacturing, waste minimization, recyclable packaging, and responsible resource stewardship.',
                'content' => "<h2>Responsible Industrial Chemistry</h2>\n<p>At Adonis Chemical Limited, sustainable development is integral to our long-term vision. We recognize that chemical manufacturing requires rigorous environmental responsibility, efficient water stewardship, and continuous packaging optimization.</p>\n\n<h3>Our Environmental Pillars</h3>\n<ul>\n<li><strong>Closed-Loop Water Demineralization:</strong> Multi-stage reverse osmosis and closed-loop cooling towers to minimize process water loss.</li>\n<li><strong>100% Recyclable Packaging:</strong> Transitioning product containers to recyclable HDPE, PET, and aluminum materials.</li>\n<li><strong>Zero Effluent Discharge:</strong> Dedicated in-house effluent neutralization and filtration processes before disposal.</li>\n<li><strong>Energy-Efficient Mixing Systems:</strong> Variable frequency drive (VFD) motors across all batching reactors to reduce energy consumption.</li>\n</ul>",
                'template' => 'default',
                'status' => 'published',
                'meta_title' => 'Sustainability Commitment - Adonis Chemical Limited',
                'meta_description' => 'Read how Adonis Chemical Limited practices responsible chemical manufacturing, clean water usage, and recyclable packaging.',
            ],
            [
                'title' => 'Adonis Group Corporate Network',
                'slug' => 'adonis-group',
                'subtitle' => 'A Dynamic Conglomerate Powering Industrial Growth',
                'banner_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80',
                'excerpt' => 'Adonis Chemical Limited operates as an essential industrial business unit of the wider Adonis Group.',
                'content' => "<h2>About Adonis Group</h2>\n<p><strong>Adonis Group</strong> is a premier multi-disciplinary corporate group in Bangladesh with successful enterprises across manufacturing, consumer goods, engineering, trading, and logistics. Backed by corporate governance, robust financial resilience, and customer-first values, Adonis Group continuously invests in nation-building industries.</p>\n\n<p>As the chemical and personal care arm of the group, <strong>Adonis Chemical Limited</strong> leverages the conglomerate’s national distribution infrastructure, purchasing power, and business synergies to deliver exceptional value to business partners and consumers.</p>",
                'template' => 'default',
                'status' => 'published',
                'meta_title' => 'Adonis Group - Parent Organization of Adonis Chemical Limited',
                'meta_description' => 'Learn about Adonis Group, the parent conglomerate behind Adonis Chemical Limited and the SINODA brand.',
            ],
        ];

        foreach ($pagesData as $pd) {
            Page::create($pd);
        }

        // 14. Blog Categories & Posts
        $blogCats = [
            ['name' => 'Scientific Insights', 'slug' => 'scientific-insights', 'description' => 'In-depth chemical formulation and laboratory breakthroughs.'],
            ['name' => 'SINODA Updates', 'slug' => 'sinoda-updates', 'description' => 'New product launches and brand portfolio announcements.'],
            ['name' => 'Manufacturing & Quality', 'slug' => 'manufacturing-quality', 'description' => 'Behind the scenes at our Savar manufacturing plant.'],
            ['name' => 'Salon & Grooming Tips', 'slug' => 'salon-grooming', 'description' => 'Professional techniques and expert application advice.'],
        ];

        $bCatModels = [];
        foreach ($blogCats as $bc) {
            $bCatModels[$bc['slug']] = BlogCategory::create($bc);
        }

        $blogsData = [
            [
                'category_id' => $bCatModels['scientific-insights']->id,
                'title' => 'The Chemistry of Keratin: Why Hydrolyzed Peptides Reconstruct Hair Cuticles',
                'slug' => 'chemistry-of-keratin-hydrolyzed-peptides-hair-repair',
                'excerpt' => 'Explore the molecular mechanisms of low-weight hydrolyzed keratin peptides and how they bind to damaged hair proteins.',
                'content' => "<p>Hair fibers are composed of approximately 85% to 90% keratin—a fibrous protein rich in cysteine amino acids that form rigid disulfide cross-links. When hair is subjected to chemical bleaching, thermal straightening, or excessive UV exposure, these disulfide bonds break down, causing porosity, brittleness, and dullness.</p>\n\n<h3>The Problem with Large Keratin Molecules</h3>\n<p>Conventional cosmetic products frequently incorporate unhydrolyzed keratin proteins that possess a molecular mass exceeding 50,000 Daltons. These massive protein chains cannot penetrate the outer cuticle layer and simply sit on the surface until washed off.</p>\n\n<h3>The SINODA Hydrolyzed Solution</h3>\n<p>At Adonis Chemical Limited, our formulation team utilizes enzymatic hydrolysis to cleave keratin chains into micro-peptides with molecular weights between 500 and 2,000 Daltons. At this nanoscale dimension, the peptide chains penetrate into the cortical cortex, establishing electrostatic and hydrogen bonds with existing keratin strands.</p>\n\n<p>The result is a documented 68% improvement in tensile strength and a restored moisture-barrier defense that prevents breakage.</p>",
                'featured_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80',
                'author' => 'Dr. R. Hossain, Chief Formulation Chemist',
                'published_at' => now()->subDays(3),
                'status' => 'published',
                'meta_title' => 'The Chemistry of Keratin - Adonis Chemical Laboratory Insights',
                'meta_description' => 'Learn how hydrolyzed keratin peptides rebuild damaged hair bonds from the chemical formulation team at Adonis Chemical Limited.',
            ],
            [
                'category_id' => $bCatModels['manufacturing-quality']->id,
                'title' => 'Inside Our Savar Plant: How Precision Cleanroom Batching Ensures Zero Contamination',
                'slug' => 'inside-our-savar-plant-cleanroom-batching-quality',
                'excerpt' => 'Take a tour of Adonis Chemical Limited’s manufacturing facility in Genda, Savar, Dhaka and discover our sterility protocols.',
                'content' => "<p>In personal care and chemical manufacturing, consistent purity is not an accident—it is the direct outcome of disciplined engineering. Located in Genda, Savar, Adonis Chemical Limited operates one of the most technologically advanced chemical manufacturing facilities in Dhaka division.</p>\n\n<h3>Three-Stage Demineralized Water System</h3>\n<p>Water constitutes 60% to 90% of cosmetic liquid formulations. Raw municipal water contains minerals, chlorine, and bacterial spores that degrade formulations over time. Our plant incorporates a continuous 3-stage filtration process: Sand Filtration & Carbon Absorption, Double-Pass Reverse Osmosis (RO), and Continuous Electro-Deionization (CEDI) followed by 254nm UV germicidal irradiation.</p>\n\n<h3>Quarantine and Quality Release</h3>\n<p>No commercial batch leaves the Savar facility without passing a mandatory 48-hour incubation quarantine and rigorous analytical testing including Brookfield viscosity, FTIR active percentage, and micro-aerobic bacterial counts.</p>",
                'featured_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'author' => 'Production & QC Division',
                'published_at' => now()->subDays(8),
                'status' => 'published',
                'meta_title' => 'Inside Our Savar Facility - Manufacturing Standards at Adonis Chemical',
                'meta_description' => 'Discover how Adonis Chemical Limited ensures product purity at its Genda, Savar manufacturing plant.',
            ],
            [
                'category_id' => $bCatModels['sinoda-updates']->id,
                'title' => 'SINODA Unveils Advanced Salon Hair Styling Wax with 24-Hour Matte Hold',
                'slug' => 'sinoda-unveils-advanced-salon-hair-styling-wax-matte-hold',
                'excerpt' => 'Adonis Chemical Limited announces the official launch of the SINODA Extreme Hold Matte Sculpting Wax across major salon distributors.',
                'content' => "<p>Adonis Chemical Limited is proud to announce the nationwide launch of its newest professional styling innovation: the <strong>SINODA Extreme Hold Matte Sculpting Hair Wax</strong>.</p>\n\n<p>Engineered over 14 months of research at our Savar laboratories, the new wax solves a classic challenge faced by barbers and stylists in Bangladesh: styling products melting or turning sticky under high tropical humidity.</p>\n\n<p>By blending Brazilian carnauba wax, micro-crystalline beeswax, and natural kaolin clay, the formula provides all-day structural hold with a completely non-reflective, natural matte finish that washes out easily with warm water.</p>",
                'featured_image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&q=80',
                'author' => 'SINODA Brand Management',
                'published_at' => now()->subDays(15),
                'status' => 'published',
                'meta_title' => 'SINODA Extreme Hold Matte Hair Wax Launch - Adonis Chemical',
                'meta_description' => 'Adonis Chemical Limited launches SINODA Extreme Hold Matte Sculpting Wax for salon professionals.',
            ],
            [
                'category_id' => $bCatModels['salon-grooming']->id,
                'title' => 'The Science of Depilatory Waxing: Low Melting Points and Skin Comfort',
                'slug' => 'science-of-depilatory-waxing-low-melting-points-comfort',
                'excerpt' => 'Why temperature control and resin elasticity make all the difference in modern salon hair removal treatments.',
                'content' => "<p>Professional waxing has evolved significantly from crude rosin melts. Today’s top salons require specialized low-melting-point waxes that encapsulate fine and coarse hairs firmly without adhering painfully to the living epidermal skin layer.</p>\n\n<p>SINODA Professional Hair Removing Wax utilizes esterified rosins combined with calming chamomile extracts, melting smoothly at a gentle 45°C to 48°C. This eliminates thermal discomfort and drastically reduces post-wax redness.</p>",
                'featured_image' => 'https://images.unsplash.com/photo-1512290900672-1f02e600572e?auto=format&fit=crop&w=800&q=80',
                'author' => 'Salon Technical Specialist',
                'published_at' => now()->subDays(22),
                'status' => 'published',
                'meta_title' => 'Depilatory Waxing Science - SINODA Professional Care',
                'meta_description' => 'Professional waxing formulation secrets from the chemical experts at Adonis Chemical Limited.',
            ],
        ];

        foreach ($blogsData as $bd) {
            Blog::create($bd);
        }

        // 15. SEO Settings for All Major Routes
        $seoData = [
            [
                'page_key' => 'home',
                'page_name' => 'Homepage',
                'meta_title' => 'Adonis Chemical Limited | Science Behind Better Products | Home of SINODA',
                'meta_description' => 'Adonis Chemical Limited is a leading chemical and personal care manufacturer based in Genda, Savar, Dhaka, Bangladesh. Concern of Adonis Group and creator of SINODA brand.',
                'meta_keywords' => 'Adonis Chemical Limited, SINODA, chemical manufacturing Bangladesh, personal care manufacturer, Savar chemical company, Adonis Group, salon products Bangladesh',
                'og_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'about',
                'page_name' => 'About Us',
                'meta_title' => 'About Us | Adonis Chemical Limited - Concern of Adonis Group',
                'meta_description' => 'Learn about Adonis Chemical Limited, our chemical manufacturing facility in Savar, our company values, and our relationship with Adonis Group.',
                'meta_keywords' => 'About Adonis Chemical, Adonis Group concerns, Savar chemical plant, chemical manufacturing Dhaka',
                'og_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'products',
                'page_name' => 'Products Catalog',
                'meta_title' => 'Products & Formulations | SINODA by Adonis Chemical Limited',
                'meta_description' => 'Browse the complete product catalog of SINODA personal care, haircare, skincare, salon waxes, and chemical formulations by Adonis Chemical Limited.',
                'meta_keywords' => 'SINODA products, chemical product catalog, hair oil, shampoo, hair wax, depilatory wax, aloe vera gel, rose water',
                'og_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'sinoda',
                'page_name' => 'SINODA Brand',
                'meta_title' => 'SINODA Brand | Professional Care Developed with Purpose',
                'meta_description' => 'Explore the signature SINODA brand by Adonis Chemical Limited. High-performance personal care, salon styling, and hygiene products.',
                'meta_keywords' => 'SINODA, SINODA brand, Adonis Chemical SINODA, salon brand Bangladesh',
                'og_image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'manufacturing',
                'page_name' => 'Manufacturing Process',
                'meta_title' => 'Manufacturing with Precision | Savar Facility | Adonis Chemical Limited',
                'meta_description' => 'Explore our state-of-the-art 7-step chemical manufacturing process at our Genda, Savar facility in Dhaka, Bangladesh.',
                'meta_keywords' => 'manufacturing process, chemical production Savar, GMP chemical plant, cosmetic manufacturing Bangladesh',
                'og_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'quality',
                'page_name' => 'Quality Assurance',
                'meta_title' => 'Quality Control & Lab Assurance | Adonis Chemical Limited',
                'meta_description' => 'Discover our comprehensive quality control protocols, microbiological testing, and stability standards at Adonis Chemical Limited.',
                'meta_keywords' => 'quality assurance chemical, lab testing, batch control, microbiological testing',
                'og_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'sustainability',
                'page_name' => 'Sustainability Commitment',
                'meta_title' => 'Sustainability & Responsible Growth | Adonis Chemical Limited',
                'meta_description' => 'Learn how Adonis Chemical Limited approaches environmental stewardship, clean water usage, and recyclable packaging in Bangladesh.',
                'meta_keywords' => 'sustainability chemical, responsible manufacturing, green chemistry Bangladesh',
                'og_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'news',
                'page_name' => 'News & Insights',
                'meta_title' => 'News & Chemical Insights | Adonis Chemical Limited',
                'meta_description' => 'Read latest updates, formulation insights, and industry developments from Adonis Chemical Limited and SINODA brand.',
                'meta_keywords' => 'Adonis Chemical news, chemical research articles, SINODA updates',
                'og_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'page_key' => 'contact',
                'page_name' => 'Contact Us',
                'meta_title' => 'Contact Adonis Chemical Limited | Genda, Savar & Corporate Head Office',
                'meta_description' => 'Get in touch with Adonis Chemical Limited for corporate inquiries, product distribution, salon orders, and custom chemical manufacturing.',
                'meta_keywords' => 'Contact Adonis Chemical, Adonis Chemical phone, Savar factory address, SINODA contact',
                'og_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($seoData as $seo) {
            SeoSetting::create($seo);
        }
    }
}

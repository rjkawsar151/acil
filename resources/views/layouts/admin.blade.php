<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin CMS') | Adonis Chemical Limited</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#071B33',
                            dark: '#030E1D',
                            sidebar: '#07182D',
                        },
                        brand: {
                            blue: '#0B5ED7',
                            scientific: '#168CFF',
                            cyan: '#00B7D9',
                            light: '#EAF5FF',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F6F8FB; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #1B3150; border-radius: 4px; }
    </style>

    @stack('styles')
</head>
<body class="text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        
        <!-- Sidebar Backdrop for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-navy/80 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 w-72 bg-navy-sidebar text-slate-300 transition-transform duration-300 flex flex-col justify-between border-r border-slate-800 shadow-xl">
            
            <!-- Sidebar Header -->
            <div>
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 bg-navy-dark">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-blue to-brand-cyan p-0.5">
                            <div class="w-full h-full bg-navy rounded-[10px] flex items-center justify-center text-white font-bold text-lg">
                                <i class="fa-solid fa-atom text-brand-cyan"></i>
                            </div>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-white text-base tracking-tight block">ADONIS <span class="text-brand-cyan">CMS</span></span>
                            <span class="text-[9px] uppercase tracking-widest text-slate-400 font-semibold">Chemical Manufacturing</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Navigation List -->
                <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-10rem)] sidebar-scroll text-sm">
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center text-brand-cyan"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Section: Catalog -->
                    <div class="pt-4 pb-1.5 px-3.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        Products & Catalog
                    </div>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/products*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-flask w-5 text-center text-brand-scientific"></i>
                            <span>All Products</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-bold">{{ \App\Models\Product::count() }}</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/categories*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 text-center text-brand-cyan"></i>
                        <span>Categories</span>
                    </a>

                    <!-- Section: Website Content -->
                    <div class="pt-4 pb-1.5 px-3.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        Content Management
                    </div>

                    <a href="{{ route('admin.hero-slides.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/hero-slides*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-images w-5 text-center text-cyan-400"></i>
                        <span>Hero Carousel Slides</span>
                    </a>

                    <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/homepage*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-house-laptop w-5 text-center text-amber-400"></i>
                        <span>Homepage Sections</span>
                    </a>

                    <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/pages*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-file-lines w-5 text-center text-teal-400"></i>
                        <span>Dynamic Pages</span>
                    </a>

                    <a href="{{ route('admin.manufacturing.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/manufacturing*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-industry w-5 text-center text-sky-400"></i>
                        <span>Manufacturing Steps</span>
                    </a>

                    <a href="{{ route('admin.quality.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/quality*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-vial-circle-check w-5 text-center text-emerald-400"></i>
                        <span>Quality Assurance</span>
                    </a>

                    <a href="{{ route('admin.applications.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/applications*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-shapes w-5 text-center text-purple-400"></i>
                        <span>Industries & Salons</span>
                    </a>

                    <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/statistics*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-arrow-up-right-dots w-5 text-center text-orange-400"></i>
                        <span>Company Stats</span>
                    </a>

                    <!-- Section: Blog -->
                    <div class="pt-4 pb-1.5 px-3.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        Blog & Media
                    </div>

                    <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/blogs*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-newspaper w-5 text-center text-indigo-400"></i>
                        <span>Blog Articles</span>
                    </a>

                    <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/media*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-photo-film w-5 text-center text-pink-400"></i>
                        <span>Media Library</span>
                    </a>

                    <!-- Section: Communications -->
                    <div class="pt-4 pb-1.5 px-3.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        Communications
                    </div>

                    @php
                        $unreadInquiries = \App\Models\ProductInquiry::where('is_read', false)->count();
                        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp

                    <a href="{{ route('admin.inquiries.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/inquiries*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-cart-flatbed w-5 text-center text-cyan-400"></i>
                            <span>Product Inquiries</span>
                        </div>
                        @if($unreadInquiries > 0)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-cyan-500 text-navy font-extrabold">{{ $unreadInquiries }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/messages*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope w-5 text-center text-rose-400"></i>
                            <span>Contact Messages</span>
                        </div>
                        @if($unreadMessages > 0)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-rose-500 text-white font-extrabold">{{ $unreadMessages }}</span>
                        @endif
                    </a>

                    <!-- Section: Site Settings -->
                    <div class="pt-4 pb-1.5 px-3.5 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                        Configuration
                    </div>

                    <a href="{{ route('admin.navigation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/navigation*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-compass w-5 text-center text-slate-400"></i>
                        <span>Menus & Links</span>
                    </a>

                    <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/seo*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-magnifying-glass-chart w-5 text-center text-slate-400"></i>
                        <span>SEO & Metadata</span>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/settings*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-5 text-center text-slate-400"></i>
                        <span>Website Settings</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition {{ Request::is('admin/users*') ? 'bg-brand-blue text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield w-5 text-center text-slate-400"></i>
                        <span>Users & Roles</span>
                    </a>

                </nav>
            </div>

            <!-- Sidebar User Profile Footer -->
            <div class="p-4 border-t border-slate-800 bg-navy-dark">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-700">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-brand-cyan truncate">{{ auth()->user()->role->name ?? 'Admin' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 lg:pl-72 flex flex-col min-w-0">
            
            <!-- Topbar Header -->
            <header class="h-20 bg-white border-b border-slate-200/80 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-navy text-xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-navy font-heading leading-tight">@yield('page_title', 'Admin Dashboard')</h1>
                        <p class="text-xs text-slate-500">@yield('page_subtitle', 'Adonis Chemical Limited Management Portal')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    
                    <!-- View Live Website Button -->
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-brand-blue"></i>
                        <span>View Website</span>
                    </a>

                    <!-- Profile Link -->
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl hover:bg-slate-100 transition">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-lg object-cover">
                        <span class="text-xs font-bold text-slate-700 hidden md:inline">{{ auth()->user()->name }}</span>
                    </a>
                </div>

            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-3.5 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3 text-sm font-bold mb-1">
                            <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="list-disc pl-9 text-xs space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="h-14 border-t border-slate-200/80 px-6 flex items-center justify-between text-xs text-slate-500 bg-white">
                <p>© {{ date('Y') }} Adonis Chemical Limited (Savar, Dhaka). All Rights Reserved.</p>
                <p class="text-slate-400">Laravel 12 • Enterprise CMS v2.0</p>
            </footer>

        </div>
    </div>

    <!-- Generic Delete Confirmation Modal Helper -->
    <script>
        function confirmDelete(event, message = 'Are you sure you want to delete this record? This action cannot be undone.') {
            if (!confirm(message)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
    @stack('scripts')
</body>
</html>

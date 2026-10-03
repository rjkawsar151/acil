<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adonis Chemical Limited</title>
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
                        },
                        brand: {
                            blue: '#0B5ED7',
                            scientific: '#168CFF',
                            cyan: '#00B7D9',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-navy-dark min-h-screen flex items-center justify-center p-4 relative overflow-hidden selection:bg-brand-cyan selection:text-navy">

    <!-- Ambient Glows -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand-blue/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-brand-cyan/20 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        <!-- Brand Header -->
        <div class="text-center mb-8 space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-blue to-brand-cyan p-0.5 shadow-2xl shadow-blue-500/20 mb-3">
                <div class="w-full h-full bg-navy rounded-[14px] flex items-center justify-center text-white text-2xl font-bold">
                    <i class="fa-solid fa-atom text-brand-cyan"></i>
                </div>
            </div>
            <h1 class="font-heading font-black text-2xl text-white tracking-tight">ADONIS CHEMICAL</h1>
            <p class="text-xs uppercase tracking-widest text-brand-cyan font-bold">Enterprise CMS Portal</p>
        </div>

        <!-- Login Card -->
        <div class="bg-navy/90 backdrop-blur-xl rounded-3xl border border-slate-700/80 p-8 shadow-2xl space-y-6">
            
            @if(session('info'))
                <div class="p-3.5 rounded-xl bg-blue-500/10 border border-blue-500/30 text-xs text-blue-200">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Staff Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter staff email" required autofocus class="w-full px-4 py-3 pl-11 text-sm bg-slate-900/80 border border-slate-700 text-white rounded-2xl focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-3 pl-11 text-sm bg-slate-900/80 border border-slate-700 text-white rounded-2xl focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-800 border-slate-700 text-brand-blue focus:ring-0">
                        <span>Remember session</span>
                    </label>
                    <a href="{{ route('home') }}" class="hover:text-brand-cyan">Back to Website</a>
                </div>

                <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-brand-blue to-brand-scientific text-white text-sm font-bold shadow-lg shadow-blue-600/40 hover:opacity-95 transition flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Authenticate & Access CMS</span>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-800 text-center text-[11px] text-slate-500">
                <p>Adonis Chemical Industries Ltd • Genda, Savar, Dhaka</p>
            </div>

        </div>

    </div>

</body>
</html>

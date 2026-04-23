<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Guia de l'Hospitalet</title>
    
    <!-- Tailwind & Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- External Assets -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}"></script>
    
    <style>
        body { background-color: #fcf4ff; color: #14052b; min-height: 100vh; }
        .dark body { background-color: #020617; color: #f8fafc; }
    </style>
    @stack('head')
</head>
<body class="bg-background text-on-background transition-all duration-300">
    <div class="flex min-h-screen relative overflow-x-hidden" id="admin-wrapper">
        <!-- Sidebar Backdrop (Mobile) -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"></div>

        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-white dark:bg-slate-900 h-screen fixed left-0 top-0 z-50 border-r border-violet-100 dark:border-slate-800 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 flex flex-col">
            <div class="p-6 flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-primary rounded-[10px] flex items-center justify-center text-white shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">location_city</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-primary tracking-tight">{{ __('Guia de l\'Hospitalet') }}</h1>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 px-2 space-y-2">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'location_on', 'label' => 'Llocs'],
                        ['route' => 'admin.categories', 'icon' => 'category', 'label' => 'Categories'],
                        ['route' => 'admin.gymkhanas', 'icon' => 'explore', 'label' => 'Gimcanes'],
                        ['route' => 'admin.users', 'icon' => 'group', 'label' => 'Usuaris'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-[10px] transition-all group {{ request()->routeIs($item['route']) ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs($item['route']) ? 'fill-icon' : '' }}" 
                              style="font-variation-settings: 'FILL' {{ request()->routeIs($item['route']) ? '1' : '0' }};">
                            {{ $item['icon'] }}
                        </span>
                        <span class="text-sm font-bold">{{ __($item['label']) }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-2 pb-4 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-[10px] text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all group">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">logout</span>
                        <span class="text-sm font-bold">{{ __('Sortir') }}</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 min-h-screen flex flex-col min-w-0 transition-all duration-300">
            <!-- Header -->
            <header class="sticky top-0 z-40 bg-surface/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-violet-100 dark:border-slate-800 px-2 md:px-8 h-18 md:h-20 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2 md:gap-4 overflow-hidden">
                    <!-- Mobile Menu Logo Toggle -->
                    <button id="sidebar-toggle" class="flex-none flex items-center justify-center p-1 md:hidden hover:scale-105 active:scale-95 transition-all outline-none">
                        <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-primary/30">
                            <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">location_city</span>
                        </div>
                    </button>
                    <h1 class="text-xs md:text-xl font-black text-primary/60 dark:text-primary/40 uppercase tracking-[0.1em] truncate">@yield('header_title', 'Administració')</h1>
                </div>

                <div class="flex items-center gap-2 md:gap-6 ml-auto">
                    <!-- Lang Selector -->
                    <div class="relative group">
                        <button class="flex items-center gap-1 text-[10px] md:text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-primary transition-all">
                            <span class="material-symbols-outlined text-[16px] md:text-sm">language</span>
                            <span class="hidden xs:inline">{{ strtoupper(app()->getLocale()) }}</span>
                            <span class="material-symbols-outlined text-[12px] md:text-[14px]">expand_more</span>
                        </button>
                        <div class="absolute left-0 top-full w-full h-4 z-40 hidden group-hover:block"></div>
                        <div class="absolute right-0 top-full mt-2 w-28 md:w-32 bg-white dark:bg-slate-800 rounded-[10px] shadow-xl border border-outline-variant/20 hidden group-hover:block overflow-hidden z-50">
                            <a class="block px-4 py-2 text-[10px] md:text-xs hover:bg-surface-container-low dark:hover:bg-slate-700 text-on-surface dark:text-slate-200" href="{{ route('lang.switch', 'ca') }}">Català</a>
                            <a class="block px-4 py-2 text-[10px] md:text-xs hover:bg-surface-container-low dark:hover:bg-slate-700 text-on-surface dark:text-slate-200" href="{{ route('lang.switch', 'es') }}">Español</a>
                            <a class="block px-4 py-2 text-[10px] md:text-xs hover:bg-surface-container-low dark:hover:bg-slate-700 text-on-surface dark:text-slate-200" href="{{ route('lang.switch', 'en') }}">English</a>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-[10px] flex items-center justify-center bg-white dark:bg-slate-900 border border-violet-100 dark:border-slate-800 text-primary shadow-sm hover:scale-110 active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-sm md:text-base dark:hidden">dark_mode</span>
                        <span class="material-symbols-outlined text-sm md:text-base hidden dark:block text-amber-400">light_mode</span>
                    </button>

                    <!-- Profile Link -->
                    <a href="{{ route('profile') }}" class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 border-l border-violet-100 dark:border-slate-800">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-black text-slate-900 dark:text-slate-50">{{ Auth::user() ? Auth::user()->name : 'User' }}</p>
                            <p class="text-[10px] font-bold text-slate-400">{{ __('Administrador') }}</p>
                        </div>
                        <div class="w-9 h-9 md:w-11 md:h-11 rounded-lg md:rounded-[10px] border-2 border-primary/20 p-0.5 overflow-hidden shadow-lg shadow-primary/10 flex items-center justify-center bg-primary/10">
                            @if(Auth::user() && Auth::user()->profile_photo)
                                <img src="{{ Auth::user()->profile_photo_url }}" class="w-full h-full object-cover rounded-[10px]" alt="Profile">
                            @else
                                <span class="material-symbols-outlined text-primary text-sm md:text-base">person</span>
                            @endif
                        </div>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-2 md:px-8 py-4 md:py-6">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggle = document.getElementById('sidebar-toggle');
            
            function toggleSidebar() {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                }
            }

            if (toggle) toggle.addEventListener('click', toggleSidebar);
            if (backdrop) backdrop.addEventListener('click', toggleSidebar);
            
            // Close on nav click (optional but good for SPA/fast feel)
            const navLinks = sidebar.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) toggleSidebar();
                });
            });
        });
    </script>
</body>
</html>

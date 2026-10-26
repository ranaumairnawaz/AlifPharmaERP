<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6366f1">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="shortcut icon" href="{{ asset('alif-logo.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('alif-logo.png') }}">
    <title>{{ $branding['name'] }} - Dashboard</title>
    <style>
        :root {
            --brand-primary:
                {{ $branding['color'] }}
            ;
            --brand-primary-faded:
                {{ $branding['color'] }}
                20;
            /* 20% opacity hex */
        }
    </style>
    <script>
        // Intelligent Persistence: Apply theme before FCP (First Contentful Paint)
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
            if (!('theme' in localStorage)) {
                localStorage.theme = 'light';
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Localized Offline Assets -->
    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
    <link href="{{ asset('vendor/css/dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/buttons.dataTables.min.css') }}" rel="stylesheet">

    <script src="{{ asset('vendor/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/js/buttons.print.min.js') }}"></script>


    <!-- Binary Dependencies -->
    <script src="{{ asset('vendor/js/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/js/vfs_fonts.js') }}"></script>

    <!-- Global Notification Hub (Toastr & SweetAlert) - Localized Offline -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>

    <style>
        /* Localized Typography Infrastructure */
        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-300.ttf') }}") format('truetype');
            font-weight: 300;
        }

        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-400.ttf') }}") format('truetype');
            font-weight: 400;
        }

        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-500.ttf') }}") format('truetype');
            font-weight: 500;
        }

        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-600.ttf') }}") format('truetype');
            font-weight: 600;
        }

        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-700.ttf') }}") format('truetype');
            font-weight: 700;
        }

        @font-face {
            font-family: 'Outfit';
            src: url("{{ asset('fonts/outfit-800.ttf') }}") format('truetype');
            font-weight: 800;
        }

        :root {
            font-family: 'Outfit', sans-serif;
        }

        /* Custom Executive Scrollbar for Sidebar */
        nav::-webkit-scrollbar {
            width: 4px;
        }

        nav::-webkit-scrollbar-track {
            background: transparent;
        }

        nav::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            /* slate-300 */
            border-radius: 10px;
            transition: background 0.3s;
        }

        .dark nav::-webkit-scrollbar-thumb {
            background: #334155;
        }

        /* slate-800 */
        nav:hover::-webkit-scrollbar-thumb {
            background: #0d9488;
        }

        /* teal-600 */
        .dark nav:hover::-webkit-scrollbar-thumb {
            background: #2dd4bf;
        }

        /* teal-400 */
        nav {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .dark nav {
            scrollbar-color: #334155 transparent;
        }

        /* Executive Branded Preloader */
        #app-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s;
        }

        .dark #app-preloader {
            background: #020617;
        }

        /* Slate-950 */
        #app-preloader.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .loader-logo {
            width: 120px;
            margin-bottom: 24px;
            animation: pulse-glow 2s infinite ease-in-out;
        }

        .loader-text {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            animation: text-blink 1.5s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 20px 40px rgba(13, 148, 136, 0.2);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 25px 50px rgba(13, 148, 136, 0.4);
            }
        }

        @keyframes text-blink {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }
        }

        /* Executive Professional DataTables Overhaul */
        .dt-container {
            width: 100% !important;
            margin-top: 1rem;
        }

        .dt-layout-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 1.5rem 2rem !important;
            gap: 1.5rem !important;
            background: transparent !important;
        }

        .dt-layout-row:has(table) {
            padding: 0 !important;
        }

        /* Export Buttons Professional Styling */
        .dt-buttons {
            display: flex !important;
            gap: 0.6rem !important;
        }

        .dt-button {
            height: 38px !important;
            padding: 0 1.25rem !important;
            border-radius: 0.85rem !important;
            font-size: 10px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #64748b !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: inline-flex !important;
            align-items: center !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) !important;
        }

        .dark .dt-button {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        .dt-button:hover {
            border-color: #0d9488 !important;
            color: #0d9488 !important;
            background: #f0fdfa !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15) !important;
        }

        .dark .dt-button:hover {
            background: #134e4a33 !important;
            border-color: #14b8a6 !important;
            color: #14b8a6 !important;
        }

        /* Modern Tooltip-like Buttons */
        .dt-button span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Search Infrastructure */
        .dt-search {
            position: relative !important;
            flex: 1;
            max-width: 320px;
        }

        .dt-search input {
            width: 100% !important;
            height: 42px !important;
            padding: 0 1rem 0 2.8rem !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            border-radius: 1rem !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 16px center !important;
            background-size: 18px !important;
            color: #1e293b !important;
            transition: all 0.3s !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02) !important;
        }

        .dark .dt-search input {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        .dt-search input:focus {
            border-color: #0d9488 !important;
            ring: 3px solid #0d948810 !important;
            background-color: #fff !important;
        }

        .dark .dt-search input:focus {
            background-color: #1e293b !important;
        }

        /* Pagination & Paging Logic */
        .dt-paging {
            display: flex !important;
            gap: 0.4rem !important;
        }

        .dt-paging-button {
            min-width: 36px !important;
            height: 36px !important;
            border-radius: 0.85rem !important;
            font-size: 12px !important;
            font-weight: 800 !important;
            color: #64748b !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.2s !important;
            cursor: pointer;
        }

        .dt-paging-button.current {
            background: #0d9488 !important;
            color: #ffffff !important;
            border-color: #0d9488 !important;
            shadow: 0 4px 10px rgba(13, 148, 136, 0.3) !important;
        }

        .dt-paging-button:hover:not(.current) {
            background: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #1e293b !important;
        }

        .dark .dt-paging-button {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        .dt-info {
            font-[9px] font-bold text-slate-400 uppercase tracking-widest;
        }
    </style>
</head>

<body class="h-full bg-slate-50 antialiased overflow-x-hidden">
    <!-- Executive Alif Pharma Preloader -->
    <div id="app-preloader">
        <div class="loader-logo">
            <img src="{{ $branding['logo'] }}" alt="{{ $branding['name'] }} Logo" class="w-full h-auto">
        </div>
        <div class="loader-text">{{ $branding['name'] }} Systems</div>
        <div class="mt-4 flex gap-1">
            <div class="w-1 h-1 rounded-full bg-teal-200 animate-bounce" style="animation-delay: 0s"></div>
            <div class="w-1 h-1 rounded-full bg-teal-400 animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1 h-1 rounded-full bg-teal-600 animate-bounce" style="animation-delay: 0.4s"></div>
        </div>
    </div>
    <div class="h-full font-sans antialiased text-slate-900 dark:text-slate-100 selection:bg-teal-500 selection:text-white"
        x-data="{ sidebarOpen: false, darkMode: localStorage.theme === 'dark' }">

        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen"
            class="fixed inset-0 z-40 bg-slate-900/40 dark:bg-slate-950/60 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false" x-transition.opacity></div>

        <div class="flex h-screen overflow-hidden">
            <!-- Persistent Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl lg:shadow-none flex flex-col">
                <!-- Brand Identity -->
                <div
                    class="h-20 flex items-center px-8 border-b border-slate-100 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <img src="{{ $branding['logo'] }}" class="h-8 w-auto" alt="{{ $branding['name'] }} Logo">
                        <span
                            class="text-lg font-bold tracking-tight text-slate-800 dark:text-white uppercase px-1">{{ $branding['name'] }}</span>
                    </div>
                </div>

                <nav class="flex-1 mt-6 px-3 space-y-1 overflow-y-auto scrollbar-hide pb-24">

                    @auth
                        @if(auth()->check() && (auth()->user()->isAdmin()))
                            <a href="{{ route('dashboard.index') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5 {{ request()->routeIs('dashboard.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @endif
                    @endauth
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('products', 'read') || auth()->user()->hasModuleAction('damages', 'read') || auth()->user()->hasModuleAction('batches', 'read') || auth()->user()->hasModuleAction('slips', 'read')))
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Products
                            Management</p>
                    @endif
                    @canRead('products')
                    <a href="{{ route('products.finished') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('products.finished') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('products.finished') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Finished Goods
                    </a>

                    <a href="{{ route('products.raw') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('products.raw') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('products.raw') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Raw Materials
                    </a>

                    <a href="{{ route('products.packaging') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('products.packaging') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('products.packaging') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Packaging Materials
                    </a>

                    <a href="{{ route('products.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('products.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('products.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        All Products
                    </a>

                    <a href="{{ route('materials.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('materials.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('materials.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Material Purchases
                    </a>


                    <a href="{{ route('stock.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('stock.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('stock.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Flow Movements
                    </a>
                    @endcanRead

                    @canRead('damages')
                    <a href="{{ route('damages.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('damages.*') ? 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('damages.*') ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Damage & Loss Hub
                    </a>
                    @endcanRead

                    @canRead('batches')
                    <a href="{{ route('batches.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('batches.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('batches.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Production Batches
                    </a>
                    <a href="{{ route('batches.expiring') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('batches.expiring') ? 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('batches.expiring') ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Upcoming Expiries
                    </a>
                    @endcanRead

                    @canRead('slips')
                    <a href="{{ route('slips.create') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('slips.create') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('slips.create') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Issue New Slip
                    </a>
                    <a href="{{ route('slips.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('slips.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('slips.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Slip History
                    </a>
                    @endcanRead
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('invoices', 'read') || auth()->user()->hasModuleAction('accounts', 'read') || auth()->user()->hasModuleAction('employees', 'read') || auth()->user()->hasModuleAction('salaries', 'read') || auth()->user()->hasModuleAction('expenses', 'read')))
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4 mb-2">Finance &
                            Accounts</p>
                    @endif
                    @canRead('invoices')
                    <a href="{{ route('invoices.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('invoices.*') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('invoices.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Invoice Registry
                    </a>
                    @endcanRead

                    @canRead('accounts')
                    <a href="{{ route('accounts.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('accounts.*') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('accounts.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Accounts Ledger
                    </a>
                    @endcanRead
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('employees', 'read') || auth()->user()->hasModuleAction('salaries', 'read')))
                    @canRead('employees')
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('employees.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('employees.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Employees List
                    </a>
                    @endcanRead

                    @canRead('salaries')
                    <a href="{{ route('salaries.index') }}"
                        class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('salaries.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5 {{ request()->routeIs('salaries.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Salaries List
                    </a>
                    @endcanRead
                    @endif

                    {{-- Section 2: Master Data Hub --}}
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('groups', 'read') || auth()->user()->hasModuleAction('brands', 'read') || auth()->user()->hasModuleAction('categories', 'read') || auth()->user()->hasModuleAction('units', 'read')))
                    <div class="pt-6">
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-6">Master
                            Data</p>

                        @canRead('groups')
                        <a href="{{ route('groups.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('groups.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('groups.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Manf. Groups
                        </a>
                        @endcanRead

                        @canRead('brands')
                        <a href="{{ route('brands.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('brands.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('brands.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Brands
                        </a>
                        @endcanRead

                        @canRead('categories')
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('categories.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Product Categories
                        </a>
                        @endcanRead

                        @canRead('units')
                        <a href="{{ route('units.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('units.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('units.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            Units of Measure
                        </a>
                        @endcanRead
                        @canRead('distributors')
                        <a href="{{ route('distributors.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('distributors.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('distributors.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Distribution Partners
                        </a>
                        @endcanRead
                    </div>
                    @endif

                    {{-- Section 4: Intelligence & Analytics --}}
                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('reports', 'read')))
                    <div>
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-6">Reports
                            Management</p>
                        @canRead('reports')
                        <a href="{{ route('reports.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reports.index') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('reports.index') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Financial Ledger
                        </a>
                        <a href="{{ route('reports.audit') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reports.audit') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('reports.audit') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Stock Audit Hub
                        </a>
                        @endcanRead
                    </div>
                    @endif
                    <div>
                        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasModuleAction('roles', 'read') || auth()->user()->hasModuleAction('users', 'read') || auth()->user()->hasModuleAction('settings', 'read') || auth()->user()->hasModuleAction('activities', 'read')))
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Security &
                            Governance</p>

                        @canRead('roles')
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('roles.*') ? 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('roles.*') ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Access Matrix
                        </a>
                        @endcanRead

                        @canRead('users')
                        <a href="{{ route('users.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('users.*') ? 'text-teal-600 dark:text-teal-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Staff Management
                        </a>
                        @endcanRead

                        @canRead('activities')
                        <a href="{{ route('activities.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('activities.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('activities.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Activity Ledger
                        </a>
                        @endcanRead

                        @canRead('settings')
                        <a href="{{ route('settings.index') }}" style="margin-bottom: 20px;"
                            class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('settings.*') ? 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('settings.*') ? 'text-slate-600 dark:text-slate-400' : 'text-slate-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            System Settings
                        </a>
                        @endcanRead
                        @endif
                    </div>
                </nav>

                <!-- User / Account Section -->
                <div
                    class="p-4 border-t border-slate-100 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md mt-auto">

                    <!-- PWA Install Button -->
                    <button id="pwa-install-btn" style="display: none;"
                        class="flex items-center gap-3 w-full hover:bg-slate-50 dark:hover:bg-slate-800 p-2 rounded-xl transition-all active:scale-95 group mb-2 border border-slate-100 dark:border-slate-800 shadow-sm cursor-pointer">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                        </div>
                        <div class="flex-1 text-left min-w-0">
                            <p
                                class="text-[11px] font-black text-slate-900 dark:text-slate-100 truncate tracking-tight uppercase">
                                Install Web App</p>
                            <p
                                class="text-[9px] text-indigo-400 dark:text-indigo-500 font-bold uppercase tracking-[0.1em]">
                                Faster Experience</p>
                        </div>
                    </button>

                    @auth
                        <div class="flex items-center gap-3 group">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 min-w-0 flex-1 hover:bg-slate-50 dark:hover:bg-slate-800 p-1.5 rounded-xl transition-all active:scale-95 group">
                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 font-black text-xs border border-teal-100 dark:border-teal-900/50 group-hover:bg-teal-600 group-hover:text-white transition-all shadow-sm">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-[11px] font-black text-slate-900 dark:text-slate-100 truncate tracking-tight">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p
                                        class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-[0.1em]">
                                        {{ auth()->user()->role }}
                                    </p>
                                </div>
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-opacity text-slate-300 dark:text-slate-600 mr-1">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="p-2 text-slate-300 dark:text-slate-600 hover:text-rose-500 transition-all hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg active:scale-90"
                                    title="Secure Exit">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </aside>

            <!-- Main Wrapper -->
            <div class="flex flex-col flex-1 min-w-0 overflow-hidden dark:bg-slate-950">
                <!-- Header -->
                <header
                    class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 lg:px-8 z-10 flex-shrink-0">
                    <div class="flex items-center gap-4 flex-1">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="max-w-md w-full relative" x-data="globalSearch()">
                            <div class="relative group">
                                <input type="text" x-model="query" @input.debounce.300ms="search" @focus="isOpen = true"
                                    @click.away="isOpen = false"
                                    placeholder="Discover anything (Products, Docs, Staff)..."
                                    class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-xl py-2 px-3 pl-11 pr-4 text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:bg-white dark:focus:bg-slate-600 transition-all shadow-inner group-hover:bg-slate-100 dark:group-hover:bg-slate-700/50">
                                <div
                                    class="absolute left-4 top-2 text-slate-400 dark:text-slate-500 group-hover:text-teal-600 transition-colors">

                                </div>
                            </div>

                            <!-- Categorized Intelligence Dropdown -->
                            <div x-show="isOpen && query.length > 1" x-transition.origin.top.duration.200ms
                                style="display: none;"
                                class="absolute mt-3 w-full max-w-[500px] bg-white dark:bg-slate-900 shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[2rem] border border-slate-100 dark:border-slate-800 z-[100] overflow-hidden backdrop-blur-2xl">
                                <div class="max-h-[600px] overflow-y-auto custom-scrollbar p-3 space-y-4">
                                    <template x-for="(items, category) in results" :key="category">
                                        <div class="space-y-1">
                                            <div class="px-4 py-2 flex items-center justify-between group/cat">
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]"
                                                        x-text="category"></span>
                                                </div>
                                                <div
                                                    class="h-[1px] flex-1 ml-4 bg-slate-100 dark:bg-slate-800 transition-colors">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 gap-1">
                                                <template x-for="item in items" :key="item.url">
                                                    <a :href="item.url"
                                                        class="group flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-teal-50 dark:hover:bg-teal-900/30 transition-all active:scale-[0.99]">
                                                        <div
                                                            class="h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 group-hover:bg-teal-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-teal-500/30 transition-all border border-slate-100 dark:border-slate-700 group-hover:border-teal-500">
                                                            <template x-if="item.icon === 'package'">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                                </svg>
                                                            </template>
                                                            <template x-if="item.icon === 'file-text'">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </template>
                                                            <template x-if="item.icon === 'truck'">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </template>
                                                            <template x-if="item.icon === 'users'">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                </svg>
                                                            </template>
                                                            <template x-if="item.icon === 'layout' || !item.icon">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                                                </svg>
                                                            </template>
                                                            <template x-if="item.icon === 'settings'">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                            </template>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs font-black text-slate-800 dark:text-slate-100 truncate group-hover:text-teal-700 dark:group-hover:text-teal-400"
                                                                x-text="item.title"></p>
                                                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-tight mt-0.5"
                                                                x-text="item.meta"></p>
                                                        </div>
                                                        <div
                                                            class="opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 mr-2 text-teal-600">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="Object.keys(results).length === 0 && query.length > 1"
                                        class="py-12 text-center">
                                        <p
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">
                                            No matching records found.</p>
                                    </div>
                                </div>
                                <!-- Search Footer -->
                                <div
                                    class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/20 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Global
                                        Discovery Matrix</span>
                                    <div class="flex gap-2">
                                        <kbd
                                            class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-[8px] font-bold text-slate-400 shadow-sm">ESC</kbd>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase">to close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <button @click="$store.backupHub.openModal()"
                            class="p-2 rounded-xl text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all active:scale-90 group relative"
                            title="Cloud Redundancy Hub">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                        </button>

                        <!-- PWA Install Button -->
                        <button id="pwa-install-btn" style="display: none;"
                            class="p-2 rounded-xl text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all active:scale-90 relative"
                            title="Install Alif Pharma App">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </button>

                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-0.5"></div>
                        <button @click="toggleTheme(); darkMode = !darkMode"
                            class="p-2 rounded-xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-teal-600 transition-all active:scale-90">
                            <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg x-show="darkMode" style="display: none;" class="h-5 w-5 text-amber-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ date('M d, Y') }}</span>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-slate-50 dark:bg-slate-950 p-6 lg:p-10">
                    <div class="max-w-7xl mx-auto">
                        @yield('content')
                    </div>

                    <!-- Cloud Redundancy & Network Discovery Modal -->
                    <div x-show="$store.backupHub.show" x-transition.opacity
                        @keydown.escape.window="$store.backupHub.show = false"
                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                        style="display: none;">
                        <div @click.away="!$store.backupHub.loading && ($store.backupHub.show = false)"
                            class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all transform scale-100">
                            <!-- Modal Header -->
                            <div class="px-10 pt-10 pb-6 text-center">
                                <div
                                    class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 mb-6 border border-indigo-100 dark:border-indigo-900/50 shadow-sm">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">
                                    Secondary Redundancy Hub</h3>
                                <p
                                    class="text-[11px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mt-2 px-8">
                                    Mirror pharmaceutical ledger to Google Drive & Share Access</p>
                            </div>

                            <!-- Network Access Card -->
                            <div class="px-10 pb-8">
                                <div
                                    class="bg-indigo-900/5 dark:bg-indigo-900/10 rounded-3xl p-6 mb-2 border border-indigo-100/50 dark:border-indigo-900/20">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                                        <span
                                            class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Active
                                            Network Presence</span>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between group">
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Permanent
                                                Domain Link</span>
                                            <span
                                                class="text-xs font-black text-slate-900 dark:text-white cursor-pointer hover:text-indigo-600 transition-colors"
                                                x-text="$store.backupHub.lanInfo.domain_link || 'Loading...'"
                                                @click="$store.backupHub.copy($store.backupHub.lanInfo.domain_link)"></span>
                                        </div>
                                        <div class="h-px bg-slate-200 dark:bg-slate-800 w-full"></div>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Direct
                                                IP Link</span>
                                            <span class="text-xs font-black text-slate-600 dark:text-slate-300"
                                                x-text="$store.backupHub.lanInfo.ip_link || 'Detecting...'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Backup Action Area -->
                            <div class="px-10 pb-10 mb-4">
                                <button @click="$store.backupHub.startBackup()" :disabled="$store.backupHub.loading"
                                    class="group relative w-full h-24 rounded-3xl flex flex-col items-center justify-center transition-all overflow-hidden"
                                    :class="$store.backupHub.loading ? 'bg-slate-100 dark:bg-slate-800' : 'bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] shadow-2xl shadow-indigo-500/30'">

                                    <template x-if="!$store.backupHub.loading">
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="text-white font-black text-sm uppercase tracking-[0.3em]">Initiate
                                                Mirror</span>
                                            <span class="text-indigo-200 text-[10px] font-bold uppercase mt-1">Start
                                                Primary Cloud Sync</span>
                                        </div>
                                    </template>

                                    <template x-if="$store.backupHub.loading">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="h-6 w-6 border-2 border-slate-300 border-t-indigo-600 rounded-full animate-spin mb-2">
                                            </div>
                                            <span
                                                class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Mirroring
                                                Redundant Data...</span>
                                        </div>
                                    </template>

                                    <!-- Pulse decorative effect -->
                                    <div x-show="!$store.backupHub.loading"
                                        class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity">
                                    </div>
                                </button>

                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            // Global Redundancy Store (Managed Cloud Mirroring)
            Alpine.store('backupHub', {
                show: false,
                loading: false,
                lanInfo: { domain_link: '', ip_link: '' },

                openModal() {
                    this.show = true;
                    this.fetchInfo();
                },

                async fetchInfo() {
                    try {
                        const res = await fetch("{{ route('backup.info') }}");
                        const data = await res.json();
                        if (data.success) {
                            this.lanInfo = data;
                        }
                    } catch (e) { console.error('Discovery Error:', e); }
                },

                async startBackup() {
                    this.loading = true;
                    try {
                        const res = await fetch("{{ route('backup.run') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (data.success) {
                            toastr.success(data.message);
                            this.show = false;
                        } else {
                            toastr.error(data.message || 'Mirroring Protocol Interrupted');
                        }
                    } catch (e) {
                        toastr.error('Infrastructure Failure: Mirroring offline');
                    } finally {
                        this.loading = false;
                    }
                },

                copy(text) {
                    if (!text) return;
                    navigator.clipboard.writeText(text);
                    toastr.info('Link secured to clipboard');
                }
            });

            // Universal Intelligence Hub (Search)
            Alpine.data('globalSearch', () => ({
                query: '',
                results: {},
                isOpen: false,
                async search() {
                    if (this.query.length < 2) {
                        this.results = {};
                        this.isOpen = false;
                        return;
                    }
                    try {
                        const res = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
                        if (res.ok) {
                            this.results = await res.json();
                            this.isOpen = true;
                        }
                    } catch (e) { console.error(e); }
                }
            }));
        });
    </script>
    <script src="{{ asset('vendor/js/alpine.min.js') }}"></script>
    <script>
        // Synchronized Preloader Release
        function releasePreloader() {
            const preloader = document.getElementById('app-preloader');
            if (preloader) {
                preloader.classList.add('fade-out');
                setTimeout(() => preloader.remove(), 700);
            }
        }
        window.addEventListener('load', releasePreloader);
        document.addEventListener('DOMContentLoaded', () => setTimeout(releasePreloader, 1000));
    </script>

    <script>
        // Theme Infrastructure Logic
        function toggleTheme() {
            if (localStorage.theme === 'dark') {
                localStorage.theme = 'light';
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.theme = 'dark';
                document.documentElement.classList.add('dark');
            }
        }
    </script>

    <script>
        // DataTables Global Intelligence Hub Initialization
        if ($.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"dt-layout-row"Bf>rt<"dt-layout-row"ilp>',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<span><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>Export PDF</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'print',
                        text: '<span><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>Print Audit</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'excel',
                        text: '<span><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Excel Ledger</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'copy',
                        text: '<span><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>Copy Results</span>',
                        className: 'dt-button'
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search Intelligence Hub...",
                    lengthMenu: "Show _MENU_ records",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        next: '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                        previous: '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>'
                    }
                },
                pageLength: 25,
                autoWidth: false,
                responsive: true
            });

            // Automatically initialize ALL tables that are not yet DataTables
            $(document).ready(function () {
                // Prevent DataTables from throwing JS alerts for initialization errors globally
                $.fn.dataTable.ext.errMode = 'none';

                $('table').each(function () {
                    if (!$.fn.DataTable.isDataTable(this)) {
                        // Detect if the table only has a Blade empty state (single row with a colspan)
                        let isBladeEmptyState = $(this).find('tbody tr').length === 1 && $(this).find('tbody tr td[colspan]').length === 1;

                        // Skip tables that are clearly not meant for DataTables
                        if (!$(this).hasClass('no-datatable') && !isBladeEmptyState && $(this).find('tbody tr').length > 0) {
                            $(this).DataTable();
                        }
                    }
                });
            });
        }
    </script>
    <script>
        // Global Notification System (Toastr)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}", "Operation Successful");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", "Execution Halted");
        @endif

        // Global Delete Confirmation (SweetAlert2)
        window.confirmDelete = function(formId, title = "Are you sure?", text = "This action cannot be undone and will affect inventory records.", confirmButtonText = "Yes, delete it!") {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488', // Teal-600
                cancelButtonColor: '#64748b',  // Slate-500
                confirmButtonText: confirmButtonText,
                background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f1f5f9' : '#1e293b'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        };

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.warning("{{ $error }}", "Entry Validation Alert");
            @endforeach
        @endif
    </script>

    <script>
        // Infrastructure Restoration: Restore Electron context after all vendor scripts initialized
        if (window.electronModule) {
            module = window.electronModule;
        }
    </script>
    <script>
        // PWA Service Worker & Install Logic
        let deferredPrompt;
        const installBtn = document.getElementById('pwa-install-btn');

        // Check if already installed
        if (window.matchMedia('(display-mode: standalone)').matches) {
            if (installBtn) installBtn.style.display = 'none';
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((reg) => {
                    console.log('PWA Service Worker Registered', reg);
                }).catch((err) => {
                    console.log('PWA Service Worker Failed', err);
                });
            });
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            // Only show button when the browser is ready to install
            if (installBtn) installBtn.style.display = 'flex';
        });

        if (installBtn) {
            installBtn.addEventListener('click', (e) => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            installBtn.style.display = 'none';
                        }
                        deferredPrompt = null;
                    });
                }
            });
        }

        window.addEventListener('appinstalled', (event) => {
            console.log('PWA was installed');
            if (installBtn) installBtn.style.display = 'none';
        });
    </script>
</body>

</html>
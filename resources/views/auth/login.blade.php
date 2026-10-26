<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alif Pharma - Secure Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Executive Branded Preloader (Synchronized) */
        #app-preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s;
        }
        #app-preloader.fade-out { opacity: 0; visibility: hidden; }
        
        .loader-logo {
            width: 140px;
            margin-bottom: 24px;
            animation: pulse-glow 2s infinite ease-in-out;
        }

        .loader-text {
            font-size: 10px; font-weight: 800; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.3em;
            animation: text-blink 1.5s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 10px 20px rgba(13, 148, 136, 0.2)); }
            50% { transform: scale(1.05); filter: drop-shadow(0 15px 30px rgba(13, 148, 136, 0.4)); }
        }

        @keyframes text-blink {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 selection:bg-teal-500 selection:text-white">

    <!-- Executive Alif Pharma Preloader -->
    <div id="app-preloader">
        <div class="loader-logo">
            <img src="{{ asset('alif-logo.png') }}" alt="Alif Pharma Logo" class="w-full h-auto">
        </div>
        <div class="loader-text">Secure Identity Hub</div>
        <div class="mt-4 flex gap-1">
            <div class="w-1 h-1 rounded-full bg-teal-200 animate-bounce" style="animation-delay: 0s"></div>
            <div class="w-1 h-1 rounded-full bg-teal-400 animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1 h-1 rounded-full bg-teal-600 animate-bounce" style="animation-delay: 0.4s"></div>
        </div>
    </div>

<div class="flex min-h-full">
    
    <!-- Left: Identity & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden isolate items-center justify-center p-24">
        <!-- Abstract patterns -->
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:32px_32px]"></div>
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-center max-w-lg">
            <div class="inline-flex mb-8">
                <img src="{{ asset('alif-logo.png') }}" class="h-24 w-auto brightness-0 invert" alt="Alif Pharma Logo">
            </div>
            <h1 class="text-5xl font-black text-white tracking-tighter mb-4 uppercase">Alif Pharma</h1>
            <p class="text-slate-400 text-lg leading-relaxed font-medium">Precision Pharmaceutical Logistics. Centralized inventory tracking, real-time movements, and financial micro-reporting.</p>
            
            <div class="mt-12 grid grid-cols-2 gap-4 text-left">
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-teal-400 font-black text-lg mb-1 tracking-tight">OFFLINE CODEBASE</p>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Secure Local SQLite Engine</p>
                </div>
                <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-teal-400 font-black text-lg mb-1 tracking-tight">RAPID AUDIT</p>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">End-to-End Asset Logs</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right: Authentication Hub -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
        <div class="w-full max-w-sm">
            <div class="mb-12 lg:hidden text-center flex justify-center">
                <img src="{{ asset('alif-logo.png') }}" class="h-12 w-auto" alt="Alif Pharma Logo">
            </div>

            <div class="mb-10">
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-2">ACCESS HUB</h2>
                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Identify Yourself to Proceed</p>
            </div>
            
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 p-4 rounded-xl text-[10px] font-bold text-rose-600 uppercase tracking-widest space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-center gap-2"><span class="h-1 w-1 bg-rose-500 rounded-full"></span> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Command Email</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required value="{{ old('email') }}" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all transition-colors placeholder:text-slate-300" placeholder="admin@alifpharma.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Security Cipher</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all transition-colors placeholder:text-slate-300" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center cursor-pointer group">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 border-slate-300 rounded focus:ring-teal-500 transition-all">
                        <span class="ml-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Persistent Session</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-4 text-xs font-black text-white hover:bg-slate-800 shadow-xl shadow-slate-900/10 transition-all active:scale-[0.98] uppercase tracking-widest">
                        Initialize Session &rarr;
                    </button>
                </div>
            </form>

            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col items-center gap-4">
                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.3em]">Alif Pharma Logistics Engine v2.0</p>
                <div class="flex gap-4">
                    <svg class="h-4 w-4 text-slate-200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    <svg class="h-4 w-4 text-slate-200" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        // Synchronized Preloader Release
        window.addEventListener('load', function() {
            const preloader = document.getElementById('app-preloader');
            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.remove();
                }, 500);
            }, 200);
        });
    </script>
</body>
</html>

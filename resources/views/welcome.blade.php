<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Point Of Sale') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                dark: '#121214',      // Main background matching dashboard
                                card: '#1c1c1e',      // Card / Sidebar background
                                border: '#2b2b2e',    // Subtle borders
                                accent: '#22c55e',    // Green chart accent
                                hover: '#16a34a',
                                white: '#ffffff',
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-brand-dark text-neutral-200 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-brand-accent selection:text-white">

        <!-- Top Navigation -->
        <header class="w-full max-w-5xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand-white border border-brand-border flex items-center justify-center text-brand-dark">
                    <!-- Store/POS Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>
                </div>
                <span class="font-semibold text-lg text-white tracking-wide">Point Of Sale</span>
            </div>

            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium bg-brand-accent hover:bg-brand-hover text-black rounded-lg transition-colors">
                        Go to Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium bg-brand-card hover:bg-brand-border text-white border border-brand-border rounded-lg transition-colors">
                        Sign In
                    </a>
                @endauth
            </nav>
        </header>

        <!-- Main Content -->
        <main class="w-full max-w-5xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center">
            
            <!-- Store Welcome Header -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-card border border-brand-border text-xs text-neutral-400 mb-6">
                <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                System Ready & Operational
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight max-w-2xl leading-tight">
                Store Management & Checkout
            </h1>
            
            <p class="text-neutral-400 text-sm md:text-base mt-4 max-w-md">
                Simple tool for tracking daily sales, managing shop inventory, and checking performance reports.
            </p>

            <!-- Quick Access Button -->
            <div class="mt-8 flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-brand-accent hover:bg-brand-hover text-black font-semibold rounded-lg shadow-lg shadow-green-900/20 transition-all flex items-center gap-2">
                        <span>Open POS System</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-brand-accent hover:bg-brand-hover text-black font-semibold rounded-lg shadow-lg shadow-green-900/20 transition-all flex items-center gap-2">
                        <span>Register Your Store</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Simple Feature Quick Grid (Matches dashboard structure) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full mt-16 text-left">
                <div class="p-5 bg-brand-card border border-brand-border rounded-xl">
                    <div class="text-brand-accent text-sm font-semibold uppercase tracking-wider mb-1">Checkout</div>
                    <div class="text-white text-base font-medium">Fast Transactions</div>
                    <p class="text-xs text-neutral-400 mt-1">Quick barcode scan or manual item picking for instant orders.</p>
                </div>

                <div class="p-5 bg-brand-card border border-brand-border rounded-xl">
                    <div class="text-brand-accent text-sm font-semibold uppercase tracking-wider mb-1">Products</div>
                    <div class="text-white text-base font-medium">Easy Inventory</div>
                    <p class="text-xs text-neutral-400 mt-1">Add, update prices, or adjust stock numbers in seconds.</p>
                </div>

                <div class="p-5 bg-brand-card border border-brand-border rounded-xl">
                    <div class="text-brand-accent text-sm font-semibold uppercase tracking-wider mb-1">Reports</div>
                    <div class="text-white text-base font-medium">Daily Sales Summary</div>
                    <p class="text-xs text-neutral-400 mt-1">Check today's total revenue, profit, and transaction counts.</p>
                </div>
            </div>

        </main>

        <!-- Minimal Footer -->
        <footer class="w-full max-w-5xl mx-auto px-6 py-6 text-center text-xs text-neutral-500 border-t border-brand-border/40">
            Internal POS System &bull; Built with Laravel
        </footer>

    </body>
</html>
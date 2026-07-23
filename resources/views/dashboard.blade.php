<x-layouts::app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 p-1">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-100">
                    Dashboard
                </h1>
                <p class="mt-0.5 text-sm text-neutral-500 dark:text-neutral-400">
                    Welcome back, {{ auth()->user()->name }}
                </p>
            </div>
            <span class="text-xs text-neutral-400 dark:text-neutral-500">
                {{ now()->format('l, F j') }}
            </span>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Today's Sale</p>
                <p class="mt-2 text-2xl font-bold text-neutral-900 dark:text-white">K3,485.12</p>
                <p class="mt-1 text-xs text-emerald-500">+5.2% since yesterday</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Weekly Sale</p>
                <p class="mt-2 text-2xl font-bold text-neutral-900 dark:text-white">K21,976.44</p>
                <p class="mt-1 text-xs text-emerald-500">+12.8% since last week</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Profit</p>
                <p class="mt-2 text-2xl font-bold text-neutral-900 dark:text-white">K4,210.75</p>
                <p class="mt-1 text-xs text-emerald-500">19.1% margin</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Transactions</p>
                <p class="mt-2 text-2xl font-bold text-neutral-900 dark:text-white">118</p>
                <p class="mt-1 text-xs text-emerald-500">+7 since yesterday</p>
            </div>
        </div>

        {{-- Overview + Transaction History --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:h-[460px]">
            

            {{-- Overview Chart --}}
            <div class="flex-1 min-h-[300px] rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900 flex flex-col">
                <p class="text-sm font-medium text-neutral-900 dark:text-white shrink-0">Sales Overview</p>
                <div class="mt-4 h-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Transaction History --}}
            <div class="w-full lg:w-72 shrink-0 max-h-[400px] lg:max-h-none rounded-xl border border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900 flex flex-col">
                <div class="border-b border-neutral-200 px-5 py-4 dark:border-neutral-800 shrink-0">
                    <p class="text-sm font-semibold text-neutral-900 dark:text-white">Transaction History</p>
                </div>
                {{-- ONLY this div scrolls --}}
                <div class="flex-1 overflow-y-auto divide-y divide-neutral-100 dark:divide-neutral-800">
                    <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Coffee Machine Sold</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 23, 10:05 AM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">John D.</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K499.00</span>
                        </div>
                    </div>
                    <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Bean Refill Order</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 22, 11:20 AM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">Sarah K.</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K143.50</span>
                        </div>
                    </div>
                    <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Espresso Sales</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 23, 12:15 PM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">Anonymous</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K85.20</span>
                        </div>
                    </div>
                    <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Espresso Sales</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 23, 12:30 PM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">Anonymous</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K95.00</span>
                        </div>
                    </div>
                     <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Espresso Sales</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 23, 12:30 PM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">Anonymous</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K95.00</span>
                        </div>
                    </div>
                     <div class="px-5 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-neutral-900 dark:text-white">Espresso Sales</p>
                                <p class="mt-0.5 text-xs text-neutral-400">July 23, 12:30 PM</p>
                                <p class="mt-0.5 text-xs text-neutral-500">Anonymous</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-indigo-500">K95.00</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-layouts::app>
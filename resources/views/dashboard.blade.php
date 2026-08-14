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
                <p class="mt-2 text-xl font-bold text-neutral-900 dark:text-white">{{ $today_sale }} Ks</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Weekly Sale</p>
                <p class="mt-2 text-xl font-bold text-neutral-900 dark:text-white">{{ $weekly_sale }} Ks</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Today's Profit</p>
                <p class="mt-2 text-xl font-bold text-neutral-900 dark:text-white">{{ $today_profit }} Ks</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-widest text-neutral-400">Transactions</p>
                <p class="mt-2 text-xl font-bold text-neutral-900 dark:text-white">{{ $transaction_total }}</p>
            </div>
        </div>

        {{-- Overview + Transaction History --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:h-[640px]">
            

            {{-- Overview Chart --}}
            <div class="flex-1 min-h-[300px] rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900 flex flex-col">
                <p class="text-sm font-medium text-neutral-900 dark:text-white shrink-0">Sales Overview</p>
                <div class="mt-4 h-full">
                    @foreach ($graph_data as $val)
                        <p class="values" data-val="{{ $val }}" hidden></p>
                    @endforeach
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
       </div>

    </div>

</x-layouts::app>
<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-1">

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
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 bg-white px-5 py-4 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400 dark:text-neutral-500">Total Users</p>
                <p class="mt-2 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">—</p>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">No data yet</p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white px-5 py-4 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400 dark:text-neutral-500">Revenue</p>
                <p class="mt-2 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">—</p>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">No data yet</p>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white px-5 py-4 dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400 dark:text-neutral-500">Active Sessions</p>
                <p class="mt-2 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">—</p>
                <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">No data yet</p>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="grid flex-1 grid-cols-1 gap-4 lg:grid-cols-3">

            {{-- Large Panel --}}
            <div class="lg:col-span-2 flex flex-col rounded-xl border border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between border-b border-neutral-100 px-5 py-4 dark:border-neutral-800">
                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Overview</p>
                    <span class="rounded-md bg-neutral-100 px-2 py-0.5 text-xs text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400">Empty</span>
                </div>
                <div class="flex flex-1 items-center justify-center py-16">
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 dark:border-neutral-700">
                            <svg class="h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">No chart data</p>
                        <p class="mt-1 text-xs text-neutral-400">Connect your data source to see activity here.</p>
                    </div>
                </div>
            </div>

            {{-- Side Panel --}}
            <div class="flex flex-col rounded-xl border border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
                <div class="border-b border-neutral-100 px-5 py-4 dark:border-neutral-800">
                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Recent Activity</p>
                </div>
                <div class="flex flex-1 items-center justify-center py-12">
                    <div class="text-center px-6">
                        <div class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full border border-neutral-200 dark:border-neutral-700">
                            <svg class="h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">No activity yet</p>
                        <p class="mt-1 text-xs text-neutral-400">Actions you take will appear here.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-layouts::app>
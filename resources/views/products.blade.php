<x-layouts::app :title="__('Products')">
    {{-- Outer State: Handles the "Add Product" Modal --}}
    <div x-data="{ openModal: false }">
        <div class="space-y-6">

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-neutral-900 dark:text-white">
                        Product Inventory
                    </h1>

                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Manage your products and add items to cart
                    </p>
                </div>

                {{-- Add Product Button --}}
                <button
                    type="button"
                    @click="openModal = true"
                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                    + Add Product
                </button>
            </div>

            {{-- Stats --}}
            <div class="grid gap-4 sm:grid-cols-2">

                <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-500">
                        Total Products
                    </p>
                    <h2 class="mt-2 text-2xl font-semibold dark:text-white">
                        {{ count($products) }}
                    </h2>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-500">
                        Categories
                    </p>
                    <h2 class="mt-2 text-2xl font-semibold dark:text-white">
                        {{ count($category) }}
                    </h2>
                </div>
            </div>


            {{-- Search + Filter --}}
            <div class="flex flex-col gap-3 sm:flex-row">

                <div class="flex-1">
                    <input
                        type="text"
                        placeholder="Search product..."
                        class="w-full rounded-xl border-neutral-200 bg-white px-4 py-3 text-sm dark:border-neutral-800 dark:bg-neutral-900 dark:text-white"
                    >
                </div>

                <select
                autocomplete="off"
                    class="rounded-xl border-neutral-200 bg-white px-4 py-3 text-sm dark:border-neutral-800 dark:bg-neutral-900 dark:text-white">

                    <option @selected(true)>
                        All Categories
                    </option>
                    @foreach ($category as $cat)
                        <option value="{{ $cat->name }}">
                            {{ $cat->name }}
                        </option>
                    @endforeach
                    
                </select>

            </div>

            {{-- Products List --}}
            <div class="space-y-4">

                @foreach($products as $item)
                        
                    {{-- Inner State: Isolated for each item's "Edit" Modal --}}
                    <div x-data="{ editModal: false }" class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900 sm:p-5">

                        <div class="flex flex-col gap-4 lg:grid lg:grid-cols-12 lg:items-center lg:gap-4">

                            {{-- Column 1: Product Name & Badge --}}
                            <div class="flex items-center gap-3 lg:col-span-4">
                                <h3 class="truncate font-semibold text-neutral-900 dark:text-white" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </h3>
                                
                                <span class="shrink-0 rounded-full bg-neutral-100 px-3 py-1 text-xs text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">
                                    {{ $item->categories->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            {{-- Column 3: Price --}}
                            <div class="text-sm text-neutral-500 lg:col-span-4 lg:text-center">
                                Price:
                                <span class="font-medium text-neutral-900 dark:text-white">
                                    {{ $item->selling_price }} Ks
                                </span>
                            </div>

                            {{-- Column 4: Buttons --}}
                            <div class="flex items-center gap-2 pt-2 sm:pt-0 lg:col-span-4 lg:justify-end lg:pt-0">

                                {{-- EDIT BUTTON (Triggers this item's editModal) --}}
                                <button 
                                    type="button"
                                    @click="editModal = true"
                                    class="flex-1 rounded-lg border border-neutral-200 px-3 py-2 text-center text-sm hover:bg-neutral-100 dark:border-neutral-700 dark:hover:bg-neutral-800 lg:flex-none">
                                    Edit
                                </button>

                                {{-- DELETE FORM --}}
                                <form action="{{ route('products.destroy', $item->id) }}" method="POST" class="flex-1 rounded-lg border border-red-200 px-3 py-2 text-center text-sm text-red-500 hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-950 lg:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this item?')">
                                        Delete
                                    </button>
                                </form>

                                {{-- CART BUTTON --}}
                                <button type="button" id='add_to_cart_btn' data-id={{ $item->id }} class="flex-1 rounded-lg border border-green-600 px-3 py-2 text-center text-sm text-green-600 hover:bg-green-50 dark:hover:bg-green-950 lg:flex-none">
                                    Cart
                                </button>

                            </div>

                        </div>

                        {{-- EDIT MODAL (Per Product) --}}
                        <div 
                            x-show="editModal" 
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">

                            <div 
                                x-data="{ isNewCategory: false }"
                                @click.away="editModal = false"
                                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">

                                {{-- Edit Modal Header --}}
                                <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-neutral-800">
                                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Edit Product</h3>
                                    <button type="button" @click="editModal = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-white">
                                        ✕
                                    </button>
                                </div>

                                {{-- Edit Form --}}
                                <form action="{{ route('products.update', $item->id) }}" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    @method('PUT')

                                    {{-- Name --}}
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Product Name</label>
                                        <input type="text" name="name" value="{{ $item->name }}" required
                                            class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                                    </div>

                                    {{-- Dynamic Category Input --}}
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400">Category</label>
                                            
                                            <button 
                                                type="button" 
                                                @click="isNewCategory = !isNewCategory" 
                                                class="text-xs text-green-600 hover:underline dark:text-green-400 font-medium">
                                                <span x-show="!isNewCategory">+ New Category</span>
                                                <span x-show="isNewCategory">Select Existing</span>
                                            </button>
                                        </div>

                                        {{-- Existing Category Dropdown --}}
                                        <div x-show="!isNewCategory">
                                            <select 
                                                ::required="!isNewCategory"
                                                name="category"
                                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:bg-neutral-900 dark:focus:border-neutral-400">
                                                <option value="">Select Category</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}" @selected($cat->id == $item->category_id)>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- New Category Input --}}
                                        <div x-show="isNewCategory" x-cloak>
                                            <input 
                                                type="text" 
                                                ::required="isNewCategory"
                                                name="new_category" 
                                                placeholder="e.g. Fast Foods"
                                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                                        </div>
                                    </div>

                                    {{-- Prices --}}
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Cost Price</label>
                                            <input type="number" name="cost" value="{{ $item->buying_price }}" min="0" required
                                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Selling Price (Ks)</label>
                                            <input type="number" name="price" value="{{ $item->selling_price }}" min="0" required
                                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                                        <button type="button" @click="editModal = false"
                                            class="rounded-lg border border-neutral-200 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                                            Cancel
                                        </button>
                                        
                                        <button type="submit"
                                            class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                            Update Product
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                    
                @endforeach

            </div>

        </div>

        {{-- ADD NEW PRODUCT MODAL (Top Level) --}}
        <div 
            x-show="openModal" 
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            {{-- Modal Box --}}
            <div 
                x-data="{ isNewCategory: false }"
                @click.away="openModal = false"
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-neutral-800">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Add New Product</h3>
                    <button type="button" @click="openModal = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-white">
                        ✕
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('products.create') }}" method="POST" class="mt-4 space-y-4">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g. Potato Chips"
                            class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                    </div>

                    {{-- Dynamic Category Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400">Category</label>
                            
                            <button 
                                type="button" 
                                @click="isNewCategory = !isNewCategory" 
                                class="text-xs text-green-600 hover:underline dark:text-green-400 font-medium">
                                <span x-show="!isNewCategory">+ New Category</span>
                                <span x-show="isNewCategory">Select Existing</span>
                            </button>
                        </div>

                        {{-- Existing Category Dropdown --}}
                        <div x-show="!isNewCategory">
                            <select 
                                ::required="!isNewCategory"
                                name="category"
                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:bg-neutral-900 dark:focus:border-neutral-400">
                                <option value="">Select Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- New Category Text Input --}}
                        <div x-show="isNewCategory" x-cloak>
                            <input 
                                type="text" 
                                ::required="isNewCategory"
                                name="new_category" 
                                placeholder="e.g. Fast Foods"
                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                        </div>
                    </div>

                    {{-- Prices (2 Columns) --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Cost Price</label>
                            <input type="number" name="cost" min="0" required placeholder="1500"
                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-neutral-600 dark:text-neutral-400 mb-1">Selling Price (Ks)</label>
                            <input type="number" name="price" min="0" required placeholder="2000"
                                class="w-full rounded-lg border border-neutral-200 bg-transparent px-3 py-2 text-sm text-neutral-900 outline-none focus:border-neutral-900 dark:border-neutral-700 dark:text-white dark:focus:border-neutral-400">
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                        <button type="button" @click="openModal = false"
                            class="rounded-lg border border-neutral-200 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                            Cancel
                        </button>
                        
                        <button type="submit"
                            class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                            Save Product
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts::app>
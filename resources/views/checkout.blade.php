<x-layouts::app :title="__('Checkout')">

  <!-- MAIN CONTENT AREA -->
  <main class="flex-1 lg:p-1 sm:p-2 overflow-y-auto">
    <!-- Header -->
    <header class="mb-6">
      <h1 class="text-xl font-bold">Checkout</h1>
      <p class="text-gray-400 text-sm">Process current customer order and payment</p>
    </header>

    <!-- Responsive Grid Layout (Stretched height) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch min-h-[calc(100vh-240px)]">
      
      <!-- LEFT SECTION: Selected Items Table -->
      <section class="lg:col-span-7 xl:col-span-8 dark:bg-neutral-900 p-4 sm:p-6 rounded-xl border border-[#2a2a2a] flex flex-col justify-between">
        <div class="flex flex-col h-full">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Current Order Items</h2>
            <button class="text-xs text-red-400 hover:underline" id="clear_all_btn">Clear All</button>
          </div>

          <!-- Scrollable Items List Container (Expands vertically) -->
          <div id='cart_list' class="flex-1 space-y-3 overflow-y-auto pr-1 max-h-[calc(100vh-260px)] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-[#333333] [&::-webkit-scrollbar-thumb]:rounded-full">
            
            <!-- Row Item -->
            
          </div>
        </div>
      </section>

      <!-- RIGHT SECTION: Payment & Summary Panel -->
      <section class="lg:col-span-5 xl:col-span-4 flex flex-col justify-between dark:bg-neutral-900 p-4 sm:p-6 rounded-xl border border-[#2a2a2a]">
        <div class="space-y-4">
          <h2 class="text-lg font-semibold border-b border-[#2d2d2d] pb-3">Payment Summary</h2>

          <div class="space-y-2 text-sm">
            <div class="flex justify-between text-gray-400">
              <span>Subtotal</span>
              <span class="text-white font-medium" id='subtotal'>0 Ks</span>
            </div>
            <div class="flex justify-between text-gray-400">
              <span>Tax (0%)</span>
              <span class="text-white font-medium">0 Ks</span>
            </div>
            <div class="flex justify-between text-gray-400">
              <span>Discount</span>
              <span class="text-white font-medium" id="discount-value">0 Ks</span>
            </div>
            <hr class="border-[#2d2d2d] my-2">
            <div class="flex justify-between text-base font-bold">
              <span>Total Amount</span>
              <span class="text-[#00d26a]" id='total'>0 Ks</span>
            </div>
          </div>
        </div>

        <!-- Payment Actions Pushed to Bottom -->
        
        <div class="space-y-4 pt-6 mt-auto border-t border-[#2d2d2d]">
          <form autocomplete="off">
          <div>
            <label class="text-xs text-gray-400 block mb-1">Discount</label>
            <input type="number" value="0" id='discount' class="w-full bg-[#141414] border border-[#333] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-[#00d26a]">
          </div>

          <div>
            <label class="text-xs text-gray-400 block mb-1">Cash Received</label>
            <input type="number" id='paid_amount' class="w-full bg-[#141414] border border-[#333] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-[#00d26a]" @required(true)>
          </div>
          </form>

          <div class="flex justify-between items-center p-3 bg-[#141414] rounded-lg border border-[#2b2b2b]">
            <span class="text-xs text-gray-400">Change Due</span>
            <span class="text-sm font-bold text-white" id='changes'>0 Ks</span>
          </div>
          
          <button id='pay_print' class="w-full bg-[#00d26a] hover:bg-[#00b85c] text-black font-bold py-3 rounded-lg transition-colors text-sm">
            Complete Payment & Print Receipt
          </button>
        </div>
        
      </section>

    </div>
  </main>

</x-layouts::app>
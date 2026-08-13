<x-layouts::app>
    
    <main class="flex-1 p-0 sm:p-6 md:p-10 space-y-4 sm:space-y-6 overflow-y-auto flex flex-col items-center">
        
        <!-- Top Action Bar (Padded on mobile so buttons don't touch screen edge) -->
        <div class="w-full max-w-6xl px-4 pt-4 sm:px-0 sm:pt-0 flex justify-between items-center print:hidden">
            <a href="/transactions" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Transaction History
            </a>

        </div>

        <!-- Full-Width Mobile Receipt Card Container -->
        <div class="w-full max-w-6xl dark:bg-neutral-900 border border-[#2a2a2a] rounded-xl sm:rounded-2xl p-4 sm:p-8 shadow-2xl space-y-6 print:border-none print:shadow-none print:bg-white print:text-black">
            
            <!-- Store Header -->
            <div class="text-center border-b border-[#2a2a2a] pb-5 sm:pb-6 print:border-zinc-300">
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight print:text-black">Point Of Sale</h1>
                <p class="text-xs sm:text-sm text-zinc-400 mt-1 print:text-zinc-600">Order #TRX-{{$transaction->id}}</p>
                <p class="text-xs text-zinc-500 mt-0.5 print:text-zinc-600" id="local-time" data-utc="{{ $transaction->created_at }}">{{$transaction->created_at}}</p>
            </div>

            <!-- Tabular Product List -->
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="text-zinc-400 font-semibold border-b border-[#2a2a2a] print:border-zinc-300 print:text-black">
                            <th scope="col" class="py-2.5 px-2 sm:px-4">Description</th>
                            <th scope="col" class="py-2.5 px-2 sm:px-4 text-center">Qty</th>
                            <th scope="col" class="py-2.5 px-2 sm:px-4 text-right whitespace-nowrap">Unit price</th>
                            <th scope="col" class="py-2.5 px-2 sm:px-4 text-right whitespace-nowrap">Total price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-transparent">
                       
                        @foreach ($items as $item)

                        {{--  $loop->even "true" if index of foreach loop is even --}}
                        <tr class="{{ $loop->even ? 'bg-transparent' : 'bg-[#222222] print:bg-zinc-100' }}"> 
                            <td class="py-3 px-2 sm:px-4 font-medium text-white print:text-black">{{$item->product_name}}</td>
                            <td class="py-3 px-2 sm:px-4 text-center text-zinc-300 print:text-black">{{$item->product_quantity}}</td>
                            <td class="py-3 px-2 sm:px-4 text-right text-zinc-300 print:text-black whitespace-nowrap">{{ $item->product_price }}</td>
                            <td class="py-3 px-2 sm:px-4 text-right font-medium text-white print:text-black whitespace-nowrap">{{ $item->subtotal }} Ks</td>
                        </tr>
                        
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary & Payment Breakdown -->
            <div class="pt-2 border-t border-[#2a2a2a] print:border-zinc-300 space-y-4">
                
                <!-- Subtotal / Taxes -->
                <div class="space-y-2 text-xs sm:text-sm text-zinc-400 print:text-zinc-700 px-1 sm:px-0">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="text-zinc-200 font-medium print:text-black">{{ $transaction->Total_Amount }} Ks</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax (0%)</span>
                        <span class="text-zinc-200 font-medium print:text-black">0 Ks</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span class="text-zinc-200 font-medium print:text-black">{{ $transaction->Discount }} Ks</span>
                    </div>
                </div>

                <!-- Totals & Payment Breakdown -->
                <div class="border-t border-[#2a2a2a] pt-4 print:border-zinc-300 space-y-3 text-xs sm:text-sm px-1 sm:px-0">
                    <div class="flex justify-between items-center text-base sm:text-lg font-bold">
                        <span class="text-white print:text-black">Total Amount</span>
                        <span class="text-[#00e676] text-lg sm:text-xl print:text-black">{{ $transaction->Total_Amount - $transaction->Discount }} Ks</span>
                    </div>

                    <div class="flex justify-between items-center text-zinc-400 print:text-zinc-700">
                        <span>Paid Amount (Cash)</span>
                        <span class="font-medium text-zinc-200 print:text-black">{{ $transaction->Paid_Amount }} Ks</span>
                    </div>

                    <div class="flex justify-between items-center text-zinc-400 print:text-zinc-700">
                        <span>Change Due</span>
                        <span class="font-medium text-lg text-yellow-300 print:text-black">{{ $transaction->Paid_Amount - $transaction->Total_Amount + $transaction->Discount }} Ks</span>
                    </div>
                </div>

            </div>

            <!-- Receipt Footer -->
            <div class="text-center pt-3 pb-2 space-y-1">
                <p class="text-xs sm:text-sm text-zinc-400 font-medium print:text-zinc-700">Thank you for your purchase!</p>
                <p class="text-[11px] text-zinc-500">Please keep this receipt for returns or exchanges.</p>
            </div>

        </div>

    </main>

    <script>
        function convertUTCToLocal() {
            // Find all elements using the class name
            const utc_elements = document.querySelectorAll('#local-time');
            
            utc_elements.forEach(element => {
                // Read from the untouched data-utc attribute
                const time = element.getAttribute('data-utc');
                
                if (!time) return; 

                const year = time.slice(0, 4);
                const month = time.slice(5, 7) - 1; 
                const day = time.slice(8, 10);
                const hours = time.slice(11, 13);
                const minutes = time.slice(14, 16);
                const seconds = time.slice(17, 19);

                const date = new Date(Date.UTC(year, month, day, hours, minutes, seconds));
                
                // 1. Get the date part (YYYY-MM-DD)
                const datePart = time.slice(0, 10); 
                
                // 2. Format the time to 12-hour format (e.g., "07:16:00 PM")
                const timePart = date.toLocaleTimeString('en-US', {
                    hour12: true,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            
                // Update the display text safely
                element.innerText = datePart + ' ' + timePart;
            });
        }

        // Run on normal first page load
        document.addEventListener('DOMContentLoaded', convertUTCToLocal);

        // Run every time Livewire finishes navigating tabs
        document.addEventListener('livewire:navigated', convertUTCToLocal);
    </script>


</x-layouts::app>
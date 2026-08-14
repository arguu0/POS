<x-layouts::app :title="__('Transactions')">
  <main class="flex-1 p-3 sm:p-6 md:p-8 space-y-6 overflow-y-auto relative">
        
      <!-- Header Section -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
              <h1 class="text-xl sm:text-2xl font-semibold tracking-tight text-white">Transaction History</h1>
              <p class="text-xs text-zinc-400 mt-0.5">Manage and view all processed order records</p>
          </div>

          <div class="flex items-center gap-2.5">
              <div class="relative w-full sm:w-auto" x-data="{ open: false }">
                  <button @click="open = !open" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-900 bg-[#00e676] hover:bg-[#00c853] transition-colors rounded-lg shadow-sm">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                      </svg>
                      <span>Filter by Date</span>
                  </button>

                  <!-- Filter Form Dropdown -->
                  <div x-show="open" x-cloak class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-full sm:w-72 bg-[#1a1a1a] border border-[#2a2a2a] rounded-xl shadow-2xl z-50 p-4 text-xs">
                      <form method="GET" action="{{ route('transactions') }}" @submit.prevent="$el.submit()" class="space-y-3">
                          <div>
                              <label class="block text-zinc-400 mb-1 font-medium">From Date</label>
                              <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-[#242424] border border-[#3a3a3a] text-white rounded-lg px-3 py-1.5 focus:outline-none focus:border-[#00e676] scheme-dark">
                          </div>
                          <div>
                              <label class="block text-zinc-400 mb-1 font-medium">To Date</label>
                              <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-[#242424] border border-[#3a3a3a] text-white rounded-lg px-3 py-1.5 focus:outline-none focus:border-[#00e676] scheme-dark">
                          </div>
                          <div class="flex items-center justify-between pt-2 border-t border-[#2a2a2a]">
                              <a href="{{ route('transactions') }}" class="text-zinc-400 hover:text-white transition-colors">Reset</a>
                              <button type="submit" class="px-3 py-1.5 bg-[#00e676] text-zinc-900 font-semibold rounded-lg hover:bg-[#00c853]">Apply Filter</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

    <!-- Main Card Wrapper -->
    <div class="bg-[#1a1a1a] border border-[#2a2a2a] rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden">
          
        <!-- MOBILE VIEW (Cards) -->
        <div class="block sm:hidden divide-y divide-[#2a2a2a]">
            @foreach ($transactions as $transaction)
            <div class="p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-[13px] font-medium text-white">
                        <a href="/transaction/{{$transaction->id}}">ID: {{$transaction->id}}</a>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#00e676]/10 text-[#00e676] border border-[#00e676]/20">
                        Completed
                    </span>
                </div>
                
                <div class="flex items-center justify-between text-xs">
                    <span class="text-zinc-400 local-time" data-utc="{{$transaction->created_at}}">{{$transaction->created_at}}</span>
                    <span class="font-semibold text-[#00e676] text-[13px]">{{ $transaction->Total_Amount }} Ks</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- DESKTOP TABLE VIEW -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead class="bg-[#141414] text-zinc-400 uppercase tracking-wider text-[13px] border-b border-[#2a2a2a]">
                    <tr>
                        <th scope="col" class="py-3.5 px-3 sm:px-4 font-semibold">Transaction ID</th>
                        <th scope="col" class="py-3.5 px-3 sm:px-4 font-semibold">Date / Time</th>
                        <th scope="col" class="py-3.5 px-3 sm:px-4 font-semibold">Total Price</th>
                        <th scope="col" class="py-3.5 px-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2a2a2a]">
                    @foreach ($transactions as $transaction)
                    <tr class="hover:bg-[#222222] transition-colors">
                        <td class="py-3.5 sm:py-4 px-3 sm:px-4 font-medium text-white">
                            <div class="flex items-center gap-1.5 text-[14px]">
                                <span><a href="/transaction/{{$transaction->id}}">ID: {{$transaction->id}}</a></span>
                            </div>
                        </td>
                        <td class="py-3.5 sm:py-4 px-3 sm:px-4 text-zinc-300 text-[14px] local-time" data-utc="{{$transaction->created_at}}">{{$transaction->created_at}}</td>
                        <td class="py-3.5 sm:py-4 px-3 sm:px-4 font-semibold text-[#00e676] text-[14px]">{{ $transaction->Total_Amount }} Ks</td>
                        <td class="py-3.5 sm:py-4 px-3 sm:px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[14px] font-medium bg-[#00e676]/10 text-[#00e676] border border-[#00e676]/20">
                                Completed
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div class="bg-[#141414] px-4 py-3 border-t border-[#2a2a2a] flex items-center justify-end">
            {{ $transactions->withQueryString()->links('pagination::tailwind') }}
        </div>

    </div>

  </main>

    <script>
        function convertUTCToLocal() {
            const utc_elements = document.querySelectorAll('.local-time');
            
            utc_elements.forEach(element => {
                const time = element.getAttribute('data-utc');
                if (!time) return; 

                const year = time.slice(0, 4);
                const month = time.slice(5, 7) - 1; 
                const day = time.slice(8, 10);
                const hours = time.slice(11, 13);
                const minutes = time.slice(14, 16);
                const seconds = time.slice(17, 19);

                const date = new Date(Date.UTC(year, month, day, hours, minutes, seconds));
                const datePart = time.slice(0, 10); 
                
                const timePart = date.toLocaleTimeString('en-US', {
                    hour12: true,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            
                element.innerText = datePart + ' ' + timePart;
            });
        }

        document.addEventListener('DOMContentLoaded', convertUTCToLocal);
        document.addEventListener('livewire:navigated', convertUTCToLocal);
    </script>
</x-layouts::app>
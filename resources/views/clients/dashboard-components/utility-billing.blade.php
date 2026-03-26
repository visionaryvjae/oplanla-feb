<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pr-5 mb-10">
    @php
        $room = Auth::guard('web')->user()->room;
        $billing = Auth::guard('web')->user()->room->charges()->latest()->first() ?? null;
        $meters = Auth::guard('web')->user()->room->meters()->latest()->get() ?? null;
        $waterMeter = Auth::guard('web')->user()->room->meters()->where('type', 'water')->first() ?? null;
        $electricityMeter = Auth::guard('web')->user()->room->meters()->where('type', 'electricity')->first() ?? null;

        // dd($billings, $waterMeter->secondLastReading()->consumption, $electricityMeter);
    @endphp
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 flex flex-col">
        <div class="p-8 flex-grow">
            <div class="flex md:flex-row flex-col justify-between items-start mb-6">
                <h2 class="text-2xl font-semibold text-gray-800" style="font-size:1.5rem; font-weight:600;">Utility Consumption</h2>
                <a href="{{ route('tenant.report.download') }}" class="text-sm font-medium hover:underline" style="color:#ad68e4; text-align:right;">Download Statement (PDF)</a>
            </div>

            <div class="space-y-6 mt-4">
                @foreach ($meters as $meter)
                    <div class="flex items-center space-x-4">
                        @if ($meter->type == 'electricity')
                            <div class="p-2 bg-yellow-100" style="border-radius:1rem;">
                                <img src="https://img.icons8.com/?size=100&id=9094&format=png&color=000000" style="height:2rem; width:2rem;" alt="">
                            </div>
                        @else
                            <div class="p-2 bg-blue-100" style="border-radius:1rem;">
                                <img src="https://img.icons8.com/?size=100&id=y6VUkcahDbXV&format=png&color=000000" style="height: 2rem; width:2rem;" alt="">
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ ucfirst($meter->type) }} Usage</p>
                            <p class="text-xl font-bold text-gray-900">{{ $meter->lastReading->consumption ?? 0 }} units used</p>
                        </div>
                    </div>
                @endforeach

                <div class="flex items-center space-x-4">

                    @if ($waterMeter?->lastReading?->consumption >= $waterMeter?->secondLastReading()->consumption)
                        <div class="p-3 bg-red-50 rounded-xl">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Consumption Trend</p>
                            <p class="text-lg font-semibold text-gray-700">
                                Water usage <span class="text-red-600 font-bold">increased by {{ $waterMeter?->lastReading?->consumption - $waterMeter?->secondLastReading()->consumption ?? 0 }} KL</span> from last month
                            </p>
                        </div>
                    @else
                        <div class="p-3 bg-green-50 rounded-xl">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Consumption Trend</p>
                            <p class="text-lg font-semibold text-gray-700">
                                Water usage <span class="text-green-600 font-bold">decreased by {{ $waterMeter->secondLastReading()->consumption - $waterMeter->lastReading->consumption }} KL</span> from last month
                            </p>
                        </div> 
                    @endif
                    
                    
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('tenant.utilities.index') }}" class="block w-full text-center py-3 text-white font-bold rounded-md shadow-sm transition-opacity hover:opacity-90" style="background-color: #ad68e4;">
                View Detailed Historical Usage
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 flex flex-col">
        <div class="p-8 flex-grow">
            <div class="flex flex-col md:flex-row items-center md:justify-between">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-size:1.5rem; font-weight:600;">Billing Overview</h2>
                <a href="{{ route('tenant.reports.statement.download') }}" 
                class="text-purple-600 font-semibold text-sm hover:underline" 
                style="color: #ad68e4;">
                Download My Statement (PDF)
                </a>
            </div>
            <div class="mt-4 p-6 rounded-2xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Current Status</p>
                
                @php 
                    $isPaid = true; 
                @endphp 
                
                @if($room->totalCharges() == 0)
                    <div class="flex items-center text-green-600">
                        <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-2xl font-black italic">All bills up to date.</span>
                    </div>
                @else
                    <div class="flex flex-col items-center text-red-600">
                        <span class="text-xs font-medium mb-1 uppercase">Payment Overdue</span>
                        <span class="text-3xl font-black">Currently owing ZAR {{ number_format($room->totalCharges() ?? 0, 2) }}</span>
                    </div>
                @endif
            </div>
            
            <p class="text-sm text-gray-500 mt-6 italic text-center">Your next automated invoice will be generated on the 1st of next month.</p>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('tenant.billings.index') }}" class="block w-full text-center py-3 font-bold rounded-md border border-[#ad68e4] transition-colors hover:bg-purple-50" style="color: #ad68e4;">
                View Billing & Payment History
            </a>
        </div>
    </div>

</div>
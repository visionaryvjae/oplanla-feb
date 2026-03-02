@extends('layouts.providers')

@section('content')
    @php
        //dd($results);
    @endphp
    <div class="bg-white md:w-auto w-full rounded-2xl shadow-xl border border-gray-100">
        <div class="p-6 bg-[#68e4ad]/10 border-b border-[#68e4ad]/20 flex  md:flex-row flex-col justify-between items-center">
            <div class="flex gap-4">
                <div class="bg-white px-4 py-2 rounded-lg border border-[#68e4ad]/30">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Meters Matched</p>
                    <p class="text-xl font-black text-gray-800">42 <span class="text-xs text-gray-400">/ {{ count($results) }}</span></p>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg border border-[#ad68e4]/30">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Total Revenue</p>
                    <p class="text-xl font-black text-[#ad68e4]">R {{ number_format(array_sum(array_column($results, 'cost')), 2) }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <p class="text-sm font-medium text-gray-600 ml-2">Review complete? Dispatch to tenants:</p>
                <button class="bg-[#ad68e4] text-white px-6 py-3 rounded-xl font-black shadow-lg hover:shadow-purple-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Generate & Send Invoices
                </button>
            </div>
        </div>

        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs font-bold text-gray-400 uppercase tracking-widest">
                <tr>
                    <th class="px-6 py-4">Room #</th>
                    <th class="px-6 py-4">Meter Serial</th>
                    <th class="px-6 py-4 text-right">Consumption</th>
                    <th class="px-6 py-4 text-right">Estimated Total</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($results as $item)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $item['room_number'] }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-gray-500">{{ $item['serial'] }}</td>
                        <td class="px-6 py-4 text-right font-medium">{{ $item['consumption'] }} kWh</td>
                        <td class="px-6 py-4 text-right font-black text-[#ad68e4]">R {{ number_format($item['cost'], 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-[#68e4ad]/20 text-[#2d7a58] px-3 py-1 rounded-full text-[10px] font-black uppercase">Calculated</span>
                        </td>
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
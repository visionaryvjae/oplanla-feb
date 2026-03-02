@extends('layouts.tenant')

@section('content')
    <div class="summary-box">
        <h3>Summary of Last Month</h3>
        {{-- <p>Current Outstanding Balance: <strong>ZAR {{ number_format($user->reading->totalCharges() ?? 0, 2) }}</strong></p>  --}}
        <p>Water Usage: <strong>{{ $user->reading->waterMeter->lastReading->consumption ?? 0 }} KL</strong></p>
        <p>Electricity Usage: <strong>{{ $user->reading->electricityMeter->lastReading->consumption ?? 0 }} kWh</strong></p>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meter</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage (KL/kWh)</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($readings as $i => $reading)

                                @php
                                    // Find the charge created at the exact same time for this room
                                    $specificCharge = $reading->charge;
                                    
                                    if($i < $readings->count()-2){
                                        // dd($readings->get($i-1));
                                        $consumption = number_format($reading->consumption, 2) ?? $reading->reading_value - $readings->get($i + 2)->reading_value ?? 0;; // Calculate consumption based on current and previous reading
                                    }
                                @endphp
                                
                                <tr class="hover:bg-gray-50 cursor-pointer" data-reading-id="{{ $reading->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $reading->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reading->meter->serial_number ?? 'MTR-reading-02' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($reading->consumption ?? $consumption, 2) }}</td>
                                    <td style="color: {{ $specificCharge ? ($specificCharge->is_paid == 0 ? 'red' : 'black') : '#333' }};">
                                        ZAR {{ number_format($specificCharge->amount ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                        You haven't added any readings yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    {{-- Card layout for mobile screens --}}
                    {{-- <div class="grid grid-cols-1 gap-4 px-4 py-4 md:hidden">
                        @forelse ($readings as $reading)
                            <div class="bg-white p-4 rounded-lg border shadow-sm space-y-3 cursor-pointer" data-reading-id="{{ $reading->id }}">
                                <div class="items-center flex justify-between mb-2">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $reading->property->name ?? $reading->provider->provider_name }}</p>
                                        <!--<p class="text-xs text-gray-500">reading {{ $reading->reading_number }} (ID: #{{$reading->id}})</p>-->
                                    </div>
                                    <div>
                                            @if ($reading->available)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Not Available</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="flex flex-col w-full items-start justify-start">
                                        <div>
                                            <p class="text-xs text-left text-gray-500">reading Type</p>
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $reading->reading_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-left text-gray-500">Price</p>
                                            <p class="text-sm font-medium text-gray-800">R {{ number_format($reading->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Facilities</p>
                                    <p class="text-sm text-gray-800 truncate">{{ $reading->reading_facilities ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="py-4 px-6 text-center text-gray-500">
                                You haven't added any readings yet.
                            </div>
                        @endforelse
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Meter Serial</th>
                <th>Usage (KL/kWh)</th>
                <th>Cost (ZAR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($readings as $i => $reading)
            
            @php
                // Find the charge created at the exact same time for this reading
                $specificCharge = $reading->charge;
                
                if($i < $readings->count()-2){
                    // dd($readings->get($i-1));
                    $consumption = number_format($reading->consumption, 2) ?? $reading->reading_value - $readings->get($i + 2)->reading_value ?? 0;; // Calculate consumption based on current and previous reading
                }
            @endphp
            <tr>
                <td>{{ $reading->created_at->format('d M Y') }}</td>
                <td>{{ $reading->meter->serial_number ?? 'MTR-reading-02' }}</td>
                <td>{{ number_format($reading->consumption ?? $consumption, 2) }}</td>
                <td style="color: {{ $specificCharge ? ($specificCharge->is_paid == 0 ? 'red' : 'black') : '#333' }};">
                    ZAR {{ number_format($specificCharge->amount ?? 0, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
@endsection
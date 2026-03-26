{{-- Desktop Table (hidden on mobile) --}}
<div class="hidden md:block overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($items as $item)
                <tr class="hover:bg-gray-50 cursor-pointer">
                    @foreach($rows as $rowCallback)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {!! $rowCallback($item) !!}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="px-6 py-4 text-center text-gray-500">
                        No records found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile Cards (visible only on mobile) --}}
<div class="md:hidden space-y-4">
    @forelse($items as $item)
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
            {{-- Card Header with ID and Status --}}
            <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    @if($showId ?? true)
                        <span class="text-gray-500 text-sm">#{{ $item->id }}</span>
                    @endif
                    @if(isset($mobileConfig['statusIndex']) && isset($rows[$mobileConfig['statusIndex']]))
                        {!! $rows[$mobileConfig['statusIndex']]($item) !!}
                    @endif
                </div>
                
                {{-- Primary Value (e.g., Amount) --}}
                @if(isset($mobileConfig['primaryIndex']) && isset($rows[$mobileConfig['primaryIndex']]))
                    <span class="text-lg font-bold text-gray-900">
                        {!! $rows[$mobileConfig['primaryIndex']]($item) !!}
                    </span>
                @endif
            </div>

            {{-- Dynamic Field Rows --}}
            <div class="space-y-2 mb-3">
                @foreach($rows as $index => $rowCallback)
                    @if(!in_array($index, $mobileConfig['excludeIndices'] ?? []))
                        @if($index !== ($mobileConfig['primaryIndex'] ?? -1) && $index !== ($mobileConfig['statusIndex'] ?? -1))
                            <div class="flex justify-between items-center py-1">
                                <span class="text-sm text-gray-600 font-medium">
                                    {{ $headers[$index] ?? 'Field' }}:
                                </span>
                                <span class="text-sm text-gray-900">
                                    {!! $rowCallback($item) !!}
                                </span>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            {{-- Action Button --}}
            @if(isset($mobileConfig['actionIndex']) && isset($rows[$mobileConfig['actionIndex']]))
                <div class="mt-3 pt-3 border-t border-gray-100">
                    {!! $rows[$mobileConfig['actionIndex']]($item) !!}
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-lg shadow border border-gray-200 p-8 text-center text-gray-500">
            No records found
        </div>
    @endforelse
</div>



<div>
    @if ($item->status == 'pending' || $item->status == 'unpaid')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $item->status }}</span>
    @elseif($item->status == 'completed' || $item->status == 'paid')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $item->status }}</span>
    @elseif($item->status == 'canceled' || $item->status == 'cancelled' || $item->status == 'rejected')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $item->status }}</span>
    @else
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $item->status }}</span>
    @endif
</div>
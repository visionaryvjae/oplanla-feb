


<div>
    @if ($item->status == 'pending')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} tracking-widest leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
    @elseif($item->status == 'completed')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} tracking-widest leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
    @elseif($item->status == 'canceled' || $item->status == 'cancelled')
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} tracking-widest leading-5 font-semibold rounded-full bg-red-100 text-red-800">Completed</span>
    @else
        <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} {{ $uppercase ?? 'uppercase' }} tracking-widest leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
    @endif
</div>
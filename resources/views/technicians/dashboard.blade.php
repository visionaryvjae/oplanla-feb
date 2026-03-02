@extends('layouts.technician')

@section('content')
    <div class="max-w-7xl bg-white rounded-2xl px-6 py-4 border-gray-100 overflow-hidden">
        {{-- grid layout --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- priority schedule --}}
            <div class="flex flex-col w-full rounded-xl border overflow-hidden">
                <div class="w-full bg-gradient-to-br from-[#ad68e4] to-[#8a44c4] px-4 py-4 border-b flex justify-between items-center">
                    <h3 class="font-black text-gray-900 uppercase tracking-tighter">Priority Schedule ({{ $upcoming->count() }})</h3>
                    <a href="{{ route('technician.tickets.index') }}" class="text-xs font-bold text-white hover:underline">View All Tickets</a>
                </div>

                @php
                    // dd($upcoming->first());
                    $ticket = $upcoming->first();
                @endphp
                <div class="px-6 py-2 divide-y divide-gray-50 overflow-hidden" id="carousel-container-conference">
                    <div class="px-4 py-2 flex flex-col items-center justify-between border rounded-lg">
                        <div class="flex w-full justify-end mb-2">
                            @include('components.status-toast', ['item' => $ticket, 'txtSize' => 'text-sm   '])
                        </div>
                        <div class="flex gap-4">
                            <div class="text-center bg-red-50 rounded-lg px-3 py-2 border border-red-100">
                                <span class="block text-[10px] font-black text-red-400 uppercase">Deadline</span>
                                <span class="block text-xl font-black text-red-600">{{ $ticket->latest_completion_date->format('d M') }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $ticket->job->title }}</p>
                                <p class="text-xs text-gray-400">Earliest Start: {{ $ticket->earliest_start_date->format('d M') }}</p>
                                <p class="text-xs text-gray-400">Room number: {{ $ticket->job->room->room_number }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 items-end mt-2 w-full justify-end">
                            <div class="flex space-x-4">
                                <a href="{{ route('technician.tickets.show', $ticket->id) }}" class="text-[#68ade4] hover:underline hover:text-[#345672]">view Ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-full rounded-xl border overflow-hidden">
                <div class="w-full bg-gradient-to-br from-[#23cab5] to-[#1aa898] px-4 py-4 border-b flex justify-between items-center">
                    <h3 class="font-black text-gray-900 uppercase tracking-tighter">Completed Jobs</h3>
                </div>
                <div class="px-6 py-4 divide-y divide-gray-50">
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        const carouselContainerConference = document.getElementById('carousel-container-conference');
        const prevBtnConference = document.getElementById('prevBtnConference');
        const nextBtnConference = document.getElementById('nextBtnConference');

        // The width of one carousel item including its margin-right (w-64 + space-x-6 -> 16rem + 1.5rem = 17.5rem).
        // A more robust way is to get it dynamically.
        const itemWidthConference = carouselContainer.children[0] ? carouselContainer.children[0].offsetWidth + 24 : 280; // 256px + 24px

        nextBtnConference.addEventListener('click', () => {
            carouselContainerConference.scrollBy({ left: itemWidthConference, behavior: 'smooth' });
        });

        prevBtnConference.addEventListener('click', () => {
            carouselContainerConference.scrollBy({ left: -itemWidthConference, behavior: 'smooth' });
        });

        // Optional: Hide/show buttons based on scroll position
        function updateButtonStateConference() {
            const maxScrollLeftConference = carouselContainerConference.scrollWidth - carouselContainerConference.clientWidth;
            prevBtnConference.style.display = carouselContainerConference.scrollLeft <= 0 ? 'none' : 'block';
            nextBtnConference.style.display = carouselContainerConference.scrollLeft >= maxScrollLeftConference -1 ? 'none' : 'block'; // -1 for precision issues
        }

        carouselContainerConference.addEventListener('scroll', updateButtonStateConference);
        window.addEventListener('resize', updateButtonStateConference); // Update on resize
        updateButtonStateConference(); // Initial check
    </script>
@endsection
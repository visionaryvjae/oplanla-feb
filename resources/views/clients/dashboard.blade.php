@extends('layouts.tenant')

@section('content')
<div class="container w-[90%] mx-auto px-6 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Sanibonani, {{ explode(' ', Auth::guard('web')->user()->name)[0] }}!</h1>
            <p class="text-gray-500">Here is what’s happening with your unit today.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('tenant.maintenance.create') }}" class="px-5 py-2.5 bg-gray-900 text-white font-semibold text-sm transition hover:bg-gray-800" style="border-radius: 12px;">
                Report Issue
            </a>
            <a href="{{ route('tenant.billings.index') }}" class="px-5 py-2.5 text-white font-semibold text-sm transition hover:opacity-90" style="background-color: #ad68e4; border-radius: 12px;">
                Pay Rent
            </a>
        </div>
    </div>

    @php
        $years = floor($daysRemaining / 365);
        $months = floor(($daysRemaining % 365) / 30);
        $days = $daysRemaining % 30;
        
        $parts = [];
        if ($years > 0) $parts[] = $years . 'y';
        if ($months > 0) $parts[] = $months . 'm';
        if ($days > 0) $parts[] = $days . 'd';
        
        $formattedTime = empty($parts) ? '0d' : implode(' ', $parts);
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 border border-gray-100 shadow-sm" style="border-radius: 20px;">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Stay Duration</p>
            <h3 class="text-2xl font-black text-gray-800">@formatDays($daysStayed)</h3>
            <p class="text-xs text-green-500 font-medium mt-2">Active since {{ Auth::guard('web')->user()->created_at->format('d M Y') }}</p>
        </div>

        <div class="bg-white p-6 border border-gray-100 shadow-sm" style="border-radius: 20px;">
            <div class="flex justify-between items-start">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Contract Status</p>
                <span class="text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-0.5 rounded">{{ $stayLength }} Months</span>
            </div>
            <h3 class="text-2xl font-black text-gray-800">
                {{-- {{ $daysRemaining > 0 ? @formatDays($daysRemaining) . ' Days Left' : 'Term Complete' }} --}}
                @if ($daysRemaining > 0)
                    @formatDays($daysRemaining) left
                @else
                    {{'Term Complete'}} 
                @endif
            </h3>
            
            <div class="w-full bg-gray-100 h-1.5 mt-3 rounded-full overflow-hidden">
                <div class="h-full transition-all duration-500" 
                    style="background-color: #ad68e4; width: {{ $leaseProgress }}%"></div>
            </div>
            <p class="text-[10px] text-gray-400 mt-2 uppercase font-bold tracking-tighter">
                Projected End: {{ $expectedEndDate->format('d M Y') }}
            </p>
        </div>

        <div class="bg-white p-6 border border-gray-100 shadow-sm" style="border-radius: 20px;">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Power Usage</p>
                <a href="{{ route('tenant.report.download') }}" class="text-sm font-medium hover:underline" style="color:#68ade4; text-align:right;">
                    <img width="30" height="30" src="https://img.icons8.com/sf-black-filled/64/ad68e4/download.png" alt="download"/>
                </a>
            </div>
            <h3 class="text-2xl font-black text-gray-800">{{ number_format($powerUsage, 1) }} <span class="text-sm font-normal text-gray-400">kWh</span></h3>
            <p class="text-xs text-gray-500 mt-2">Current billing cycle</p>
        </div>

        <div class="p-6 shadow-sm border border-purple-100" style="border-radius: 20px; background-color: #fdfaff;">
            <p class="text-xs font-bold text-purple-400 uppercase tracking-wider mb-1">Current Balance</p>
            <h3 class="text-2xl font-black" style="color: #ad68e4;">R {{ number_format($balance, 2) }}</h3>
            <p class="text-xs font-medium mt-2 {{ $balance > 0 ? 'text-red-500' : 'text-green-500' }}">
                {{ $balance > 0 ? 'Payment Overdue' : 'Account Settled' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white border border-gray-100 overflow-hidden" style="border-radius: 20px;">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h4 class="font-bold text-gray-800">Recent Maintenance</h4>
                <div class="space-x-2">
                    <a href="{{ route('tenant.maintenance.index') }}" class="text-xs font-bold text-purple-500 uppercase hover:underline">View All</a>
                </div>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentJobs as $job)
                    <div class="p-5 flex items-center justify-between hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                @if ($job->photo_url)
                                    <img src="{{ $job->photo_url ? asset('storage/maintenance/' . $job->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$job->category }}" alt="Issue Image" class="h-12 w-12 rounded-xl object-cover">    
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $job->title }}</p>
                                <p class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full" 
                              style="background-color: {{ $job->status == 'completed' ? '#ecfdf5' : '#fff7ed' }}; color: {{ $job->status == 'completed' ? '#059669' : '#d97706' }};">
                            {{ $job->status }}
                        </span>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-400 text-sm italic">No active maintenance requests.</div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 border border-gray-100 shadow-sm" style="border-radius: 20px;">
                <div class="flex items-center gap-3 mb-2">
                    <span class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <p class="text-sm font-bold text-gray-800">Stay Milestone</p>
                </div>
                <p class="text-xs text-gray-500">
                    You've completed <strong>{{ $leaseProgress }}%</strong> of your original {{ $stayLength }}-month stay. 
                    {{ $leaseProgress >= 80 ? 'Thinking of renewing? Contact your manager.' : 'We hope you are enjoying OPLANLA!' }}
                </p>
            </div>

            {{-- <div class="bg-white p-6 border border-gray-100 shadow-sm" style="border-radius: 20px;">
                <div class="flex items-center gap-3 mb-2">
                    <span class="p-2 bg-blue-50 text-blue-500 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                    </span>
                    <p class="text-sm font-bold text-gray-800">Refuse Collection</p>
                </div>
                <p class="text-xs text-gray-500">Every **Tuesday** morning. Please ensure bins are on the curb by 07:00.</p>
            </div> --}}

            <div class="bg-gray-900 p-8 text-white" style="border-radius: 20px;">
                <h4 class="text-lg font-bold mb-4">Support Contact</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/></svg>
                        </div>
                        <p class="text-sm opacity-80">{{ $user->room->property->owner->email ?? 'support@oplanla.com' }}</p>
                    </div>
                    <button class="w-full py-3 bg-white text-gray-900 font-bold text-xs uppercase tracking-widest mt-4 hover:bg-gray-100 transition" style="border-radius: 12px;">
                        Message Manager
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
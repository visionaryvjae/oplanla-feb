@extends('layouts.providers')

@section('content')
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8 my-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">{{ $action }} Ticket</h1>
                <p class="mt-1 text-sm text-gray-600">Please fill out the details below.</p>
            </div>

            <form method="POST" action="{{ $actionUrl }}" id="main_form" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                        <div class="col-span-2">
                            <label for="maintenance_user_id" class="block text-sm font-medium text-gray-700">Select Technician</label>
                            <select name="maintenance_user_id" id="maintenance_user_id" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">-- Select user --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('maintenance_user_id', $ticket->maintenance_user_id) == $user->id)>{{ $user->name }} (specialty: {{ $user->specialty }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Tenant Time Estimate</label>
                            <input type="text" name="tenant_estimate" placeholder="e.g. 2 weeks" 
                                class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="text-[10px] text-gray-400 mt-2 italic">This is the time frame shown to the tenant on their dashboard.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Earliest Start Date</label>
                            <input type="date" name="earliest_start_date" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline Date</label>
                            <input type="date" name="latest_completion_date" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                    </div>

                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <button type="submit" id="submit-button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $action }} Ticket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
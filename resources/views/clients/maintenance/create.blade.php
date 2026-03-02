@extends('layouts.tenant')

@section('content')
    <div class="w-[70%] justify-start px-4 sm:px-6 lg:px-8">
        <a href="{{ route('tenant.maintenance.index') }}" class="text-sm font-medium text-gray-600 hover:text-black">
            &larr; Back to my requests
        </a>
    </div>
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Report an Issue</h1>
            <p class="text-gray-500 mt-2">Let us know what’s wrong, and we’ll get it fixed for you.</p>
        </div>

        <div class="bg-white shadow-xl rounded-lg shadow-purple-100/50 border border-gray-100 overflow-hidden">
            

            <form action="{{ route('tenant.maintenance.store') }}" method="POST" class="flex flex-col p-8 space-y-6" enctype="multipart/form-data"
                
            >
                @csrf
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap:1rem;">
                    
                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Issue Category</label>
                        <select name="category" id="category" required 
                            class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all py-3">
                            <option value="" disabled selected>Select what needs fixing...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Issue Title</label>
                        <input type="text" name="title" id="title" required 
                            class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all py-3">
                    </div>
                </div>

                <div class="col-span-2" style="column-span: 2;">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" 
                        placeholder="Tell us a bit more about the problem..."
                        class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all py-3"></textarea>
                    <p class="mt-2 text-xs text-gray-400 italic">Example: "The kitchen sink has a slow drip since this morning."</p>
                </div>

                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Upload an Image (Optional)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all py-3">
                </div>

                <div class="flex flex-col space-y-2">
                    <div class="w-full">
                        <button type="submit" 
                            style="background-color:rgb(45 212 191);"
                            class="w-full bg-teal-400 hover:bg-teal-700 text-white font-bold py-4 border rounded-2xl transition-all transform active:scale-95">
                            Submit Maintenance Request
                        </button>
                    </div>
                    <div class="w-full">
                        <button type="button" onclick="window.location.href='{{ route('dashboard') }}'" 
                            class="w-full bg-white hover:bg-gray-500 text-gray-700 font-bold py-4 border rounded-2xl transition-all transform active:scale-95">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
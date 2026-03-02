<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Step 4: Business Documents upload if applicable</h2>
    <p class="text-gray-600 mb-6">Please provide your business documents</p>

    @php
        // dd($request->businessDetails);
        $businessDetail = $request->businessDetail ?? null;
    @endphp
    <form action="{{ $businessDetail ? route('verification.update.business', $businessDetail) : route('verification.store.business') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex flex-col w-full border-b ">
            <label for="document_file" class="block text-gray-700 text-lg font-bold mb-2">Business License</label>
                
            <div class="mb-6">
                <label for="document_file" class="block text-gray-500 text-sm font-medium mb-2">Upload License</label>
                <input type="file" name="document_file" id="document_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                @if ($businessDetail)
                    <a href="" target="_blank" class="mt-2 text-sm text-green-600 hover:underline cursor-pointer">document: {{ $businessDetail->business_license_name }}</p>
                @endif
            </div>
        </div>

        <div class="flex flex-col w-full mt-2">
            <label class="block text-gray-700 text-lg font-bold mb-2">Tax registration number</label>

            <div class="mb-6">
                <label for="tax_file" class="block text-gray-500 text-sm font-medium mb-2">Upload regisitration number proof</label>
                <input type="file" name="tax_file" id="tax_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                @if ($businessDetail)
                    <a href="" target="_blank" class="mt-2 text-sm text-green-600 hover:underline cursor-pointer">document: {{ $businessDetail->tax_number_name }}</a>
                @endif
            </div>
        </div>

        <div class="flex flex-col w-full mt-2">
            <div class="mb-6">
                <label for="website" class="block text-gray-700 font-medium mb-2">Website</label>
                <input type="text" name="website" id="website" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="">
            </div>
        </div>

        <input type="hidden" name="request_id" value="{{$request->id}}">

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-p hover:bg-primary-p-darker focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Upload and Continue
        </button>
    </form>
</div>
<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Step 3: Proof of Address</h2>
    <p class="text-gray-600 mb-6">Please provide a recent document showing your current address.</p>
    
    @php
        // dd($request->addressProofs);
        $addressProof = $request->addressProof ?? null;
    @endphp
    <form action="{{ $addressProof ? route('verification.update.address', $addressProof) : route('verification.store.address') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="document_type" class="block text-gray-700 font-medium mb-2">Document Type</label>
            <select name="document_type" id="document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                <option value="utility_bill">Recent Utility Bill</option>
                <option value="tax_assessment">Tax Assessment or Property Tax Receipt</option>
                <option value="insurance_policy">Homeowners/Insurance Policy Document</option>
            </select>
        </div>

        @php
            $filename = $addressProof->address_proof_path ?? null;
            // dd($filename);
        @endphp
        <div class="mb-6">
            <label for="document_file" class="block text-gray-700 font-medium mb-2">Upload Proof of Address</label>
            <input type="file" name="document_file" id="document_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
            @if($addressProof)
                <p class="mt-2 text-sm text-gray-600">DocumentcType: {{ $addressProof->document_type }}</p>
                <a href="{{route('document.show', ['filename' => $filename])}}" target="_blank" class="text-sm text-green-600 hover:underline cursor-pointer">Current document: {{ $addressProof->original_name }}</a>
            @endif
        </div>

        <input type="hidden" name="request_id" value="{{$request->id}}">

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-p hover:bg-primary-p-darker focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Upload and Continue
        </button>
    </form>
</div>
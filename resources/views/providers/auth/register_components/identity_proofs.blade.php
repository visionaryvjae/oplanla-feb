<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Step 2: Identity Verification</h2>
    <p class="text-gray-600 mb-6">The full name on the document must match the name on your profile.</p>

    @php
        // dd($request->identityProofs);
        $identityProof = $request->identityProofs ?? null;
        $filename = $identityProof->id_proof_path ?? null;
    @endphp
    <form action="{{ $request->identityProofs ? route('verification.update.identity', $identityProof) : route('verification.store.identity') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="document_type" class="block text-gray-700 font-medium mb-2">ID Type</label>
            <select name="document_type" id="document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                <option value="National ID Card">National ID Card</option>
                <option value="passport">Passport</option>
                <option value="Drivers License">Driver's License</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="document_file" class="block text-gray-700 font-medium mb-2">Upload proof of ID Document</label>
            <input type="file" name="document_file" id="document_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
            @if($identityProof)
                <p class="mt-2 text-sm text-gray-600">DocumentcType: {{ $identityProof->document_type }}</p>
                <a href="{{route('document.show', ['filename' => $filename])}}" target="_blank"p class="mt-2 text-sm text-green-600 hover:underline cursor-pointer">Current document: {{ $identityProof->original_name }}</a>
                <input type="hidden" name="image-name" value="{{ $identityProof->id_proof_path }}">
            @endif
        </div>

        <input type="hidden" name="request_id" value="{{$request->id}}">

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-p hover:bg-primary-p-darker focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Upload and Continue
        </button>
    </form>
</div>
<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Step 1: Proof of Account</h2>
    <p class="text-gray-600 mb-6">You must provide one of the below documents to prove the validity of your account.</p>

    @php
        // dd($request->ownershipProofs);
        $ownershipProof = $request->ownershipProofs ?? null;
        $filename = $ownershipProof->ownership_proof_path ?? null;
    @endphp
    <form action="{{ $ownershipProof ? route('verification.update.ownership', $ownershipProof) : route('verification.store.ownership') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="document_type" class="block text-gray-700 font-medium mb-2">Document Type</label>
            <select name="document_type" id="document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                <option value="Proof of account">proof of account</option>
                <option value="Bank Statement">Bank Statement</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="document_file" class="block text-gray-700 font-medium mb-2">Upload proof of Account Document</label>
            <input type="file" name="document_file" id="document_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
            @if($ownershipProof)
                <p class="mt-2 text-sm text-gray-600">DocumentType: {{ $ownershipProof->document_type }}</p>
                <a href="{{route('document.show', ['filename' => $filename])}}" target="_blank" class="mt-2 text-sm text-green-600 hover:underline cursor-pointer">Current document: {{ $ownershipProof->original_name }}</a>
                <input type="hidden" name="image-name" value="{{ $ownershipProof->ownership_proof_path }}">
            @endif
        </div>

        <input type="hidden" name="request_id" value="{{$request->id}}">

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-p hover:bg-primary-p-darker focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Upload and Continue
        </button>
    </form>
</div>
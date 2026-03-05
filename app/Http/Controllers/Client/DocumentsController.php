<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DocumentUploadedNotification;

class DocumentsController extends Controller
{
    public function documentUpload()
    {
        $tenantDocuments = Auth::guard('web')->user()->documents;

        return view('clients.documents.upload', compact('tenantDocuments'));
    }

    public function verifyStore(Request $request) 
    {
        // dd($request);
        $request->validate([
            'id_copy' => 'required|mimes:pdf,jpg,png|max:5120',
            'bank_statements' => 'required|mimes:pdf|max:10240',
            'pay_slips' => 'required|mimes:pdf|max:10240',
            'proof_of_address' => 'required|mimes:pdf|max:10240',
            'marriage_certificate' => 'nullable|mimes:pdf,jpg,png',
            'passport' => 'nullable|mimes:pdf,jpg,png',
            'work_permit' => 'nullable|mimes:pdf,jpg,png',
        ]);

        $user = Auth::guard('web')->user();
        // $folder = 'verification/' . $user->id;
 
        $data = [];
        foreach(['id_copy', 'bank_statements', 'proof_of_address', 'pay_slips', 'marriage_certificate', 'passport', 'work_permit'] as $doc) {
            if ($request->hasFile($doc)) {
                $data[$doc] = $request->file($doc)->store(
                    'tenant/docs/' . $user->id,
                    'local' // 'local' refers to the private storage disk
                );
            }
        }

        $user->documents()->update($data); // Assuming a relationship exists
        $user->update(['status' => 'pending']);

        $provider = $documents->enquiry->room->provider->users()->latest()->first();
        // dd($provider);

        $provider->notify(new DocumentUploadedNotification($documents));

        return redirect()->route('dashboard')->with('success', 'Documents submitted for review!');
    }

    public function verifyUpdate(Request $request) 
    {
        // dd($request);
        // 1. Validate that we have a valid field name and a file
        // $request->validate([
        //     'document_field' => 'required|string|in:id_copy,bank_statements,pay_slips,proof_of_address,marriage_certificate,passport,work_permit',
        //     'file' => 'required|mimes:pdf,jpg,png|max:10240',
        // ]);

        $user = Auth::guard('web')->user();
        $field = $request->input('document_field');
        $documents = $user->documents;
        // dd($field, $documents);

        if (!$documents) {
            return redirect()->back()->with('error', 'No document record found to update.');
        }

        // 2. Delete the old file if it exists to keep storage clean
        if ($documents->$field && Storage::disk('local')->exists($documents->$field)) {
            Storage::disk('local')->delete($documents->$field);
        }

        // 3. Store the new file using your existing path pattern
        $path = $request->file('new_file')->store(
            'tenant/docs/' . $user->id,
            'local'
        );

        // 4. Update the specific field and reset the global status to pending
        // We also clear the comments as the tenant is addressing the feedback
        $documents->update([
            $field => $path,
            'status' => 'pending',
            'comments' => null 
        ]);

        $provider = $documents->enquiry->room->provider->users()->latest()->first();

        $provider->notify(new DocumentUploadedNotification($documents));

        return redirect()->back()->with('success', 'Document updated successfully. Your application is now back under review.');
    }

    public function showDocument(Request $request)
    {
        $path = $request->input('filename');
        // dd($path);
        // Optional: Add authorization
        if (!Auth::guard('web')->check()) {
            abort(403, 'Access denied');
        };

        // Check if the file exists before attempting to serve it
        if (!Storage::disk('local')->exists($path)) {
            // dd("path not found");
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }
}

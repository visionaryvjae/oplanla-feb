<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    public function documentUpload()
    {
        

        return view('clients.documents.upload');
    }

    public function verifyStore(Request $request) 
    {
        // dd($request);
        $request->validate([
            'id_copy' => 'required|mimes:pdf,jpg,png|max:5120',
            'bank_statements' => 'required|mimes:pdf|max:10240',
            'pay_slips' => 'required|mimes:pdf|max:10240',
            'marriage_certificate' => 'nullable|mimes:pdf,jpg,png',
            'passport' => 'nullable|mimes:pdf,jpg,png',
            'work_permit' => 'nullable|mimes:pdf,jpg,png',
        ]);

        $user = Auth::guard('web')->user();
        $folder = 'verification/' . $user->id;
 
        $data = [];
        foreach(['id_copy', 'bank_statements', 'pay_slips', 'marriage_certificate', 'passport', 'work_permit'] as $doc) {
            if ($request->hasFile($doc)) {
                $data[$doc] = $request->file($doc)->store($folder, 'public');
            }
        }

        $user->documents()->update($data); // Assuming a relationship exists
        $user->update(['verification_status' => 'pending']);

        return redirect()->route('dashboard')->with('success', 'Documents submitted for review!');
    }
}

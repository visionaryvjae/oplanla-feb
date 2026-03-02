<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\OwnershipProof;
use App\Models\Booking\IdentityProof;
use App\Models\Booking\AddressProof;
use App\Models\Booking\BusinessDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Display the ownership verification form.
     */
    public function showOwnershipForm()
    {
        $initialTab = 'ownership'; 
        return view('providers.auth.user_verification', ['initialTab' => $initialTab]);
    }

    public function showIdentityForm()
    {
        $initialTab = 'identity'; 
        return view('providers.auth.user_verification', ['initialTab' => $initialTab]);
    }

    public function showAddressForm()
    {
        $initialTab = 'address'; 
        return view('providers.auth.user_verification', ['initialTab' => $initialTab]);
    }

    public function showBusinessForm()
    {
        $initialTab = 'business'; 
        return view('providers.auth.user_verification', ['initialTab' => $initialTab]);
    }

    /**
     * Store the ownership verification document.
     */
    public function storeOwnership(Request $request)
    {

        // dd($request);

        // 1. Validate the request
        $validated = $request->validate([
            'request_id' => 'required|int',
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        $provider = Auth::guard('provider')->user(); // Or Auth::guard('provider')->user();

        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 2. Store the file securely in a private directory
        // This will save the file to `storage/app/verifications/ownership/{provider_id}/`
        $path = $request->file('document_file')->store(
            'verifications/ownership/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        // 3. Save the file path and info to the database
        OwnershipProof::create([
            'request_id' => $validated['request_id'],
            'document_type' => $validated['document_type'],
            'original_name' => $originalName,
            'ownership_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);

        // 4. Redirect to the next step
        return redirect()->route('verification.identity')->with('success', 'Ownership proof uploaded successfully!');
    }

    public function updateOwnership(Request $request, OwnershipProof $ownershipProof)
    {
        $ownershipProofModel = Auth::guard('provider')->user()->partnerRequests->ownershipProofs;
        // dd($ownershipProofModel);

        // 1. Validate the new file and document type
        $validated = $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        // 2. Securely delete the old file from storage
        Storage::disk('local')->delete($ownershipProofModel->ownership_proof_path);
        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 3. Store the new file securely
        $provider = Auth::guard('provider')->user();
        $path = $request->file('document_file')->store(
            'verifications/ownership/' . $provider->id,
            'local'
        );

        // 4. Update the database record with the new path and reset status for re-verification
        $ownershipProofModel->update([
            'document_type' => $validated['document_type'],
            'ownership_proof_path' => $path,
            'original_name' => $originalName,
            'status' => 'pending', // Reset status so admins can review it again
        ]);

        $ownershipProofModel->save();
        
        if($ownershipProofModel->count() < 1)
        {
            $ownershipProofModel->request()->update([
                'status' => 'pending',    
            ]);
        }
        

        // 4. Redirect to the next step
        return redirect()-> route('partner.edit.verification')->with('success', 'Ownership proof uploaded successfully!');
    }












    public function storeIdentity(Request $request)
    {
        // 1. Validate the request
        $validated = $request->validate([
            'request_id' => 'required|int',
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        $provider = Auth::guard('provider')->user(); // Or Auth::guard('provider')->user();

        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 2. Store the file securely in a private directory
        // This will save the file to `storage/app/verifications/ownership/{provider_id}/`
        $path = $request->file('document_file')->store(
            'verifications/identity/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        // 3. Save the file path and info to the database
        IdentityProof::create([
            'request_id' => $validated['request_id'],
            'document_type' => $validated['document_type'],
            'original_name' => $originalName,
            'id_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);

        // 4. Redirect to the next step
        return redirect()->route('verification.address')->with('success', 'Ownership proof uploaded successfully!');
    }

    public function updateIdentity(Request $request, IdentityProof $identityProof)
    {
        // dd(Auth::guard('provider')->user()->partnerRequests->identityProofs);
        $identityProofModel = Auth::guard('provider')->user()->partnerRequests->identityProofs;
        // dd($identityProofModel);
        // 1. Validate the new file and document type
        $validated = $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        // dd($identityProof->first()->id_proof_path);
        // $identityProof = ;

        // 2. Securely delete the old file from storage
        Storage::disk('local')->delete($identityProofModel->id_proof_path);

        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 3. Store the new file securely
        $provider = Auth::guard('provider')->user();
        $path = $request->file('document_file')->store(
            'verifications/identity/' . $provider->id,
            'local'
        );

        // 4. Update the database record with the new path and reset status for re-verification
        $identityProofModel->update([
            'document_type' => $validated['document_type'],
            'original_name' => $originalName,
            'id_proof_path' => $path,
        ]);

        $identityProofModel->save();
        
        $identityProofModel->request()->update([
            'status' => 'pending',    
        ]);

        // 4. Redirect to the next step
        return redirect()-> route('partner.edit.verification')->with('success', 'Ownership proof uploaded successfully!');
    }














    public function storeAddress(Request $request)
    {
        // dd($request);
        // 1. Validate the request
        $validated = $request->validate([
            'request_id' => 'required|int',
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        $provider = Auth::guard('provider')->user(); // Or Auth::guard('provider')->user();

        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 2. Store the file securely in a private directory
        // This will save the file to `storage/app/verifications/ownership/{provider_id}/`
        $path = $request->file('document_file')->store(
            'verifications/address/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        // 3. Save the file path and info to the database
        AddressProof::create([
            'request_id' => $validated['request_id'],
            'document_type' => $validated['document_type'],
            'original_name' => $originalName,
            'address_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);

        // 4. Redirect to the next step
        return redirect()->route('verification.business')->with('success', 'Ownership proof uploaded successfully!');
    }

    public function updateAddress(Request $request, AddressProof $addressProof)
    {
        $addressProof = Auth::guard('provider')->user()->partnerRequests->addressProof;
        // dd($request);
        // 1. Validate the new file and document type
        $validated = $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        // 2. Securely delete the old file from storage
        Storage::disk('local')->delete($addressProof->address_proof_path);

        $file = $request->file('document_file'); 
        $originalName = $file->getClientOriginalName();

        // 3. Store the new file securely
        $provider = Auth::guard('provider')->user();
        $path = $request->file('document_file')->store(
            'verifications/address/' . $provider->id,
            'local'
        );

        // 4. Update the database record with the new path and reset status for re-verification
        $addressProof->update([
            'document_type' => $validated['document_type'],
            'original_name' => $originalName,
            'address_proof_path' => $path,
            'status' => 'pending', // Reset status so admins can review it again
        ]);
        
        $addressProof->save();
        $addressProof->request()->update([
            'status' => 'pending', 
        ]);

        // 4. Redirect to the next step
        return redirect()-> route('partner.edit.verification')->with('success', 'Ownership proof uploaded successfully!');
    }















    public function storeBusiness(Request $request)
    {
        // dd($request);

        // 1. Validate the request
        $validated = $request->validate([
            'request_id' => 'required|int',
            'document_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            'tax_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            'website' => 'string|nullable',
        ]);

        $provider = Auth::guard('provider')->user(); // Or Auth::guard('provider')->user();

        $file = $request->file('document_file'); 
        $originalDocName = $file->getClientOriginalName();

        $fileTax = $request->file('tax_file'); 
        $originalTaxName = $fileTax->getClientOriginalName();

        // 2. Store the file securely in a private directory
        // This will save the file to `storage/app/verifications/ownership/{provider_id}/`
        $path = $request->file('document_file')->store(
            'verifications/business/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        $taxPath = $request->file('tax_file')->store(
            'verifications/business/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        // 3. Save the file path and info to the database
        BusinessDetail::create([
            'request_id' => $validated['request_id'],
            'Business_license_path' => $path,
            'Tax_registration_number_path' => $taxPath,
            'business_license_name' => $originalDocName,
            'tax_number_name' => $originalTaxName,
            'website' => $validated['website'],
            // 'status' => 'pending', // Set an initial status for admin review
        ]);

        // 4. Redirect to the next step
        return redirect()->route('verification.identity')->with('success', 'Ownership proof uploaded successfully!');
    }

    public function updateBusiness(Request $request, BusinessDetail $businessDetail)
    {
        $businessDetail = Auth::guard('provider')->user()->partnerRequests->businessDetail;
        // dd($request);
        // 1. Validate the new file and document type
        $validated = $request->validate([
            'document_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            'tax_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);
        
        $originalDocName = "";
        $originalTaxName = "";

        if($request->hasFile('document_file')){
            $file = $request->file('document_file'); 
            $originalDocName = $file->getClientOriginalName();
            
            // 3. Store the new file securely
            $provider = Auth::guard('provider')->user();
            $path = $request->file('document_file')->store(
                'verifications/business/' . $provider->id,
                'local'
            );
        }

        if($request->hasFile('tax_file')){
             $fileTax = $request->file('tax_file'); 
            $originalTaxName = $fileTax->getClientOriginalName();
            
            $taxPath = $request->file('tax_file')->store(
                'verifications/business/' . $provider->id,
                'local' // 'local' refers to the private storage disk
            );
        }
        
        
        // 2. Securely delete the old file from storage
        Storage::disk('local')->delete($businessDetail->Business_license_path);
        Storage::disk('local')->delete($businessDetail->Tax_registration_number_path);


        // 4. Update the database record with the new path and reset status for re-verification
        $businessDetail->update([
            'Business_license_path' => $path,
            'Tax_registration_number_path' => $taxPath,
            'business_license_name' => $originalDocName,
            'tax_number_name' => $originalTaxName,
            'status' => 'pending', // Reset status so admins can review it again
        ]);

        $businessDetail->save();
        $businessDetail->request()->update([
            'status' => 'pending',  
        ]);

        // 4. Redirect to the next step
        return redirect()-> route('partner.edit.verification')->with('success', 'Ownership proof uploaded successfully!');
    }





    public function showDocument(Request $request)
    {
        $path = $request->input('filename');
        // dd($path);
        // Optional: Add authorization
        if (!Auth::guard('provider')->check() and !Auth::guard('admin')->check()) {
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

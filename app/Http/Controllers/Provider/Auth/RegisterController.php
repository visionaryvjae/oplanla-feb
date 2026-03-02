<?php

namespace App\Http\Controllers\Provider\Auth;

// app/Http/Controllers/Provider/Auth/RegisterController.php

use App\Http\Controllers\Controller;
use App\Models\Booking\Providers;
use App\Models\Booking\ProviderUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use App\Models\Booking\OwnershipProof;
use App\Models\Booking\IdentityProof;
use App\Models\Booking\AddressProof;
use App\Models\Booking\BusinessDetail;
use App\Models\Booking\PartnerRequest;
use App\Models\Booking\BankDetail;

class RegisterController extends Controller
{
    public function __construct()
    {
        // Ensure only guests can access the registration page
        // $this->middleware('guest:provider');
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('providers.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        
        $request->validate([
            'provider_name' => ['string', 'max:255', 'nullable'],
            'booking_address' => ['string', 'max:255', 'nullable'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:provider_users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            'account_number' => ['required', 'string'],
            'account_holder_name' => ['required', 'string'],
            'bank_name' => ['required', 'string'],
            'provider_id' => ['required', 'string'],
        ]);
        
        $validated = $request->validate([
            'ownership_document_type' => 'required|string',
            'ownership_document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            
            'address_document_type' => 'required|string',
            'address_document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            
            'id_document_type' => 'required|string',
            'id_document_file' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            
            'business_document_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            'tax_file' => 'file|mimes:pdf,jpg,png|max:5120', // Max 5MB
            
        ]);
        // dd($request, $validated);

        try {
            // Use a database transaction to ensure both records are created successfully
            DB::transaction(function () use ($request) {
                
                // 1. Create the Provider (the company)
                if($request->input('provider_id') > 0)
                {
                    $provider = Providers::findOrFail($request->input('provider_id'));
                }
                else{
                    $provider = Providers::create([
                        'provider_name' => $request->provider_name,
                        'booking_address' => $request->booking_address,
                        'description' => 'Default description, can be updated later.', // Optional
                    ]);     
                }
                
                
                BankDetail::create([
                    'providers_id' => $request->input('provider_id'),
                    'bank_name' => $request->input('bank_name'),
                    'account_number' => $request->input('account_number'),
                    'account_holder_name' => $request->input('account_holder_name'),
                ]);

                // 2. Create the ProviderUser (the login account) and associate it
                $user = ProviderUser::create([
                    'provider_id' => $provider->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                
                $partnerRequest = PartnerRequest::create([
                    'provider_user_id' => $user->id,
                    'status' => 'pending', // Default status
                    'message' => 'New provider registration request.',
                ]);

                // 3. Log the new user in
                Auth::guard('provider')->login($user);
                

            });
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error($e->getMessage()); // optional but recommended
            
            return back()->withErrors(['general' => 'Registration failed. Please try again.', 'catch' => $e->getMessage()])->withInput();
        }
        $partnerRequest = PartnerRequest::latest()->first();
        $provider = $partnerRequest->providerUser->provider;
        
        //ownership proof creation
        $ownership_file = $request->file('ownership_document_file'); 
        $originalName = $ownership_file->getClientOriginalName();
        
        $path = $request->file('ownership_document_file')->store(
            'verifications/ownership/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );
        
        OwnershipProof::create([
            'request_id' => $partnerRequest->id,
            'document_type' => $validated['ownership_document_type'],
            'original_name' => $originalName,
            'ownership_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);
        
        //Identity proof creation
        $identity_file = $request->file('id_document_file'); 
        $originalName = $identity_file->getClientOriginalName();
        
        $path = $request->file('id_document_file')->store(
            'verifications/identity/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );
        
        IdentityProof::create([
            'request_id' => $partnerRequest->id,
            'document_type' => $validated['id_document_type'],
            'original_name' => $originalName,
            'id_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);
        
        
        //Address proof creation
        $address_file = $request->file('address_document_file'); 
        $originalName = $address_file->getClientOriginalName();
        
        $path = $request->file('address_document_file')->store(
            'verifications/address/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );
        
        AddressProof::create([
            'request_id' => $partnerRequest->id,
            'document_type' => $validated['address_document_type'],
            'original_name' => $originalName,
            'address_proof_path' => $path,
            'status' => 'pending', // Set an initial status for admin review
        ]);
        
        
        //Business Detail Creation
        $business_file = $request->file('business_document_file'); 
        $originalDocName = $business_file->getClientOriginalName();

        $fileTax = $request->file('tax_file'); 
        $originalTaxName = $fileTax->getClientOriginalName();

        // 2. Store the file securely in a private directory
        // This will save the file to `storage/app/verifications/ownership/{provider_id}/`
        $path = $request->file('business_document_file')->store(
            'verifications/business/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        $taxPath = $request->file('tax_file')->store(
            'verifications/business/' . $provider->id,
            'local' // 'local' refers to the private storage disk
        );

        // 3. Save the file path and info to the database
        BusinessDetail::create([
            'request_id' => $partnerRequest->id,
            'Business_license_path' => $path,
            'Tax_registration_number_path' => $taxPath,
            'business_license_name' => $originalDocName,
            'tax_number_name' => $originalTaxName,
            // 'status' => 'pending', // Set an initial status for admin review
        ]);

        // dd($partnerRequest);
        

        return redirect()->route('provider.dashboard')->with('status', 'Registration successful! Please upload verification documents for partner request consideration!');
    }
}
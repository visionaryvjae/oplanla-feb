<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\PartnerRequest;

class PartnerRequestController extends Controller
{
    public function index()
    {
        $partner_request = PartnerRequest::all(); // Fetch all partner requests
        return view('admin.providers.requests.index', ['partner_requests' => $partner_request, 'pagetitle' => 'Partner Requests']); // Return the view with the partner requests
    }

    public function show($id)
    {
        $partner_request = PartnerRequest::findOrFail($id); // Fetch a specific partner request by ID
        return view('admin.providers.requests.request-show', ['request' => $partner_request, 'pagetitle' => 'Partner Request Details']); // Return the view with the partner request details
    }

    public function create(){
        $partner_request = new PartnerRequest(); // Create a new instance for a partner request
    }

    public function store(Request $request)
    {
        // Logic to store a new partner request
    }

    public function edit(int $id)
    {
        $partner_request = PartnerRequest::findOrFail($id); // Fetch a specific partner request for editing

    }

    public function update(Request $request, int $id)
    {
        // Logic to update a partner request
    }

    public function destroy(int $id)
    {
        $partner_request = PartnerRequest::findOrFail($id); // Fetch the partner request to delete
        $partner_request->delete(); // Delete the partner request
    }

    public function acceptRequest(int $id)
    {
        $partner_request = PartnerRequest::findOrFail($id); // Fetch the partner request to accept
        $partner_request->status = 'accepted'; // Update the status to accepted
        $partner_request->save(); // Save the changes
        return redirect()->route('admin.partner-requests.index')->with('success', 'Partner request accepted successfully.'); // Redirect with success message
    }

    public function rejectRequest(int $id, Request $request)
    {
        // dd($request);
        $partner_request = PartnerRequest::findOrFail($id); // Fetch the partner request to reject
        
       $reject_reason = $request->input('reject_reason');
        
        if ($reject_reason == 'ownership') {
            $partner_request->ownershipProofs()->update([
                'reason' => 'please reupload your ownership proof'
            ]);
        }
        
        if ($reject_reason == 'address') {
            $partner_request->addressProof()->update([
                'reason' => 'please reupload your proof of address'
            ]);
        }
        
        if ($reject_reason == 'identity') {
            $partner_request->identityProofs()->update([
                'reason' => 'please reupload your proof of identity'
            ]);
        }
        
        if ($reject_reason == 'license') {
            $partner_request->businessDetail()->update([
                'reason' => 'please reupload your business license'
            ]);
        }
        
        if ($reject_reason == 'tax') {
            $partner_request->businessDetail()->update([
                'reason' => 'please reupload your tax number'
            ]);
        }
        
        // Update partner request status
        $partner_request->update(['status' => 'rejected']);
        
        return redirect()->route('admin.partner-requests.index')->with('success', 'Partner request rejected successfully.');
    }
}

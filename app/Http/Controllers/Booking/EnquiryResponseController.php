<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\Enquiry;
use App\Models\Booking\EnquiryReply;
use App\Notifications\EnquiryResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AdminEnquiryReplyNotification;
use App\Models\Booking\TenantDocuments;
use App\Notifications\UploadDocumentsNotification;

class EnquiryResponseController extends Controller
{
    
    public function index(Request $request)
    {
        $providerId = Auth::guard('provider')->user()->provider->id;
        
        $query = Enquiry::query();
         
        $query->whereHas('room', function ($query) use ($providerId) {
                $query->where('providers_id', $providerId);
        });
        
        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->whereHas('user', function($q) use($search) {
               $q->where('name', 'like', $search); 
            })->orWhere('message', 'like', $search);
        }
        
        if($request->filled('start_date')){
            $query->where('created_at', '>=', $request->start_date);
        }
        
        if($request->filled('end_date')){
            $query->where('created_at', '<=', $request->end_date);
        }
        
        
        
        
        // dd($enquiries);
        $enquiries = $query->latest()->paginate(10);
            
        return view('providers.enquiries.index', ['enquiries' => $enquiries, 'pagetitle' => 'Enquiries']);
    }
    
    public function show (int $enquiryId) 
    {
        $enquiry = Enquiry::findOrFail($enquiryId);
        return view('providers.enquiries.show', ['enquiry' => $enquiry]);
    }
    
    // Show the response page to the Provider/Admin
    public function showResponseForm(Enquiry $enquiry)
    {
        return view('providers.enquiries.respond', compact('enquiry'));
    }

    // Save the reply and notify the Client
    public function storeReply(Request $request, Enquiry $enquiry)
    {
        // dd($request);
        $reply = EnquiryReply::create([
            'enquiry_id' => $enquiry->id,
            'provider_user_id' => $enquiry->room->provider->users->first()->id,
            'message' => $request->message,
        ]);

        // Notify the Client (the person who made the original enquiry)
        // Assuming your Enquiry model has a 'user' relationship or 'email' field
        $enquiry->user->notify(new EnquiryResponseNotification($enquiry, $reply));
        
        Notification::route('mail', 'info@oplanla.com')
                    ->notify(new AdminEnquiryReplyNotification($enquiry, $reply));

        return back()->with('success', 'Response sent to client!');
    }
    
    public function markAsPotentialTenant(int $enquiryId) {
        $enquiry = Enquiry::findOrFail($enquiryId);

        // dd($enquiry, $enquiry->user);
        $client = $enquiry->user; 
        $client->update(['role' => 'tenant', 'room_id' => $enquiry->rooms_id]);
        $client->save();

        return back()->with('success', 'Client marked as tenant successfully!');
    }


    public function requestDocuments(int $enquiryId)
    {
        $enquiry = Enquiry::findOrFail($enquiryId);

        $client = $enquiry->user;

        $documents = TenantDocuments::create([
            'users_id' => $client->id,
        ]);

        $client->notify(new UploadDocumentsNotification($documents));

        return back()->with('successfully sent document request');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking\Enquiry;
use App\Models\Booking\EnquiryReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EnquiryResponseNotification;
use App\Notifications\AdminEnquiryReplyNotification;
use App\Notifications\ProviderEnquiryReplyNotification;

class EnquiryController extends Controller
{
    public function index(Request $request) {
        Auth::guard('admin')->user()
            ->unreadNotifications
            ->where('data.category', 'enquiries')
            ->markAsRead();

        $query = Enquiry::query();
        
        if($request->filled('search')){
            $search = '%' . $request->search . '%';
            $query->whereHas('user', function($q) use($search) {
               $q->where('name', 'like', $search); 
            })->orWhereHas('room.provider.users', function($q) use($search) {
               $q->where('name', 'like', $search); 
            })->orWhere('message', 'like', $search);
        }
        
        if($request->filled('start_date')){
            $query->where('created_at', '>=', $request->start_date);
        }
        
        if($request->filled('end_date')){
            $query->where('created_at', '<=', $request->end_date);
        }
        
        $enquiries = $query->latest()->paginate(10);
        
        
        return view('admin.enquiries.index', ['enquiries' => $enquiries, 'pagetitle' => 'Enquiries']);
    }
    
    public function show (int $enquiryId) 
    {
        $enquiry = Enquiry::findOrFail($enquiryId);
        return view('admin.enquiries.show', ['enquiry' => $enquiry]);
    }
    
    public function storeReply(Request $request, Enquiry $enquiry)
    {
        // dd(Auth::guard('admin')->user()->id);
        $reply = EnquiryReply::create([
            'enquiry_id' => $enquiry->id,
            'admin_id' => Auth::guard('admin')->user()->id,
            'message' => $request->message,
        ]);

        // Notify the Client (the person who made the original enquiry)
        // Assuming your Enquiry model has a 'user' relationship or 'email' field
        $enquiry->user->notify(new EnquiryResponseNotification($enquiry, $reply));
        
        $enquiry->room->provider->users->first()->notify(new ProviderEnquiryReplyNotification($enquiry, $reply));

        return back()->with('success', 'Response sent to client!');
    }
    
    public function markAsPotentialTenant() {
        return view('admin.enquiries.index');
    }
}

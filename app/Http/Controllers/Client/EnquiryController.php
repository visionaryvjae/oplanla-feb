<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking\Room;
use Illuminate\Http\Request;
use App\Models\Booking\Enquiry;
use App\Models\Booking\EnquiryReply;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RentalInterestNotification;
use App\Notifications\ProviderEnquiryReplyNotification;
use App\Notifications\AdminEnquiryReplyNotification;
use App\Notifications\NewEnquiryNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin\Admin;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Auth::guard('web')->user()->enquiries;
        return view('clients.enquiries.index', compact('enquiries'));
    }
    
    public function show(int $enquiryId) 
    {
        // dd($enquiryId);
        $enquiry = Enquiry::findOrFail($enquiryId);
        
        return view('clients.enquiries.show', compact('enquiry'));
    }
    
    
    public function sendEnquiry(Request $request, int $roomId)
    {
        // dd($roomId);
        $validationData = $request->validate([
            'message' => 'required | string',
        ]);
        
        // dd($validationData);
        // 1. Validate and save the enquiry logic here...
        $enquiry = Enquiry::create([
            'users_id' => Auth::guard('web')->user()->id,
            'rooms_id' => $roomId,
            'message' => $validationData['message'],
        ]); 
        
        // dd($enquiry);
    
        // 2. Notify the Property Provider (assuming the relationship is defined)
        
        $room = Room::findOrFail($roomId);
        if($room->provider->users->first()){
            $provider = $room->provider->users->first(); // or $property->provider_user
            $provider->notify(new RentalInterestNotification($room, $enquiry));
        }
    
        // 3. Notify the Company (On-Demand Notification)
        Notification::route('mail', 'info@oplanla.com')
                    ->notify(new RentalInterestNotification($room, $enquiry));
                    
        $admins = Admin::all();
        Notification::send($admins, new NewEnquiryNotification($enquiry->id));
                    
    
        return redirect()->route('room.booking')->with('success', 'Your enquiry has been sent! Please check you emails for responses');
    }
    
    public function storeReply(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);
    
        $reply = EnquiryReply::create([
            'enquiry_id' => $id,
            'user_id' => auth()->id(), // Associate with the logged-in client message
            'message' => $request->message,
        ]);
        
        $enquiry = Enquiry::findOrFail($id);
        
        $enquiry->room->provider->users->first()->notify(new ProviderEnquiryReplyNotification($enquiry, $reply));
        
        Notification::route('mail', 'info@oplanla.com')->notify(new AdminEnquiryReplyNotification($enquiry, $reply));
    
        return back()->with('success', 'Your message has been sent to the provider.');
    }
}

<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Property; // Assuming your 'providers' table is the Property model
use App\Models\Booking\Room;
use App\Jobs\SendBulkNotification;
use Illuminate\Support\Facades\Auth;

class BulkNotificationController extends Controller
{
    public function index() 
    {
        $provider = Auth::guard('provider')->user()->provider;
        $properties = $provider->properties()->get();
        $rooms = $provider->rooms()->where('available',false)->get();

        return view('providers.notifications.bulk', compact('rooms', 'properties'));
    }

    public function send(Request $request)
    {
        // dd($request);
        $request->validate([
            'selected_tenants' => 'required|array|min:1',
            'message' => 'required|string|max:5000',
            'channel' => 'required|in:email,whatsapp,sms',
        ]);

        // We focus on the background job to keep the UI snappy 
        SendBulkNotification::dispatch(
            $request->selected_tenants, 
            $request->message,
            // $request->channel
        );

        return back()->with('success', 'Bulk notification has been queued for delivery!');
    }


}

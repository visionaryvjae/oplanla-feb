<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\ScheduledEmail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'users_id' => 'integer',
            'subject' => 'required',
            'body' => 'required',
            'send_at' => 'required|date'
        ]);

        ScheduledEmail::create($validated);

        return response()->json(['message' => 'Email scheduled successfully']);
    }
}

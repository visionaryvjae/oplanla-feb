<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form view.
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Validate the form data and send the email to the site admin.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // 2. The email address that will receive the contact form message
        // This should be your email address, and it's protected by being in the .env file
        $recipientEmail = env('MAIL_FROM_ADDRESS');

        // 3. Send the email using our Mailable
        Mail::to($recipientEmail)->send(new ContactFormMail($validated));

        // 4. Redirect the user back with a success message
        return redirect()->route('contact.create')->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}
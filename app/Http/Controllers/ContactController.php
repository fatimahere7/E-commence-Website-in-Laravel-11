<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:15',
            'message' => 'required|string',
        ]);

        // Send email to the admin
        Mail::send('emails.contact', $validated, function ($message) use ($validated) {
            $message->to('fatimamansoor529@gmail.com') 
                    ->subject('New Contact Message from ' . $validated['name']);
        });

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}

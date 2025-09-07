<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact' => 'required|string|max:50',
            'message' => 'required|string',
        ]);

        // Send email to admin
        Mail::raw(
            "Name: {$data['name']}\nEmail: {$data['email']}\nContact: {$data['contact']}\n\nMessage:\n{$data['message']}",
            function ($message) use ($data) {
                $message->to('ejeybumagat5@gmail.com') // <-- Change to your admin email
                        ->subject('Contact Form Submission');
            }
        );

        // Send auto-reply to user
        Mail::raw(
            "Hi {$data['name']},\n\nThank you for contacting So Hu Beach Club Resort! Your message has been received. We will reply as soon as possible.\n\nBest regards,\nSo Hu Beach Club Resort Team",
            function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject('We received your message!');
            }
        );

        return back()->with('success', 'Your message has been sent! Please wait for our reply.');
    }
}

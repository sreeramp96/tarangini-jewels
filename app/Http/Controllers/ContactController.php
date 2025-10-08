<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // For now just store locally or simulate
        // Later you can configure mail sending
        Mail::raw("Message from {$validated['name']} ({$validated['email']}):\n\n{$validated['message']}", function ($msg) {
            $msg->to('admin@example.com')->subject('Contact Form Message');
        });

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}

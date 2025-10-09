@extends('frontend.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Contact Us</h2>

        <form action="{{ route('contact.store') }}" method="POST" class="bg-white p-6 shadow rounded-lg space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Your Name" class="w-full border rounded-lg p-2">
            <input type="email" name="email" placeholder="Your Email" class="w-full border rounded-lg p-2">
            <textarea name="message" rows="4" placeholder="Your Message" class="w-full border rounded-lg p-2"></textarea>
            <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700">Send
                Message</button>
        </form>
    </div>
@endsection

@extends('frontend.layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">What Our Customers Say</h2>
        <div class="grid sm:grid-cols-2 gap-6">
            @foreach ($testimonials as $testimonial)
                <div class="bg-white shadow rounded-lg p-6">
                    <p class="italic text-gray-600 mb-2">“{{ $testimonial->message }}”</p>
                    <p class="font-semibold text-amber-700 text-right">– {{ $testimonial->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

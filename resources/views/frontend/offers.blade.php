@extends('frontend.layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Exclusive Offers</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($offers as $offer)
                <div class="bg-white p-6 shadow rounded-lg text-center">
                    <h3 class="text-lg font-bold text-amber-700">{{ $offer->name }}</h3>
                    <p class="text-gray-600 mt-2">
                        {{ $offer->type === 'percentage' ? $offer->value . '% off' : '₹' . $offer->value . ' off' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Valid till
                        {{ \Carbon\Carbon::parse($offer->end_date)->format('M d, Y') }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

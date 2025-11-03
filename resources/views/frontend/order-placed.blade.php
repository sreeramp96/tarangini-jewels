@extends('layouts.frontend')

@section('content')
<main class="bg-gray-100 py-24 px-6 lg:px-20">
    <div class="max-w-xl mx-auto bg-white p-12 rounded-lg shadow-md text-center">
        <x-heroicon-o-check-circle class="w-20 h-20 text-green-500 mx-auto mb-6" />
        <h1 class="text-3xl font-bold hero-text text-gray-800 mb-4">Thank You!</h1>
        <p class="text-lg text-gray-600 mb-8">
            Your order has been placed successfully. You will receive an email confirmation shortly.
        </p>
        <a href="{{ route('home') }}" class="btn-gold px-8 py-3 rounded font-semibold text-lg inline-block">
            Continue Shopping
        </a>
    </div>
</main>
@endsection

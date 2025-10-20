@extends('layouts.frontend')

@section('content')
    {{-- This container positions the card on the page --}}
    <div class="h-full w-full flex justify-center items-start pt-20 p-4 hero-text">

        {{-- This is the styled card that holds the form --}}
        <div class="w-full sm:max-w-md px-6 py-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" class="!text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- Styled the button to match your brand --}}
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-md font-semibold text-sm uppercase tracking-widest btn-gold glow-hover">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
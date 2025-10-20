@extends('layouts.frontend')

@section('content')
    <div class="h-full w-full flex justify-center items-start pt-20 p-4 hero-text">

        <div class="w-full sm:max-w-md px-6 py-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" class="!text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="!text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-amber-700 hover:text-amber-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit"
                        class="ms-3 py-2 px-4 rounded-md font-semibold text-xs uppercase tracking-widest btn-gold glow-hover">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
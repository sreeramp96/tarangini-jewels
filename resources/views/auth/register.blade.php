@extends('layouts.frontend')

@section('content')
    <div class="h-full w-full flex justify-center items-start pt-20 p-4 hero-text">
        <div class="w-full sm:max-w-md px-6 py-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="!text-gray-700" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="!text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="!text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="!text-gray-700" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-amber-700 hover:text-amber-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit"
                        class="ms-4 py-2 px-4 rounded-md font-semibold text-xs uppercase tracking-widest btn-gold glow-hover">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
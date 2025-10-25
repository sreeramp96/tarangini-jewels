{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('layouts.frontend')

@section('content')
    <main class="flex-grow flex flex-col justify-center items-center w-full p-8" style="background-color: #0a2e2b;">
        <div class="w-full max-w-4xl space-y-8">
            <div class="p-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 hero-text">
                            Profile Picture
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Update your account's profile picture.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                class="w-8 h-8 rounded-full object-cover">
                            <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                                file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" />
                        </div>
                        @error('avatar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="px-6 py-2 rounded text-white font-medium btn-gold glow-hover">Save</button>
                        </div>
                    </form>
                </section>
            </div>

            {{-- 1. UPDATE PROFILE INFORMATION CARD --}}
            <div class="p-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- 2. UPDATE PASSWORD CARD --}}
            <div class="p-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">
                @include('profile.partials.update-password-form')
            </div>

            {{-- 3. DELETE ACCOUNT CARD --}}
            <div class="p-8 shadow-xl rounded-lg" style="background-color: #f8f8f5;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </main>
@endsection
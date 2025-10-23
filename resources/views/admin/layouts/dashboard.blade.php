{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700">Total Products</h2>
            <p class="text-3xl text-gray-900 mt-2">150</p> {{-- Example data --}}
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700">Total Categories</h2>
            <p class="text-3xl text-gray-900 mt-2">12</p> {{-- Example data --}}
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700">Pending Orders</h2>
            <p class="text-3xl text-gray-900 mt-2">5</p> {{-- Example data --}}
        </div>
    </div>
@endsection

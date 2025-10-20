@extends('layouts.frontend')

@section('content')
    <main class="flex-grow flex flex-col sm:justify-center items-center w-full" style="background-color: #0a2e2b;">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </main>
@endsection
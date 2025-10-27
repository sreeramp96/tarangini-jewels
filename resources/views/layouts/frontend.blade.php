<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarangini Jewels</title>
<link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
<link
    href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap"
    rel="stylesheet">

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #0b3d2e;
        color: #f8f8f5;
        scroll-behavior: smooth;
    }

    .hero-text {
        /* font-family: 'Playfair Display', serif; */
        font-family: "Newsreader", serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
    }

    /* Gold Gradient Text */
    .gold-gradient {
        background: linear-gradient(90deg, #d4af37, #f9e6b3, #d4af37);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: shimmer 5s linear infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 0% center;
        }

        100% {
            background-position: 200% center;
        }
    }

    /* Glow hover effect */
    .glow-hover:hover {
        box-shadow: 0 0 25px #d4af3775;
        transform: translateY(-3px);
    }

    /* Button animation */
    .btn-gold {
        background-color: #d4af37;
        color: #0b3d2e;
        transition: all 0.3s ease-in-out;
    }

    .btn-gold:hover {
        background-color: #f1cf73;
        box-shadow: 0 0 20px #d4af3775;
    }
</style>
</head>

<body class="flex flex-col min-h-screen">
    @include('frontend.partials.navbar')
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('frontend.partials.footer')
</body>

</html>

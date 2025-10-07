<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tarangini Jewels</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @include('frontend.partials.navbar')
    <main>@yield('content')</main>
    @include('frontend.partials.footer')
</body>

</html>

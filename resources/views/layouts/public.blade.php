@php($meta = $meta ?? ['title' => 'AarogyaCare', 'description' => 'Advanced AI Powered Hospital Management System'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
        {"@context":"https://schema.org","@type":"Hospital","name":"AarogyaCare","url":"{{ url('/') }}","medicalSpecialty":"MultiSpecialty"}
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="loader" data-loader><span></span></div>
    <x-site.topbar />
    <x-site.header />

    <main id="main">
        @yield('content')
    </main>

    <x-site.footer />

    <button class="back-to-top" data-back-top aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
    @if(session('toast'))
        <div class="toast is-visible" role="status">{{ session('toast.message') }}</div>
    @endif
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bioskop 123</title>
    <meta name="description" content="Bioskop 123">
    <link rel="shortcut icon" href="/icon.png" type="image/png">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    @include('layout.navbar')
    <div class="container mt-5">
        @yield('content')
    </div>
    @include('layout.footer')
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>

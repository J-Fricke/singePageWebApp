<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/bundle.js"></script>
</head>
<body><header>

</header>
<div class="container">
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')
    @yield('postFooterJs')
</div>
</body>
</html>
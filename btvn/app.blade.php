<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechBlog')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('layouts.navbar')

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>© 2026 TechBlog - Tin tức công nghệ và học tập</p>
    </footer>

</body>
</html>

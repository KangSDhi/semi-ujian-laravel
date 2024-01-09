<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>@yield('title')</title>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('css')
</head>
<body>
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  @stack('script')
</body>
</html>
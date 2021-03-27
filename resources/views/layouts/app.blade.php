<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Ova Siparis Barkod</title>
    <link rel="shortcut icon" href="#">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="min-h-screen bg-gray-100" id="app">

    <main class="py-10">
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@yield('script')
</body>
</html>

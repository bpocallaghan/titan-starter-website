<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="author" content="{!! config('app.author') !!}">
        <meta name="keywords" content="{!! config('app.keywords') !!}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $HTMLDescription ?? config('app.description') }}"/>

        <title>{{ $HTMLTitle ?? config('app.name') }}</title>

        <link rel="stylesheet" href="/css/admin.css?v={{ config('app.assets_version') }}">

        @yield('styles')
    </head>
    <body class="hold-transition login-page">

        @yield('content')

        <script src="/js/admin.js?v={{ config('app.assets_version') }}"></script>

        @yield('scripts')

        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                new ButtonClass();
            });
        </script>
    </body>
</html>

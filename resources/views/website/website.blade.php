<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="{{ config('app.author') }}">
        <meta name="keywords" content="{{ config('app.keywords') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? config('app.description') }}"/>

        <meta property="og:type" name="og:type" content="website"/>
        <meta property="og:site_name" content="{{ config('app.name') }}"/>
        <meta property="og:url" name="og:url" content="{{ request()->url() }}"/>
        <meta property="og:caption" name="og:caption" content="{{ config('app.url') }}"/>
        <meta property="fb:app_id" name="fb:app_id" content="{{ config('app.facebook_id') }}"/>
        <meta property="og:title" name="og:title" content="{{ $title ?? config('app.title') }}">
        <meta property="og:description" name="og:description" content="{{ $description ?? config('app.description') }}">
        <meta property="og:image" name="og:image" content="{{ config('app.url') }}{{ $image ?? '/images/logo.png' }}">

        <link rel="shortcut icon" type="image/ico" href="/favicon.ico">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="stylesheet" href="/css/website.css?v={{ config('app.assets_version') }}">

        @yield('styles')
    </head>

    <body id="top" class="d-flex flex-column align-items-end">
        <h1 class="d-none">{{ $title ?? config('app.name') }}</h1>

        @if(config('app.env') != 'local')
            @include('partials.facebook')
        @endif

        @include('website.partials.header')

        @include('website.partials.banners')

        <main>
            @yield('content')
        </main>

        @include('website.partials.footer')

        {{-- back to top --}}
        <div class="back-to-top-box fixed-bottom">
            <a href="#top" class="back-to-top animate jumper btn btn-primary" data-icon="fa fa-angle-up"></a>
        </div>

        <script type="text/javascript" charset="utf-8" src="/js/website.js?v={{ config('app.assets_version') }}"></script>

        @yield('scripts')

        @if(config('app.env') != 'local')
            @include('partials.analytics')
        @endif

        @include('website.partials.form.captcha')
    </body>
</html>

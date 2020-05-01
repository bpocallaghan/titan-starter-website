<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <title>{{ isset($HTMLTitle) ? $HTMLTitle : config('app.name') }}</title>

        <link rel="stylesheet" href="{{ config('app.url') }}/css/pdf.css?v=1">
    </head>

    <body class="body">
        @yield('content')
    </body>
</html>
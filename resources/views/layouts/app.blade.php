<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$pageTitle ?? 'Betonko'}}</title>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="icon" href="{{ asset('img/favicons/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicons/site.webmanifest') }}">

@yield('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('img/layout/icons.svg') }}">--}}

    <script src="{{ asset('js/app.js') }}"></script>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-215401890-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-215401890-1');
    </script>


</head>

<body>

<div class="wrapper">
    @include('frontend._modules.header')
    <div class="content">

        @yield('content')

    </div>
    @include('frontend._modules.footer')
</div>

@if(!request()->routeIs('frontend::*') && (Auth::guard('client')->check() || Auth::guard('business')->check()))
    @include('frontend._modules.reviews-service-dialog')

@endif

@include('frontend._modules.confirm-delete-dialog')
@include('frontend._modules.confirm-canceled-dialog')
@include('frontend._modules.auth-dialog')
@include('frontend._modules.contact_us')

@include('frontend._modules.icons')

@yield('scripts')
@yield('map_scripts')

</body>
</html>

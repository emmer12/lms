<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>{{ 'KMI LEARNING PORTAL' }}</title>
    <meta property="og:title" content="KMI LEARNING PORTAL" />
    <meta property="og:description"
        content="Welcome to KingsWord Learning Portal, your premier online spiritual development centre!" />
    <meta property="og:url" content="https://learning.kingsword.org" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/scss/main.scss', 'resources/js/main.js'])

    <script>
        window.AppConfig = {
            name: '{{ env('APP_NAME') }}',
            logo: '{{ env('APP_LOGO') }}',
            url: '{{ env('APP_URL') }}',
            csrf: '{{ csrf_token() }}',
            defaultLocale: '{{ env('APP_LOCALE', 'en') }}',
            defaultTimezone: '{{ env('APP_TIMEZONE', 'UTC') }}',
            locales: {
                en: {!! json_encode(\Illuminate\Support\Facades\Lang::get('frontend', [], 'en')) !!},
                mk: {!! json_encode(\Illuminate\Support\Facades\Lang::get('frontend', [], 'mk')) !!},
            },
            course_pass_percent: '{{ config('app.pass_percent') }}'
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
</head>

<body class="font-inter">
    <noscript>
        <strong>We're sorry but this application doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>

    <div id="app"></div>

</body>

</html>

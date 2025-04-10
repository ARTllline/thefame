<!doctype html>
<html
    lang="ru">
<head>
    <meta name="robots" content="noindex, nofollow">

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="/images/favicon.ico">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">

    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="google-site-verification" content="kaqDHYPGbblJVDADl7C-pO7JBDFPlHfIx8iLrdRVI8o">
    <meta name="format-detection" content="telephone=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap" rel="stylesheet">
    <?php

    $files = scandir('dist');

    foreach ($files as $file) {
        if (strstr($file, 'js') && !strstr($file, 'map')) {
            $js = $file;
        }

        if (strstr($file, 'css') && !strstr($file, 'map')) {
            $css = $file;
        }
    }

    $inlineStyles = file_get_contents('dist/' . $css);
    ?>
    <style>
        {!! $inlineStyles !!}
    </style>
</head>
<body>

@include('parts.icon-sprite')
@include('components.header.header')
@yield('content')
@include('components.footer.footer')

@include('components.modal.modal')
@include('components.locale-selector.locale-selector')
@include('components.region-selector.region-selector')


<script src="/dist/{{ $js }}"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</body>
</html>

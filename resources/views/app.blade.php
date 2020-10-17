<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="Ozzie - {{ config('app.organization') }}'s Open Source Project Dashboard">

        <meta property="og:site_name" content="Ozzie">
        <meta property="og:locale" content="en_US">
        <meta property="og:title" content="Ozzie">
        <meta property="og:url" content="https://ozzie.tighten.co/">
        <meta property="og:type" content="website">
        <meta property="og:description" content="Ozzie - {{ config('app.organization') }}'s Open Source Project Dashboard">

        <meta property="og:image" content="https://ozzie.tighten.co/ozzie-opengraph.png">
        <meta property="og:image:height" content="630">
        <meta property="og:image:width" content="1200">

        <meta name="twitter:site" content="@tightenco">
        <meta name="twitter:creator" content="@tightenco">
        <meta name="twitter:title" content="Ozzie">
        <meta name="twitter:description" content="Ozzie - {{ config('app.organization') }}'s Open Source Project Dashboard">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="https://ozzie.tighten.co/ozzie-opengraph.png">

        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/vendor.css">
        @routes
        <title>Ozzie - {{ config('app.organization') }}</title>
        <script>window.githubToken="{{ config('github.rateLimitToken') }}"</script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        @inertia
    </body>
</html>

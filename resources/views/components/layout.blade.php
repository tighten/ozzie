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

    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

    <title>Ozzie - {{ config('app.organization') }}</title>
</head>

<body>
<div class="bg-white border-t-4 border-indigo relative z-10 shadow">
    <section class="max-w-4xl mx-auto px-2">
        <div class="flex justify-between items-center">
            <h1 class="flex items-center">
                <span class="font-light text-5xl text-indigo">O</span>

                <span class="uppercase text-2xl leading-normal text-black-light font-semibold font-sans tracking-wide">zzie</span>
            </h1>

            <p class="font-sans italic font-normal leading-normal tracking-tight text-grey-blue-darkest">Addressing our open source debt</p>
        </div>
    </section>
</div>

<div id="app" class="bg-frost font-sans relative overflow-x-auto z-0">
    <div class="max-w-4xl mx-auto px-2 py-6">
        {{ $slot }}
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

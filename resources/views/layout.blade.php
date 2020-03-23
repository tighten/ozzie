<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/main.css">

        <title>Ozzie - Tighten</title>
    </head>

    <body>
        <div class="bg-white border-t-4 border-indigo relative z-10 shadow">
            <section class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center">
                    <p class="flex items-center">
                        <span class="text-5xl text-indigo font-montserrat">O</span>

                        <span class="uppercase text-2xl leading-normal text-black-light font-semibold font-open-sans tracking-wide">zzie</span>
                    </p>

                    <p class="font-open-sans italic font-normal leading-normal tracking-tight text-grey-blue-darkest">Addressing our open source debt</p>
                </div>
            </section>
        </div>

        <div id="app" class="bg-frost font-sans relative z-0">
            <div class="max-w-4xl mx-auto py-6">
                @yield('content')
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>

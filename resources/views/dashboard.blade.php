<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/main.css">

        <title>Ozzie - Tighten</title>
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
                <x-debt-table :projects="$projects" :hacktoberfest="$hacktoberfest"/>

                @foreach ($projects as $project)
                    <x-project :project="$project" />
                @endforeach
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ozzie - Tighten</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                margin: 0;
            }

            .container {
                margin: 2em auto;
                max-width: 800px;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .m-b-lg {
                margin-bottom: 60px;
            }
        </style>
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title m-b-md">
                    Ozzie - Tighten
                </div>

                @foreach ($projects as $project)
                    <div class="m-b-lg">
                        <h2>{{ $project['namespace'] }} | {{ $project['name'] }}</h2>
                        <p>Maintained by <a href="https://github.com/{{ $project['maintainer'] }}">{{ $project['maintainer'] }}</a></p>

                        <h3>Pull Requests</h3>
                        <ul class="issues">
                            @foreach ($project['prs'] as $pr)
                                <li><a href="{{ $pr['html_url'] }}">{{ $pr['title'] }}</a></li>
                            @endforeach
                        </ul>

                        <h3>Issues</h3>
                        <ul class="issues">
                            @foreach ($project['issues'] as $issue)
                                <li><a href="{{ $issue['html_url'] }}">{{ $issue['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>

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
                /* System Fonts as used by GitHub */
                background-color: #fff;
                color: #111;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                margin: 0;
            }

            .container {
                margin: 2em auto;
                max-width: 800px;
            }

            .title {
                font-size: 84px;
            }

            .m-b-sm {
                margin-bottom: 1rem;
            }

            .m-b-md {
                margin-bottom: 2rem;
            }

            .m-b-lg {
                margin-bottom: 3rem;
            }

            .p-b-md {
                padding-bottom: 2em;
            }

            .p-b-lg {
                padding-bottom: 3em;
            }

            [class^="border-"], [class*=" border-"] {
                border-width: 0;
                border-color: #333;
                border-style: solid;
            }

            .border-b {
                border-bottom-width: 1px;
            }

            .border-soft {
                border-color: #aaa;
            }

            .username {
                color: #8888cc;
                font-size: 0.9em;
                }

            .issue-label {
                color: #555;
                font-size: 0.75em;
                padding: 0.25em;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title m-b-md">
                    Ozzie - Tighten
                </div>

                <!-- summary -->

                <table border="1" cellpadding="3">
                    <tr>
                        <th>Project name</th>
                        <th>Open issues</th>
                        <th>Open pull requests</th>
                        <th>Old pull requests</th>
                    </tr>
                @foreach ($projects as $project)
                    <tr>
                        <td>
                            <a href="#project-{{ $project['namespace'] }}-{{ $project['name'] }}">
                                {{ $project['namespace'] }}/{{ $project['name'] }}
                            </a>
                        </td>
                        <td>
                            {{ count($project['issues']) }}
                        </td>
                        <td>
                            {{ count($project['prs']) }}
                        </td>
                        @php
                            $oldPrs = collect($project['prs'])->filter(function ($pr) {
                                $date = Carbon\Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $pr['created_at']);
                                return $date->diff(new DateTime)->days > 30;
                            })
                        @endphp
                        <td style="{{ $oldPrs->count() > 0 ? 'color: red; font-weight: bold; ' : ''}}">
                            {{ $oldPrs->count() }}
                        </td>
                    </li>
                @endforeach
                </table>

                <!-- full -->

                @foreach ($projects as $project)
                    <div class="m-b-lg p-b-md border-b border-soft">
                        <h2 id="project-{{ $project['namespace'] }}-{{ $project['name'] }}">{{ $project['namespace'] }} | {{ $project['name'] }}</h2>
                        <p>Maintained by <a href="https://github.com/{{ $project['maintainer'] }}">{{ $project['maintainer'] }}</a></p>

                        <h3>Pull Requests</h3>
                        <ul class="issues">
                            @foreach ($project['prs'] as $pr)
                                @php $pr['date'] = Carbon\Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $pr['created_at']) @endphp
                                <li class="m-b-sm"><a href="{{ $pr['html_url'] }}">{{ $pr['title'] }}</a><br>
                                    <a href="{{ $pr['user']['html_url'] }}" class="username">{{ '@' . $pr['user']['login'] }}</a>
                                    | <span style="{{ $pr['date']->diff(new DateTime)->days > 30 ? 'color: red; font-weight: bold; ' : ''}}">{{ $pr['date']->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <h3>Issues</h3>
                        <ul class="issues">
                            @foreach ($project['issues'] as $issue)
                                <li class="m-b-sm"><a href="{{ $issue['html_url'] }}">{{ $issue['title'] }}</a><br>
                                    <a href="{{ $issue['user']['html_url'] }}" class="username">{{ '@' . $issue['user']['login'] }}</a>
                                    @foreach ($issue['labels'] as $label)
                                        <a href="https://github.com/{{ $project['namespace'] }}/{{ $project['name'] }}/labels/{{ $label['name'] }}" class="issue-label" style="border: 1px solid #{{ $label['color'] }}">{{ $label['name'] }}</a>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>

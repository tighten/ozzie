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
            <div class="p-2">
                <section class="max-w-lg mx-auto">
                    <div class="flex justify-between items-center">
                        <p class="flex items-center">
                            <span class="text-5xl text-indigo font-montserrat">O</span>

                            <span class="uppercase text-2xl leading-normal text-black-light font-semibold font-open-sans tracking-wide">zzie</span>
                        </p>

                        <p class="italic font-thin leading-normal text-grey-blue-darkest">Addressing our open source debt</p>
                    </div>
                </section>
            </div>
        </div>

        <div class="bg-frost font-sans relative z-0">
            <div class="max-w-lg mx-auto py-8">
                <div class="flex items-center justify-between">
                    <p class="mb-6 text-black-lighter">Projects in descending order of "debt" (how much attention it needs)</p>

                    @if ($hacktoberfest)
                        <a href="https://github.com/search?o=desc&q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atightenco&s=created&type=Issues" target="_blank" class="mb-6 px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline rounded-lg text-black-lighter hover:text-white hover-pop">
                            Hacktoberfest is here! 👻
                        </a>
                    @endif
                </div>

                <div class="rounded-lg shadow">
                    <ul class="bg-grey-blue-light flex list-reset p-4 rounded-t-lg border-grey border-b-2">
                        <li class="w-2/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">project name</li>

                        <li class="w-1/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">debt score</li>

                        <li class="w-1/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">old prs</li>

                        <li class="w-1/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">old issues</li>

                        <li class="w-1/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">prs</li>

                        <li class="w-1/7 text-grey-darker font-semibold uppercase text-xs tracking-wide">issues</li>

                        @if ($hacktoberfest)
                            <li class="w-4 text-xs">🎃</li>
                        @endif
                    </ul>

                    <section class="bg-white rounded-b-lg">
                        @foreach ($projects->sortByDesc(function ($project) { return $project->debtScore(); }) as $project)
                            <ul class="flex list-reset p-4 border-t border-smoke">
                                <li class="w-2/7">
                                    <a class="text-indigo no-underline text-md" href="#project-{{ $project->namespace }}-{{ $project->name }}">
                                        {{ $project->namespace }}/{{ $project->name }}
                                    </a>
                                </li>

                                <li class="w-1/7 text-black-lightest">{{ number_format($project->debtScore(), 2) }}</li>

                                <li class="w-1/7 text-black-lightest">{{ $project->oldPrs()->count() }}</li>

                                <li class="w-1/7 text-black-lightest">{{ $project->oldIssues()->count() }}</li>

                                <li class="w-1/7 text-black-lightest">{{ $project->prs()->count() }}</li>

                                <li class="w-1/7 text-black-lightest">{{ $project->issues()->count() }}</li>

                                @if ($hacktoberfest)
                                    <li class="w-4">
                                        <a class="text-indigo no-underline" href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/hacktoberfest" target="_blank">
                                            {{ $project->hacktoberfestIssues()->count() }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>

                @foreach ($projects as $project)
                    <div class="mt-max">
                        <section class="flex justify-between items-center py-6 border-b-2 border-clouds" id="project-{{ $project->namespace }}-{{ $project->name }}">
                            <h2 class="w-1/2 text-black font-normal tracking-wide">
                                {{ $project->namespace }} | {{ $project->name }}
                            </h2>

                            <p class="w-1/2 text-right text-black-lightest">
                                Maintained by

                                @foreach ($project->maintainers as $maintainer)
                                    <a class="text-indigo no-underline" href="https://github.com/{{ $maintainer }}" target="_blank">{{ '@' . $maintainer }}</a>
                                @endforeach
                            </p>
                        </section>

                        <section class="flex items-start border-b border-clouds">
                            <h3 class="w-1/3 text-black-lightest py-6 font-thin">Pull Requests</h3>

                            <ul class="w-2/3 list-reset">
                                @foreach ($project->prs() as $pr)
                                    @php $pr['date'] = Carbon\Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $pr['created_at']) @endphp
                                    <li class="flex justify-between">
                                        <div class="py-6 w-auto">
                                            <p class="pb-2">
                                                <a class="text-black-lighter font-medium no-underline leading-normal" href="{{ $pr['html_url'] }}" target="_blank">{{ $pr['title'] }}</a>
                                            </p>

                                            <p>
                                                <a class="text-indigo no-underline" href="{{ $pr['user']['html_url'] }}" target="_blank">{{ '@' . $pr['user']['login'] }}</a>      |

                                                <span class="font-semibold text-grey-darkest">{{ $pr['date']->diffForHumans() }}</span>
                                            </p>
                                        </div>

                                        <div class="py-6 w-auto">
                                            <a class="no-underline" href="{{ $pr['html_url'] }}" target="_blank">
                                                @include('svg.launch')
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </section>

                        <section class="flex items-start border-b-1 border-clouds">
                            <h3 class="w-1/3 text-black-lightest py-6 font-thin">Issues</h3>

                            <ul class="w-2/3 list-reset">
                                @foreach ($project->issues() as $issue)
                                    <li class="flex justify-between">
                                        <div class="py-6 w-auto">
                                            <p class="pb-2">
                                                <a class="text-black-lighter font-medium no-underline leading-normal" href="{{ $issue['html_url'] }}" target="_blank">{{ $issue['title'] }}</a>
                                            </p>

                                            <p>
                                                <a class="text-indigo no-underline" href="{{ $issue['user']['html_url'] }}" target="_blank">
                                                    {{ '@' . $issue['user']['login'] }}
                                                </a>

                                                @foreach ($issue['labels'] as $label)
                                                    <a class="rounded-full py-1 px-2 mr-2 bg-grey-blue text-grey-blue-dark font-medium no-underline text-xs capitalize" href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/{{ $label['name'] }}" target="_blank">
                                                        {{ $label['name'] }}
                                                    </a>
                                                @endforeach
                                            </p>
                                        </div>

                                        <div class="py-6 w-auto">
                                            <a class="no-underline" href="{{ $issue['html_url'] }}" target="_blank">
                                                @include('svg.launch')
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </section>

                        <section class="flex flex-col items-end mt-6">
                            <a class="text-indigo no-underline" href="#">&#8593; Back to top</a>
                        </section>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>

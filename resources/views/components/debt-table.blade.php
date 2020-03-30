<div class="flex items-center justify-between">
    <p class="mb-6 text-black-lighter">Projects in descending order of "debt" (how much attention it needs)</p>

    @if ($hacktoberfest)
        <a href="https://github.com/search?o=desc&q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atightenco&s=created&type=Issues"
           target="_blank"
           class="mb-6 px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline rounded-lg text-black-lighter hover:text-white hover-pop">
            Hacktoberfest is here! 👻
        </a>
    @endif
</div>

<div class="rounded-lg shadow">
    <ul class="bg-grey-blue-light flex p-4 rounded-t-lg border-grey border-b-2">
        <li class="w-2/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Project Name</li>

        <li class="w-1/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Debt Score</li>

        <li class="w-1/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Old Prs</li>

        <li class="w-1/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Old Issues</li>

        <li class="w-1/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Prs</li>

        <li class="w-1/7 text-grey-darker font-bold uppercase text-xs leading-none tracking-wide">Issues</li>

        @if ($hacktoberfest)
            <li class="w-4 text-xs">🎃</li>
        @endif
    </ul>

    <section class="bg-white rounded-b-lg">
        @foreach ($projects->sortByDesc(function ($project) { return $project->debtScore(); }) as $project)
            <ul class="flex justify-between list-reset p-3 border-t border-smoke">
                <li class="w-2/7">
                    <a class="text-indigo no-underline text-md"
                       href="#project-{{ $project->namespace }}-{{ $project->name }}">
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
                        <a class="text-indigo no-underline"
                           href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/hacktoberfest"
                           target="_blank">
                            {{ $project->hacktoberfestIssues()->count() }}
                        </a>
                    </li>
                @endif
            </ul>
        @endforeach
    </section>
</div>

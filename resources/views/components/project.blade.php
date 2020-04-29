<section class="mt-16">

    {{--Project Header--}}
    <div class="flex flex-col">

        {{--Name / Maintainers--}}
        <div class="flex justify-between items-end"
            id="project-{{ $project->namespace }}-{{ $project->name }}">
            <h2 class="w-1/2 text-2xl text-black font-semibold tracking-wide">
                <a href="{{ $project->url() }}" aria-label="Launch">
                    {{ $project->namespace }} | {{ $project->name }}
                    @include('svg.launch')
                </a>
            </h2>

            <p class="w-1/2 text-right text-black-lightest">
                Maintained by

                @foreach ($project->maintainers as $maintainer)
                    <a class="text-indigo no-underline" href="https://github.com/{{ $maintainer }}"
                        target="_blank">{{ '@' . $maintainer }}</a>
                @endforeach
            </p>
        </div>

        {{--Debt stats--}}
        <div class="mt-4 rounded-lg shadow">
            <ul class="bg-grey-blue-light flex p-4 rounded-t-lg border-grey border-b-2">
                <li class="w-1/5 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Debt Score</li>

                <li class="w-1/5 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Old Prs</li>

                <li class="w-1/5 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Old Issues</li>

                <li class="w-1/5 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Prs</li>

                <li class="w-1/5 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Issues</li>
            </ul>

            <section class="bg-white rounded-b-lg">
                <ul class="flex justify-between list-reset p-3 border-t border-smoke">
                    <li class="w-1/5 text-black-lightest">{{ number_format($project->debtScore(), 2) }}</li>

                    <li class="w-1/5 text-black-lightest">{{ $project->oldPrs()->count() }}</li>

                    <li class="w-1/5 text-black-lightest">{{ $project->oldIssues()->count() }}</li>

                    <li class="w-1/5 text-black-lightest">{{ $project->prs()->count() }}</li>

                    <li class="w-1/5 text-black-lightest">{{ $project->issues()->count() }}</li>
                </ul>
            </section>
        </div>
    </div>

    {{--Pull Requests--}}
    <div class="flex items-start border-b border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Pull Requests</h3>

        <ul class="w-2/3">
            @foreach ($project->prs() as $pr)
                <x-pull-request :pr-data="$pr" :project="$project" />
            @endforeach
        </ul>
    </div>

    {{--Issues--}}
    <div class="flex items-start border-b-1 border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Issues</h3>

        <ul class="w-2/3 list-reset">
            @foreach ($project->issues() as $issue)
                <x-issue :issue="$issue" :project="$project" />
            @endforeach
        </ul>
    </div>

    <div class="flex flex-col items-end mt-6">
        <a class="text-indigo no-underline" href="#">&#8593; Back to top</a>
    </div>
</section>

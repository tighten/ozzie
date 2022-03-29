<div class="mt-16">
    <section class="flex items-center justify-between py-6 border-b-2 border-gray-300 dark:border-gray-700"
             id="project-{{ $project->namespace }}-{{ $project->name }}">
        <h2 class="w-1/2 text-2xl font-semibold tracking-wide text-gray-900">
            <a href="{{ $project->url() }}" aria-label="Launch">
                {{ $project->namespace }} | {{ $project->name }}
                @include('svg.launch')
            </a>
        </h2>

        @if ($project->maintainers)
            <p class="w-1/2 text-right text-gray-700 dark:text-gray-400">
                Maintained by

                @foreach ($project->maintainers as $maintainer)
                    <a class="text-indigo-600 no-underline" href="https://github.com/{{ $maintainer }}"
                       target="_blank">{{ '@' . $maintainer }}</a>
                @endforeach
            </p>
        @endif
    </section>


    <section class="flex items-start border-b border-gray-300 dark:border-gray-700">
        <h3 class="w-1/3 py-6 text-lg font-thin text-gray-700 dark:text-gray-400">Pull Requests</h3>

        <ul class="w-2/3">
            @foreach ($project->prs() as $pr)
                <x-pull-request :pr-data="$pr" :project="$project" />
            @endforeach
        </ul>
    </section>

    <section class="flex items-start border-gray-300 border-b-1 dark:border-gray-700">
        <h3 class="w-1/3 py-6 text-lg font-thin text-gray-700 dark:text-gray-400">Issues</h3>

        <ul class="w-2/3 list-reset">
            @foreach ($project->issues() as $issue)
                <x-issue :issue="$issue" :project="$project" />
            @endforeach
        </ul>
    </section>

    <section class="flex flex-col items-end mt-6">
        <a class="text-indigo-600 no-underline" href="#">&#8593; Back to top</a>
    </section>
</div>

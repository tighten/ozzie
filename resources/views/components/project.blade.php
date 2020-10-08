<div class="mt-16">
    <section class="flex justify-between items-center py-6 border-b-2 border-clouds"
             id="project-{{ $project->namespace }}-{{ $project->name }}">
        <h2 class="w-1/2 text-2xl text-black font-semibold tracking-wide">
            <a href="{{ $project->url() }}" aria-label="Launch">
                {{ $project->namespace }} | {{ $project->name }}
                @include('svg.launch')
            </a>
        </h2>

        @if($project->maintainers)
            <p class="w-1/2 text-right text-black-lightest">
                Maintained by

                @foreach ($project->maintainers as $maintainer)
                    <a class="text-indigo no-underline" href="https://github.com/{{ $maintainer }}"
                       target="_blank">{{ '@' . $maintainer }}</a>
                @endforeach
            </p>
        @endif
    </section>


    <section class="flex items-start border-b border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Pull Requests</h3>

        <ul class="w-2/3">
            @foreach ($project->prs() as $pr)
                <x-pull-request :pr-data="$pr" :project="$project" />
            @endforeach
        </ul>
    </section>

    <section class="flex items-start border-b-1 border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Issues</h3>

        <ul class="w-2/3 list-reset">
            @foreach ($project->issues() as $issue)
                <x-issue :issue="$issue" :project="$project" />
            @endforeach
        </ul>
    </section>

    <section class="flex flex-col items-end mt-6">
        <a class="text-indigo no-underline" href="#">&#8593; Back to top</a>
    </section>
</div>

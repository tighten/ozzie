<div class="mt-16">
    <section class="flex flex-col justify-between items-center py-6 border-b-2 border-clouds"
             id="project-{{ $project->namespace }}-{{ $project->name }}">
        <div class="w-full flex justify-between items-baseline">
            <div>
                <h2 class="text-2xl text-black font-semibold tracking-wide">
                    <a href="{{ $project->url() }}" aria-label="Launch">
                        {{ $project->namespace }} | {{ $project->name }}
                        @include('svg.launch')
                    </a>
                </h2>
            </div>

            <div class="text-right">
                <p class="text-black-lightest">
                    Maintained by

                    @foreach ($project->maintainers as $maintainer)
                        <a class="text-indigo no-underline" href="https://github.com/{{ $maintainer }}"
                        target="_blank">{{ '@' . $maintainer }}</a>
                    @endforeach
                </p>
            </div>
        </div>
        <div class="w-full flex justify-between text-sm font-thin text-grey-dark">
            <div>{{ $project->updatedAt() }}</div>
            <div class="text-right">{{ $downloads }}</div>
        </div>
    </section>


    <section class="flex items-start border-b border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-5 font-thin">Pull Requests</h3>

        <ul class="w-2/3">
            @forelse ($project->pull_requests as $pr)
                <x-pull-request :pr-data="$pr" :project="$project" />
            @empty
                <h3 class="w-1/3 text-lg text-black-lightest py-5 font-thin">✅ None</h3>
            @endforelse
        </ul>
    </section>

    <section class="flex items-start border-b-1 border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-5 font-thin">Issues</h3>

        <ul class="w-2/3 list-reset">
            @forelse ($project->issues as $issue)
                <x-issue :issue="$issue" :project="$project" />
            @empty
                <h3 class="w-1/3 text-lg text-black-lightest py-5 font-thin">✅ None</h3>
            @endforelse
        </ul>
    </section>

    <section class="flex flex-col items-end mt-6">
        <a class="text-indigo no-underline" href="#">&#8593; Back to top</a>
    </section>
</div>

<div class="mt-16">
    <section class="flex justify-between items-center py-6 border-b-2 border-clouds"
             id="{{ $project->namespace }}-{{ $project->name }}">
        <div class="w-1/2">
            <h2 class="text-2xl text-black font-semibold tracking-wide">
                <a href="{{ $project->url() }}" aria-label="Launch">
                    {{ $project->namespace }} | {{ $project->name }}
                    @include('svg.launch')
                </a>
            </h2>
            <div class="text-grey-dark font-thin">{{ $project->updatedAt() }}</div>
        </div>

        <p class="w-1/2 text-right text-black-lightest">
            Maintained by

            @foreach ($project->maintainers as $maintainer)
                <a class="text-indigo no-underline" href="https://github.com/{{ $maintainer }}"
                   target="_blank" rel="noopener noreferrer">{{ '@' . $maintainer }}</a>
            @endforeach
        </p>
    </section>


    <section class="flex items-start border-b border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Pull Requests</h3>

        <ul class="w-2/3">
            @forelse ($project->pull_requests as $pr)
                <x-pull-request :pr-data="$pr" :project="$project" />
            @empty
                <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">✅ None</h3>
            @endforelse
        </ul>
    </section>

    <section class="flex items-start border-b-1 border-clouds">
        <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Issues</h3>

        <ul class="w-2/3 list-reset">
            @forelse ($project->issues as $issue)
                <x-issue :issue="$issue" :project="$project" />
            @empty
                <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">✅ None</h3>
            @endforelse
        </ul>
    </section>

    <section class="flex flex-col items-end mt-6">
        <a class="text-indigo no-underline" href="#">&#8593; Back to top</a>
    </section>
</div>

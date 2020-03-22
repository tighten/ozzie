<li class="flex justify-between">
    <div class="py-6 w-auto">
        <p class="pb-1">
            <a class="text-black-lighter font-medium no-underline leading-normal"
               href="{{ $issue->html_url }}" target="_blank">{{ $issue->title }}</a>
        </p>

        <p>
            <a class="text-indigo no-underline" href="{{ $issue->user->html_url }}" target="_blank">
                {{ '@' . $issue->user->login }}
            </a>

            @foreach ($issue->labels as $label)
                <x-label :project-namespace="$project->namespace" :project-name="$project->name" :label="$label->name" />
            @endforeach
        </p>
    </div>

    <div class="py-6 w-auto">
        <a class="no-underline" href="{{ $issue->html_url }}" target="_blank">
            @include('svg.launch')
        </a>
    </div>
</li>

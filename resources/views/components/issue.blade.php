<li class="flex justify-between">
    <div class="py-6 w-auto">
        <p>
            <a class="text-black-lighter font-medium no-underline leading-normal"
               href="{{ $issue->html_url }}"
               target="_blank">
                {{ $issue->title }}
            </a>
        </p>

        <div class="">
            <a class="text-indigo no-underline" href="{{ $issue->user->html_url }}"
               target="_blank">
                {{ '@' . $issue->user->login }}
            </a>
            |
            <span class="font-semibold text-grey-darkest">
                {{ $issue->date->diffForHumans() }}
            </span>
            <div>
                @foreach ($issue->labels as $label)
                    <x-label :project-namespace="$project->namespace" :project-name="$project->name" :label="$label"/>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-6 w-auto">
        <a class="no-underline" href="{{ $issue->html_url }}" target="_blank" aria-label="Launch">
            @include('svg.launch')
        </a>
    </div>
</li>

<li class="flex justify-between">
    <div class="py-6 w-auto">
        <p>
            <a class="text-black-lighter font-medium no-underline leading-normal"
               href="{{ $prData->html_url }}"
               target="_blank">
                {{ $prData->title }}
            </a>
        </p>

        <div class="">
            <a class="text-indigo no-underline" href="{{ $prData->user->html_url }}"
               target="_blank">
                {{ '@' . $prData->user->login }}
            </a>
            |
            <span class="font-semibold text-grey-darkest">
                {{ $prData->date->diffForHumans() }}
            </span>
            <div>
                @foreach ($prData->labels as $label)
                    <x-label :project-namespace="$project->namespace" :project-name="$project->name" :label="$label"/>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-6 w-auto">
        <a class="no-underline" href="{{ $prData->html_url }}" target="_blank">
            @include('svg.launch')
        </a>
    </div>
</li>

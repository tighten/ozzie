<li class="flex justify-between">
    <div class="py-6 w-auto">
        <p>
            <a class="text-black-lighter font-medium no-underline leading-normal"
               href="{{ $issue->html_url }}"
               target="_blank" rel="noopener noreferrer">
                {{ $issue->title }}
            </a>
        </p>

        <div class="">
            <a class="text-indigo no-underline" href="{{ $issue->user->html_url }}"
               target="_blank" rel="noopener noreferrer">
                {{ '@' . $issue->user->login }}
            </a>
            |
            <span class="font-semibold text-grey-darkest">
                {{ $issue->created_at->diffForHumans() }}
            </span>
            <div>
                @foreach ($issue->labels as $label)
                    <x-label :project="$project" :label="$label"/>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-6 w-auto">
        <a class="no-underline" href="{{ $issue->html_url }}" target="_blank" rel="noopener noreferrer" aria-label="Launch">
            @include('svg.launch')
        </a>
    </div>
</li>

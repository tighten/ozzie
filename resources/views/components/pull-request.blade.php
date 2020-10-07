<li class="flex flex-col">
    <div class="flex justify-between">
        <div class="py-6 w-auto">
            <p>
                <a class="text-black-lighter font-medium no-underline leading-normal" href="{{ $prData->html_url }}"
                   target="_blank">
                    {{ $prData->title }}
                </a>
            </p>

            <div>
                <a class="text-indigo no-underline" href="{{ $prData->user->html_url }}" target="_blank">
                    {{ '@' . $prData->user->login }}
                </a>
                |
                <span class="font-semibold text-grey-darkest">
                    {{ $prData->created_at->diffForHumans() }}
                </span>
                <div>
                    @foreach ($prData->labels as $label)
                        <x-label :project="$project" :label="$label"></x-label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex h-10 py-6 w-auto">
            <div v-cloak>
                <modal-button  modal-id="{{ $prData->node_id }}"></modal-button>
            </div>
            <a class="no-underline" href="{{ $prData->html_url }}" target="_blank" aria-label="Launch">
                @include('svg.launch')
            </a>
        </div>
        <pr-modal project="{{$project->name}}" :pr="{{json_encode($prData->toArray())}}"></pr-modal>
    </div>
</li>

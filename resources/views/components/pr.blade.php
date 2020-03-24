<li class="flex flex-col">
    <div class="flex justify-between">
        <div class="py-6 w-auto">
            <p>
                <a class="text-black-lighter font-medium no-underline leading-normal" href="{{ $prData->html_url }}"
                   target="_blank">
                    {{ $prData->title }}
                </a>
            </p>

            <div class="">
                <a class="text-indigo no-underline" href="{{ $prData->user->html_url }}" target="_blank">
                    {{ '@' . $prData->user->login }}
                </a>
                |
                <span class="font-semibold text-grey-darkest">
                    {{ $prData->date->diffForHumans() }}
                </span>
                <div>
                    @foreach ($prData->labels as $label)
                        <x-label :project-namespace="$project->namespace" :project-name="$project->name"
                                 :label="$label"/>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex h-10 py-6 w-auto">
            <example-component modal-id="{{ $prData->node_id }}"></example-component>
            <a class="no-underline" href="{{ $prData->html_url }}" target="_blank">
                @include('svg.launch')
            </a>
        </div>
    </div>
    <modal name="{{ $prData->node_id }}" height="auto" width="800" :scrollable="true">
        <div class="flex flex-col p-2">
            <h3 class="text-4xl text-black-lighter font-medium leading-none">
                {{ $prData->title }}
                <span class="ml-2 text-3xl text-grey-dark font-normal">#{{ $prData->number }}</span>
            </h3>
            <p class="mt-1 text-black-lighter">
                <span class="font-semibold text-black-light">{{ $prData->user->login }}</span>
                wants to merge into
                <span class="font-semibold font-mono text-black-lighter">{{ $prData->base->label }}</span>
                from
                <span class="font-semibold font-mono text-black-lighter">{{ $prData->head->label }}</span>
            </p>
            <div class="mt-4 flex items-center text-black-lighter @if(! empty($prData->body)) border-b border-grey-blue-light pb-4 @endif">
                <a class="flex items-center" href="{{ $prData->html_url }}" target="_blank">
                    <svg class="mr-1 h-6 w-6 inline" viewBox="0 0 16 16" version="1.1" width="128" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M15 1H6c-.55 0-1 .45-1 1v2H1c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h1v3l3-3h4c.55 0 1-.45 1-1V9h1l3 3V9h1c.55 0 1-.45 1-1V2c0-.55-.45-1-1-1zM9 11H4.5L3 12.5V11H1V5h4v3c0 .55.45 1 1 1h3v2zm6-3h-2v1.5L11.5 8H6V2h9v6z"></path>
                    </svg>
                    <span class="text-indigo">Conversation</span>
                </a>
                <a class="ml-8 flex items-center" href="{{ $prData->html_url }}/commits" target="_blank">
                    <svg class="mr-1 h-6 w-6 inline" viewBox="0 0 14 16" version="1.1" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M10.86 7c-.45-1.72-2-3-3.86-3-1.86 0-3.41 1.28-3.86 3H0v2h3.14c.45 1.72 2 3 3.86 3 1.86 0 3.41-1.28 3.86-3H14V7h-3.14zM7 10.2c-1.22 0-2.2-.98-2.2-2.2 0-1.22.98-2.2 2.2-2.2 1.22 0 2.2.98 2.2 2.2 0 1.22-.98 2.2-2.2 2.2z"></path>
                    </svg>
                    <span class="text-indigo">Commits</span>
                </a>
                <a class="ml-8 flex items-center" href="{{ $prData->html_url }}/files" target="_blank">
                    <svg class="mr-1 h-6 w-6 inline" viewBox="0 0 13 16" version="1.1" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M6 7h2v1H6v2H5V8H3V7h2V5h1v2zm-3 6h5v-1H3v1zM7.5 2L11 5.5V15c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h6.5zM10 6L7 3H1v12h9V6zM8.5 0H3v1h5l4 4v8h1V4.5L8.5 0z"></path>
                    </svg>
                    <span class="text-indigo">Files changed</span>
                </a>
            </div>
            @if(! empty($prData->body))
            <div class="markdown-body mt-4 bg-white rounded">
                {!! $prData->body !!}
            </div>
            @endif
        </div>
    </modal>
</li>

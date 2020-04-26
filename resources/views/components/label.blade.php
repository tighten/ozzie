<a class="mt-1 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-open-sans font-semibold no-underline leading-none text-xs capitalize rounded-lg"
   href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/{{ $label->name }}"
   target="_blank">
    <span class="rounded-full w-3 h-3" style="{{ 'background-color: #' . $label->color }}"></span>
    <span class="ml-1">{{ $label->name }}</span>
</a>

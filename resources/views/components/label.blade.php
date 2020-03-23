<a class="mt-1 inline-flex items-center px-2 py-2 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-dark font-open-sans font-semibold no-underline leading-none text-xs capitalize rounded"
   href="https://github.com/{{ $projectNamespace }}/{{ $projectName }}/labels/{{ $label->name }}"
   target="_blank">
    <span class="rounded-full w-3 h-3" style="{{ 'background-color: #' . $label->color }}"></span>
    <span class="ml-1">{{ $label->name }}</span>
</a>

<div>
    <div class="mb-2 py-4 flex justify-between items-end leading-none">
        <select class="p-2 rounded-lg shadow focus:outline-none"
            wire:model="selectedMaintainer">
            <option value="0">All</option>
            @foreach($maintainers as $maintainer)
                <option
                    @if($selectedMaintainer === $maintainer) selected @endif
                    value="{{ $maintainer }}">{{ '@' . $maintainer }}</option>
            @endforeach
        </select>
        <label wire:key="debt_table" for="debt-table" class="block text-gray-500 font-bold">
            <input class="mr-2 leading-tight"
                wire:change="$emit('toggleInlineDebtTable')"
                @if($inlineDebtTable) checked @endif
                id="debt-table"
                type="checkbox">
            <span class="text-sm">
                Inline project stats
            </span>
        </label>
    </div>

    @if(! $inlineDebtTable)
        <div class="flex items-center justify-between">
            <p class="mb-6 text-black-lighter">Projects in descending order of "debt" (how much attention it needs)</p>

            @if ($hacktoberfest)
                <a href="https://github.com/search?o=desc&q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atightenco&s=created&type=Issues"
                    target="_blank"
                    class="mb-6 px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline rounded-lg text-black-lighter hover:text-white hover-pop">
                    Hacktoberfest is here! 👻
                </a>
            @endif
        </div>
        <div class="rounded-lg shadow">
            <ul class="bg-grey-blue-light flex p-4 rounded-t-lg border-grey border-b-2">
                <li class="w-2/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Project Name</li>

                <li class="w-1/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Debt Score</li>

                <li class="w-1/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Old Prs</li>

                <li class="w-1/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Old Issues</li>

                <li class="w-1/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Prs</li>

                <li class="w-1/7 text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide">Issues</li>

                @if ($hacktoberfest)
                    <li class="w-4 text-xs">🎃</li>
                @endif
            </ul>

            <section class="bg-white rounded-b-lg">
                @foreach ($projects as $project)
                    <ul class="flex justify-between list-reset p-3 border-t border-smoke">
                        <li class="w-2/7">
                            <a class="text-indigo no-underline text-md"
                                href="#project-{{ $project->namespace }}-{{ $project->name }}">
                                {{ $project->namespace }}/{{ $project->name }}
                            </a>
                        </li>

                        <li class="w-1/7 text-black-lightest">{{ number_format($project->debtScore(), 2) }}</li>

                        <li class="w-1/7 text-black-lightest">{{ $project->oldPrs()->count() }}</li>

                        <li class="w-1/7 text-black-lightest">{{ $project->oldIssues()->count() }}</li>

                        <li class="w-1/7 text-black-lightest">{{ $project->prs()->count() }}</li>

                        <li class="w-1/7 text-black-lightest">{{ $project->issues()->count() }}</li>

                        @if ($hacktoberfest)
                            <li class="w-4">
                                <a class="text-indigo no-underline"
                                    href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/hacktoberfest"
                                    target="_blank">
                                    {{ $project->hacktoberfestIssues()->count() }}
                                </a>
                            </li>
                        @endif
                    </ul>
                @endforeach
            </section>
        </div>
    @endif

    @foreach ($projects as $project)
        <x-project :project="$project" :inlineDebt="$inlineDebtTable"/>
    @endforeach
</div>

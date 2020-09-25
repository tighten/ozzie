<div class="flex items-center justify-between">
    <p class="mb-6 text-black-lighter">Projects in descending order of "debt" (how much attention it needs)</p>

    @if ($hacktoberfest)
        <a href="https://github.com/search?o=desc&q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atighten&s=created&type=Issues"
           target="_blank"
           class="mb-6 px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline rounded-lg text-black-lighter hover:text-white hover-pop">
            Hacktoberfest is here! 👻
        </a>
    @endif
</div>

<div class="overflow-x-auto max-w-full">
<table class="table-auto rounded-lg shadow w-full">
    <thead class="bg-grey-blue-light border-grey border-b-2 text-left">
        <tr>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Project Name</th>

            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Debt Score</th>

            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Old PRs</th>

            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Old Issues</th>

            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">PRs</th>

            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Issues</th>

            @if ($hacktoberfest)
                <th class="text-xs p-4">🎃</th>
            @endif
        </tr>
    </thead>

    <tbody class="bg-white rounded-b-lg">
        @foreach ($projects->sortByDesc(function ($project) { return $project->debtScore(); }) as $project)
            <tr class="border-t border-smoke">
                <td class="p-4">
                    <a class="text-indigo no-underline text-md p-2 -mx-2"
                       href="#project-{{ $project->namespace }}-{{ $project->name }}">
                        {{ $project->namespace }}/{{ $project->name }}
                    </a>
                </td>

                <td class="text-black-lightest p-4">{{ number_format($project->debtScore(), 2) }}</td>

                <td class="text-black-lightest p-4">{{ $project->oldPullRequests()->count() }}</td>

                <td class="text-black-lightest p-4">{{ $project->oldIssues()->count() }}</td>

                <td class="text-black-lightest p-4">{{ $project->pull_requests_count }}</td>

                <td class="text-black-lightest p-4">{{ $project->issues_count }}</td>

                @if ($hacktoberfest)
                    <td class="p-4">
                        <a class="text-indigo no-underline p-2 -mx-2"
                           href="https://github.com/{{ $project->namespace }}/{{ $project->name }}/labels/hacktoberfest"
                           target="_blank">
                            {{ $project->hacktoberfestIssues()->count() }}
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
</div>

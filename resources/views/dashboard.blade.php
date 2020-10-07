<x-layout>
    <x-debt-table :projects="$projects" :hacktoberfest="$hacktoberfest"/>

    @unless ($paginated)
        @foreach ($projects as $project)
            <x-project :project="$project" />
        @endforeach
    @endunless
</x-layout>

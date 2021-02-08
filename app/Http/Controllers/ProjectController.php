<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    public function index()
    {

        //            $sparkline = new Sparkline();
        //                        $sparkline->setData($project->getDebtScoreHistory());
        //                    <img src="data:image/jpeg;base64, {{ $sparkline->toBase64() }}" />

        $projects = Project::all()->map(
            fn(Project $project) => $this->projectData(
                $project,
                [
                    'prCount' => $project->pull_requests_count,
                    'hacktoberfestIssues' => $project->hacktoberfestIssues()->count(),
                ]
            )
        )->sortByDesc(
            fn($project) => $project['debtScore']
        )->values();

        return inertia(
            'Projects/Index',
            [
                'projects' => $projects,
                'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
            ]
        );
    }

    public function show(string $namespace, string $name)
    {
        $project = Project::where('namespace', $namespace)->where('name', $name)->firstOrFail();

        return inertia(
            'Projects/Show',
            [
                'project' => $this->projectData(
                    $project,
                    [
                        'pullRequestCount' => $project->pull_requests_count,
                        'url' => $project->url(),
                        'prs' => $project->pull_requests,
                        'issues' => $project->issues,
                        'maintainers' => $project->maintainers,
                    ]
                ),
            ]
        );
    }

    private function projectData(Project $project, array $overrides = []): array
    {
        $default = [
            'namespace' => $project->namespace,
            'name' => $project->name,
            'debtScore' => number_format($project->debtScore(), 2),
            'oldIssueCount' => $project->oldIssues()->count(),
            'issueCount' => $project->issues_count,
            'oldPrCount' => $project->oldPullRequests()->count(),
        ];

        return array_merge($default, $overrides);
    }
}

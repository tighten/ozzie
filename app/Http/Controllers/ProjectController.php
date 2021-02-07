<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return inertia(
            'Projects/Index',
            [
                'projects' => $projects->map(
                    fn(Project $project) => [
                        'namespace' => $project->namespace,
                        'name' => $project->name,
                        'debtScore' => number_format($project->debtScore(), 2),
                        'oldIssueCount' => $project->oldIssues()->count(),
                        'issueCount' => $project->issues_count,
                        // FIXME change key to oldPullRequestCount
                        'oldPrCount' => $project->oldPullRequests()->count(),
                        'prCount' => $project->pull_requests_count,
                        'hacktoberfestIssues' => $project->hacktoberfestIssues()
                            ->count(),
                    ]
                )->sortByDesc(
                    fn($project) => $project['debtScore']
                )->values(),
                'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
            ]
        );
    }

    public function show(Project $project, $namespace, $name)
    {
        $project = $project->where('namespace', $namespace)->where('name', $name)->firstOrFail();
        return inertia(
            'Projects/Show',
            [
                'project' => [
                    'namespace' => $project->namespace,
                    'name' => $project->name,
                    'debtScore' => number_format($project->debtScore(), 2),
                    'oldIssueCount' => $project->oldIssues()->count(),
                    'issueCount' => $project->issues_count,
                    'oldPrCount' => $project->oldPullRequests()->count(),
                    // FIXME change key to oldPullRequestCount
                    'pullRequestCount' => $project->pull_requests_count,
                    'url' => $project->url(),
                    'prs' => $project->pull_requests,
                    'issues' => $project->issues,
                    'maintainers' => $project->maintainers,
                ],
            ]
        );
    }
}

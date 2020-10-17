<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = collect((new Projects)->all())->map(
            fn($project) => [
                'namespace' => $project->namespace,
                'name' => $project->name,
                'debtScore' => $project->debtScore(),
                'oldIssueCount' => $project->oldIssues()->count(),
                'issueCount' => $project->issues()->count(),
                'oldPrCount' => $project->oldPrs()->count(),
                'prCount' => $project->prs()->count(),
                'hacktoberfestIssues' => $project->hacktoberfestIssues()
                    ->count(),
            ]
        )->sortByDesc(function ($project) {
            return $project['debtScore'];
        })->values();

        $isHacktober = Carbon::now()->isSameMonth(Carbon::parse('October'));

        return inertia('Projects/Index', [
            'projects' => $projects,
            'hacktoberfest' => $isHacktober,
        ]);
    }

    public function show()
    {
        $project = collect((new Projects)->all())->filter(
            fn($project) =>
                $project->namespace === request('namespace') &&
                $project->name === request('name')
        )->map(
            fn($project) => [
                'namespace' => $project->namespace,
                'name' => $project->name,
                'url' => $project->url(),
                'debtScore' => $project->debtScore(),
                'oldIssueCount' => $project->oldIssues()->count(),
                'issueCount' => $project->issues()->count(),
                'oldPrCount' => $project->oldPrs()->count(),
                'prCount' => $project->prs()->count(),
                'prs' => $project->prs(),
                'issues' => $project->issues(),
                'maintainers' => $project->maintainers,
            ]
        )->first();

        return inertia('Projects/Show', [
            'project' => $project,
        ]);
    }
}

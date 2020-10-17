<?php

namespace App\Http\Controllers;

class PullRequestController extends Controller
{
    public function show()
    {
        return inertia('PullRequest/Show', [
            'project' => request('project'),
            'pr' => request('pr'),
        ]);
    }
}

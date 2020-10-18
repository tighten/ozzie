<?php

namespace App\Http\Controllers;

class IssueController extends Controller
{
    public function show()
    {
        return inertia('Issue/Show', [
            'project' => request('project'),
            'issue' => request('issue'),
        ]);
    }
}

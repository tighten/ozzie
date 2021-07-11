<?php

namespace App\Http\Controllers;

use App\Cache\CachedIssue;

class PullRequestController extends Controller
{
    public function show(string $vendor, string $name, int $id)
    {
        return inertia('PullRequest/Show', app(CachedIssue::class)($vendor, $name, 'pullRequest', $id));
    }
}

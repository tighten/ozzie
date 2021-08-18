<?php

namespace App\Http\Controllers;

use App\Cache\CachedIssue;

class IssueController extends Controller
{
    public function show(string $vendor, string $name, int $id)
    {
        return inertia('Issue/Show', app(CachedIssue::class)($vendor, $name, 'issue', $id));
    }
}

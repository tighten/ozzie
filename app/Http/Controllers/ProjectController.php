<?php

namespace App\Http\Controllers;

use App\Cache\CachedProjectList;
use App\Cache\CachedProjectResource;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Projects/Index', app(CachedProjectList::class)());
    }

    public function show(string $vendor, string $name)
    {
        return inertia('Projects/Show', [
            'project' => app(CachedProjectResource::class)("{$vendor}/{$name}"),
        ]);
    }
}

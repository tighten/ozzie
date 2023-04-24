<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    public function show(string $vendor, string $name)
    {
        // @todo Re-work using explicit route model binding
        $project = Project::forPackagist($vendor, $name)->firstOrFail();

        return new ProjectResource($project);
    }
}

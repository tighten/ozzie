<?php

namespace App\Http\Controllers;

use App\Projects;

class ProjectController extends Controller
{
    public function show(string $namespace, string $name)
    {
        $project = (new Projects)->find($namespace, $name);

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}

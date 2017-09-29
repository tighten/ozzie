<?php

use GrahamCampbell\GitHub\Facades\GitHub;

Route::get('/', function () {
    $projects = [
        ['name' => 'giscus', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'gistlog', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'mailthief', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'collect', 'namespace' => 'tightenco', 'maintainer' => 'besologic'],
        ['name' => 'jigsaw', 'namespace' => 'tightenco', 'maintainer' => 'damiani'],
        ['name' => 'symposium', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'confomo', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'quicksand', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'lambo', 'namespace' => 'tightenco', 'maintainer' => 'mattstauffer'],
        ['name' => 'torch', 'namespace' => 'mattstauffer', 'maintainer' => 'mattstauffer'],
    ];

    $projects = collect($projects)->map(function ($project) {
        $project['issues'] = Github::issues()->all($project['namespace'], $project['name']);
        $project['prs'] = Github::pullRequests()->all($project['namespace'], $project['name']);
        return $project;
    });

    return view('dashboard')->with('projects', $projects);
});

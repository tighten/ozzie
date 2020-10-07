<?php

use App\Projects;
use Illuminate\Support\Facades\Http;

Route::get('/', 'DashboardController@show');

Route::get('project/{name}/{node_id}/markdown', function ($name, $nodeId){

    $project = collect(app(Projects::class)->all())->filter(function($project) use ($name){
        return $project->name === $name;
    })->first();

    $markdown = collect($project->prs())->filter(function($project) use ($nodeId) {
        return $project->node_id === $nodeId;
    })->first()->body;

    return Http::post('https://api.github.com/markdown', ['text' => $markdown]);
});

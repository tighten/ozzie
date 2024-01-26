<?php

use App\Models\Project;
use Inertia\Testing\AssertableInertia;

it('renders homepage', function () {
    $this
        ->get('/')
        ->assertStatus(200)
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Projects/Index')
                ->has('projects')
                ->has('hacktoberfest')
                ->has('organization'),
        );
});

it('renders project', function () {

    $project = Project::factory()->create();

    $this->get(route('projects.show', [$project->namespace, $project->name]))
        ->assertStatus(200)
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Projects/Show')
                ->has('project')
        );
});

it('fails to render project', function () {
    $this->get(route('projects.show', ['does', 'not-exist']))
        ->assertStatus(404);
});

it('renders project issues', function () {

    $project = Project::factory()->withIssues([['number' => $issue = 1]])->create();

    $this->get(route('issue.show', [$project->namespace, $project->name, $issue]))
        ->assertStatus(200)
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Issue/Show')
                ->has('project')
                ->has('issue')
                ->has('body')
        );
});

it('renders project prs', function () {

    $project = Project::factory()->withPrs([['number' => $pr = 1]])->create();

    $this->get(route('pull-request.show', [$project->namespace, $project->name, $pr]))
        ->assertStatus(200)
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('PullRequest/Show')
                ->has('project')
                ->has('issue')
                ->has('body')
        );
});

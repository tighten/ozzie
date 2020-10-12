<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;
use IssueFactory;

$factory->define(Project::class, function (Faker $faker) {
    $namespace = $faker->domainWord;
    $name = $faker->slug(3);

    return [
        'namespace' => $namespace,
        'name' => $name,
        'maintainers' => Arr::random([$faker->userName, $faker->userName, $faker->userName], mt_rand(1, 3)),
        'issues_count' => mt_rand(0, 20),
        'pull_requests_count' => mt_rand(0, 20),
        'issues' => app(IssueFactory::class)->onRepo($namespace, $name),
        'pull_requests' => 'xxxxx',
    ];
});

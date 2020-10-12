<?php

use Faker\Generator as Faker;
use Illuminate\Support\Arr;

class IssueFactory
{
    public $createdAt;
    public $htmlUrl;
    public $labels = [];
    public $pullRequest;
    public $title;
    public $user;

    protected $faker;

    public function __construct(Faker $faker)
    {
       $this->faker = $faker;

        // Set some defaults
        $this->createdAt = $faker->dateTimeThisMonth()->format('Y-m-d\TH:i:s\Z');
        $this->title = $faker->sentence;
        $this->onRepo();
        $this->byUser();
        $this->withLabels();
    }

    public function onRepo($namespace = null, $name = null)
    {
        if (! $namespace) {
            $namespace = $this->faker->domainWord;
        }

        if (! $name) {
            $name = $this->faker->slug;
        }

        $this->htmlUrl = "https://github.com/{$namespace}/{$name}/issues/{$this->faker->randomNumber(3)}";
    }

    public function withLabels($labels = null)
    {
        if ($labels) {
            $this->labels = $labels;
        } else {
            $this->labels = Arr::random([
                ['name' => 'bug', 'color' => 'ee0701'],
                ['name' => 'duplicate', 'color' => 'cccccc'],
                ['name' => 'enhancement', 'color' => '84b6eb'],
                ['name' => 'help wanted', 'color' => '128A0C'],
                ['name' => 'invalid', 'color' => 'e6e6e6'],
                ['name' => 'question', 'color' => 'cc317c'],
                ['name' => 'wontfix', 'color' => 'ffffff'],
            ], mt_rand(1, 2));
        }

        return $this;
    }

    public function byUser($username = null)
    {
        if (! $username) {
            $username = $this->faker->userName;
        }

        $this->user = [
            'html_url' => "https://github.com/{$username}",
            'login' => $username,
        ];

        return $this;
    }

    public function create()
    {
        return [
            'created_at' => $this->createdAt,
            'html_url' => $this->htmlUrl,
            'labels' => $this->labels,
            'pullRequest' => $this->pullRequest,
            'title' => $this->title,
            'user' => $this->user,
        ];
    }
}

<?php

namespace App\Remotes\Packagist;

use App\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Search
{
    protected $namespace;
    protected $name;
    protected $packagistName;
    protected $repoUrl;
    protected $url;

    public function __construct($namespace, $name)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->repoUrl = "https://github.com/{$namespace}/{$name}";
        $this->url = "https://packagist.org/search.json?q={$namespace}&per_page=100";

        $this->findPackage();
    }

    public static function forPackageByRepo(Project $project): self
    {
        return new self($project->namespace, $project->name);
    }

    protected function findPackage()
    {
        $packages = Cache::remember("packagist-search::{$this->namespace}-{$this->name}", config('cache.timeout'), function () {
            $response = Http::get($this->url);

            if ($response->ok()) {
                return $response->collect('results');
            }

            return collect();
        });

        // Loop over packages and find the one with the matching repo
        $package = $packages->first(function ($package) {
            return $package['repository'] === $this->repoUrl;
        });

        $this->packagistName = Arr::get($package, 'name');
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }
}

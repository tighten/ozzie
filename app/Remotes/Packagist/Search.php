<?php

namespace App\Remotes\Packagist;

use App\Models\Project;
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

    /**
     * False when Packagist couldn't be reached, so callers can tell "this project
     * isn't on Packagist" apart from "we weren't able to find out".
     */
    protected $searchOk = true;

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

    public static function url(string $package): string
    {
        return "https://packagist.org/packages/{$package}.json";
    }

    /**
     * Returns true/false, or null if Packagist couldn't tell us either way.
     */
    public static function packageExists(string $package): ?bool
    {
        $response = Http::get(static::url($package));

        if ($response->ok()) {
            return true;
        }

        if ($response->notFound()) {
            return false;
        }

        return null;
    }

    protected function findPackage()
    {
        $key = "packagist-search::{$this->namespace}-{$this->name}";

        if (Cache::has($key)) {
            $packages = Cache::get($key);
        } else {
            $packages = collect();
            $url = $this->url;

            while ($url) {
                $response = Http::get($url);

                if (! $response->ok()) {
                    // Don't cache a partial result, and don't let it be read as
                    // "this project isn't on Packagist".
                    $this->searchOk = false;

                    return;
                }

                $packages = $packages->merge($response->collect('results'));
                $url = $response->json('next');
            }

            Cache::put($key, $packages, config('cache.timeout'));
        }

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

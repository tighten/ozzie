<?php

namespace App\Remotes\Npm;

use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Search
{
    protected $namespace;

    protected $name;

    protected $npmName;

    /**
     * False when npm couldn't be reached, so callers can tell "this project
     * isn't on npm" apart from "we weren't able to find out".
     */
    protected $searchOk = true;

    public function __construct($namespace, $name)
    {
        $this->namespace = $namespace;
        $this->name = $name;

        $this->findPackage();
    }

    public static function forPackageByRepo(Project $project): self
    {
        return new self($project->namespace, $project->name);
    }

    public static function url(string $package): string
    {
        return 'https://registry.npmjs.org/' . $package;
    }

    /**
     * Returns true/false, or null if npm couldn't tell us either way.
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

    /**
     * npm has no way to search by repository, so we check the names this repo
     * would plausibly be published under and confirm each one points back here.
     */
    protected function candidates(): array
    {
        return [
            $this->name,
            "@{$this->namespace}/{$this->name}",
        ];
    }

    protected function findPackage()
    {
        $cached = Cache::remember("npm-search::{$this->namespace}-{$this->name}", config('cache.timeout'), function () {
            foreach ($this->candidates() as $candidate) {
                $response = Http::get(static::url($candidate));

                if ($response->notFound()) {
                    continue;
                }

                if (! $response->ok()) {
                    return ['name' => null, 'searchOk' => false];
                }

                if ($this->repositoryMatches($response->json())) {
                    return ['name' => $response->json('name', $candidate), 'searchOk' => true];
                }
            }

            return ['name' => null, 'searchOk' => true];
        });

        $this->npmName = $cached['name'];
        $this->searchOk = $cached['searchOk'];
    }

    /**
     * A package name alone isn't proof: plenty of npm packages share a name with
     * an unrelated repo, so only trust one that points back at this repository.
     */
    protected function repositoryMatches($package): bool
    {
        $repository = Arr::get($package, 'repository');
        $repository = is_array($repository) ? Arr::get($repository, 'url') : $repository;

        if (! is_string($repository)) {
            return false;
        }

        $repository = Str::lower($repository);
        $repo = Str::lower("{$this->namespace}/{$this->name}");

        return Str::contains($repository, ["github.com/{$repo}", "github:{$repo}"]);
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }
}

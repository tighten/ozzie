<?php

namespace App\Remotes\Packagist;

use App\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Project
{
    public $downloads;
    public $monthly = 0;
    public $total = 0;

    protected $url;

    public function __construct($namespace, $name)
    {
        $this->url = "https://packagist.org/packages/{$namespace}/{$name}.json";
    }

    public static function make(Project $project)
    {
        return new self(... explode('/', $project->packagist_name));
    }

    public function fetchDownloads()
    {
        $response = Http::get($this->url);

        if ($response->ok()) {
            $this->downloads = Arr::get($response->json(), 'package.downloads', 0);

            $this->monthly = $this->downloads['monthly'];
            $this->total = $this->downloads['total'];
        }

        return $this;
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }
}

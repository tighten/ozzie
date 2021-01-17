<?php

namespace App\Remotes\Packagist;

use App\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Package
{
    public $downloadsData;
    public $monthly = 0;
    public $total = 0;

    protected $url;

    public function __construct($namespace, $name)
    {
        $this->url = "https://packagist.org/packages/{$namespace}/{$name}.json";

        $this->fetchDownloads();
    }

    public static function fromProject(Project $project): self
    {
        return new self(... explode('/', $project->packagist_name));
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }

    protected function fetchDownloads()
    {
        $response = Http::get($this->url);

        if ($response->ok()) {
            $this->downloadsData = Arr::get($response->json(), 'package.downloads', 0);
            $this->monthly_downloads = $this->downloadsData['monthly'];
            $this->total_downloads = $this->downloadsData['total'];
        }
    }
}

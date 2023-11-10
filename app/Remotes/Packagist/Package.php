<?php

namespace App\Remotes\Packagist;

use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Package
{
    public $downloadsData;

    public $monthlyDownloads = 0;

    public $totalDownloads = 0;

    public $requestOk = false;

    protected $url;

    public function __construct($namespace, $name)
    {
        $this->url = "https://packagist.org/packages/{$namespace}/{$name}.json";

        $this->fetchDownloads();
    }

    public static function fromProject(Project $project): self
    {
        return new self(...explode('/', $project->packagist_name));
    }

    protected function fetchDownloads()
    {
        $response = Http::get($this->url);

        report_if(
            $response->serverError(),
            "HTTP Error: Was unable to fetch from packagist {$this->url}"
        );

        if ($response->ok()) {
            $this->requestOk = true;
            $this->downloadsData = Arr::get($response->json(), 'package.downloads', 0);
            $this->monthlyDownloads = $this->downloadsData['monthly'];
            $this->totalDownloads = $this->downloadsData['total'];
        }
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }
}

<?php

namespace App\Remotes\Packagist;

use App\Models\FetchResult;
use App\Models\Project;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Package
{
    const RETRY_ATTEMPTS = 2;

    const RETRY_DELAY_MS = 500;

    public $downloadsData;

    public $monthlyDownloads = 0;

    public $totalDownloads = 0;

    public $requestOk = false;

    protected $url;

    protected $package;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;

        [$namespace, $name] = explode('/', $this->project->packagist_name);

        $this->url = "https://packagist.org/packages/{$namespace}/{$name}.json";

        $this->fetchDownloads();
    }

    public static function fromProject(Project $project): self
    {
        return new self($project);
    }

    protected function fetchDownloads()
    {
        try {
            // Despite setting throw: false, if all attempts have a ConnectionException,
            // that exception will still be thrown (hence, try/catch)
            $response = Http::retry(self::RETRY_ATTEMPTS, self::RETRY_DELAY_MS, function ($exception, $request) {
                return $exception instanceof ConnectionException || $exception instanceof RequestException;
            }, throw: false)->get($this->url);

            report_if(
                $response->serverError(),
                "HTTP Error: Was unable to fetch from packagist {$this->url}"
            );
        } catch (ConnectionException|RequestException $e) {
            report($e);

            FetchResult::packagistFail($this->project);

            return;
        }

        if ($response->ok()) {
            $this->requestOk = true;
            $this->downloadsData = Arr::get($response->json(), 'package.downloads', 0);
            $this->monthlyDownloads = $this->downloadsData['monthly'];
            $this->totalDownloads = $this->downloadsData['total'];

            FetchResult::packagistSuccess($this->project);
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

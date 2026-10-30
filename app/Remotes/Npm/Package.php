<?php

namespace App\Remotes\Npm;

use App\Models\FetchResult;
use App\Models\Project;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Package
{
    const RETRY_ATTEMPTS = 2;

    const RETRY_DELAY_MS = 500;

    // npm's download counts don't go back any further than this.
    const DOWNLOADS_START_DATE = '2015-01-10';

    public $monthlyDownloads = 0;

    public $totalDownloads = 0;

    public $requestOk = false;

    public $packageMissing = false;

    protected $project;

    protected $package;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->package = $project->npm_name;

        $this->fetchDownloads();
    }

    public static function fromProject(Project $project): self
    {
        return new self($project);
    }

    public function url(string $period): string
    {
        return "https://api.npmjs.org/downloads/point/{$period}/{$this->package}";
    }

    protected function fetchDownloads()
    {
        $monthly = $this->get($this->url('last-month'));

        if (is_null($monthly)) {
            return;
        }

        $total = $this->get($this->url(self::DOWNLOADS_START_DATE . ':' . now()->format('Y-m-d')));

        if (is_null($total)) {
            return;
        }

        $this->requestOk = true;
        $this->monthlyDownloads = $monthly;
        $this->totalDownloads = $total;

        FetchResult::npmSuccess($this->project);
    }

    /**
     * Returns the download count, or null if we couldn't read one.
     */
    protected function get(string $url): ?int
    {
        try {
            // Despite setting throw: false, if all attempts have a ConnectionException,
            // that exception will still be thrown (hence, try/catch)
            $response = Http::retry(self::RETRY_ATTEMPTS, self::RETRY_DELAY_MS, function ($exception, $request) {
                return $exception instanceof ConnectionException || $exception instanceof RequestException;
            }, throw: false)->get($url);
        } catch (ConnectionException|RequestException $e) {
            report($e);

            FetchResult::npmFail($this->project);

            return null;
        }

        // A 404 here isn't an error worth reporting: it just means this project
        // isn't published to npm under the name we have for it.
        if ($response->notFound()) {
            $this->packageMissing = true;

            FetchResult::npmFail($this->project);

            return null;
        }

        report_if(
            $response->serverError(),
            "HTTP Error: Was unable to fetch from npm {$url}"
        );

        if (! $response->ok()) {
            FetchResult::npmFail($this->project);

            return null;
        }

        return $response->json('downloads', 0);
    }

    public function __get($key)
    {
        if (! isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }
}

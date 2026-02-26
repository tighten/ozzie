<?php

namespace App\GitHub;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use App\Models\FetchResult;
use App\Models\Project;
use App\Notifications\GitHubFetchFailed;
use App\OrgSlack;
use Exception;
use Github\Exception\RuntimeException;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;
use Illuminate\Support\Facades\Log;

class Repository
{
    public $name;

    public $namespace;

    protected $project;

    protected $repoData;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->namespace = $project->namespace;
        $this->name = $project->name;
    }

    public function exists()
    {
        try {
            $this->repoData = GitHubClient::repo()->show($this->namespace, $this->name);

            return true;
        } catch (RuntimeException $e) {
            if ($e->getCode() === 404) {
                return false;
            }

            throw $e;
        }
    }

    public function isArchived()
    {
        return ($this->repoData ?? [])['archived'] ?? false;
    }

    public function issues()
    {
        try {
            return collect(GitHubClient::issues()->all($this->namespace, $this->name))
                ->tap(fn () => FetchResult::githubSuccess($this->project))
                ->map(function ($issue) {
                    return new Issue($issue);
                })->reject(function (Issue $issue) {
                    return ! is_null($issue->pull_request);
                });
        } catch (Exception $e) {
            $this->handleFetchFailure($e, 'issues');

            return collect();
        }
    }

    public function pullRequests()
    {
        try {
            return collect(GitHubClient::pullRequests()->all($this->namespace, $this->name))
                ->map(function ($pullRequest) {
                    return new PullRequest($pullRequest);
                });
        } catch (Exception $e) {
            $this->handleFetchFailure($e, 'pull requests');

            return collect();
        }
    }

    protected function handleFetchFailure(Exception $e, string $endpoint): void
    {
        $repo = "{$this->namespace}/{$this->name}";

        Log::warning("GitHub {$endpoint} fetch failed for {$repo}", [
            'exception' => get_class($e),
            'code' => $e->getCode(),
            'message' => substr($e->getMessage(), 0, 500),
        ]);

        FetchResult::githubFail($this->project);

        (new OrgSlack)->notify(new GitHubFetchFailed(
            repo: $repo,
            endpoint: $endpoint,
            code: $e->getCode(),
            exceptionClass: get_class($e),
        ));
    }
}

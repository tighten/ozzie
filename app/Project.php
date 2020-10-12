<?php

namespace App;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'maintainers' => 'array',
        'issues' => 'collection',
        'pull_requests' => 'collection',
    ];

    public function hacktoberfestIssues()
    {
        return $this->issues->filter(function ($issue) {
            return ! empty($issue->labels)
                && collect($issue->labels)->contains('name', 'hacktoberfest');
        });
    }

    public function oldPullRequests()
    {
        return $this->pull_requests->mapInto(PullRequest::class)->filter(function ($pullRequest) {
            return $pullRequest->created_at->diff()->days > 30;
        });
    }

    public function oldIssues()
    {
        return $this->issues->mapInto(Issue::class)->filter(function ($issue) {
            return $issue->created_at->diff()->days > 30;
        });
    }

    public function debtScore()
    {
        return array_sum([
            $this->oldIssues()->count() * 5,
            $this->issues_count * 1,
            $this->oldPullRequests()->count() * 25,
            $this->pull_requests_count * 13,
        ]) / 100;
    }

    public function url()
    {
        return 'https://github.com/' . $this->namespace . '/' . $this->name;
    }

    public function updatedAt()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function snapshotToday()
    {
        return $this->hasMany(Snapshot::class)->today();
    }
}

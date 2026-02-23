<?php

namespace App\Models;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'debt_score',
    ];

    protected function casts(): array
    {
        return [
            'issues' => 'collection',
            'is_hidden' => 'boolean',
            'pull_requests' => 'collection',
        ];
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function snapshotToday()
    {
        return $this->hasMany(Snapshot::class)->today();
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    public function maintainers()
    {
        return $this->belongsToMany(Maintainer::class);
    }

    public function scopeFromVendorAndName(Builder $query, string $projectNamespace, string $projectName): Builder
    {
        return $query->where('namespace', $projectNamespace)->where('name', $projectName);
    }

    public function scopeForPackagist($query, $vendor, $name = null)
    {
        // @todo test this
        if (! $name) {
            [$vendor, $name] = explode('/', $vendor);
        }

        $query->where([
            'packagist_name' => $vendor.'/'.$name,
        ])->orWhere(function ($query) use ($vendor, $name) {
            $query->where([
                'packagist_name' => null,
                'namespace' => $vendor,
                'name' => $name,
            ]);
        });
    }

    public function getDebtScoreAttribute()
    {
        return $this->debtScore();
    }

    public function hacktoberfestIssues()
    {
        return $this->issues->filter(function ($issue) {
            return collect($issue['labels'])->contains('name', 'hacktoberfest');
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
        return 'https://github.com/'.$this->namespace.'/'.$this->name;
    }

    public function issue(int $id): array
    {
        if (! ($issue = $this->issues->where('number', $id)->first())) {
            throw new NotFoundHttpException("Issue number {$id} does not exist");
        }

        return $issue;
    }

    public function pullRequest(int $id): array
    {
        if (! ($pullRequest = $this->pull_requests->where('number', $id)->first())) {
            throw new NotFoundHttpException("Pull request number {$id} does not exist");
        }

        return $pullRequest;
    }

    public function getDebtScoreHistory()
    {
        return Cache::remember('debt_score_history_'.$this->name, 60 * 60, function () {
            $list = [];

            $now = Carbon::now();
            $period = new CarbonPeriod($now->parse()->subDays(7)->format('Y-m-d'), $now->format('Y-m-d'));

            foreach ($period as $date) {
                $snapshot = Snapshot::where('name', $this->name)
                    ->where('snapshot_date', $date->format('Y-m-d'))
                    ->orderBy('snapshot_date')
                    ->first();

                $list[] = $snapshot->debt_score ?? 0;
            }

            return $list;
        });
    }

    public function hasDownloads()
    {
        if ($this->downloads_total + $this->downloads_last_30_days > 0) {
            return true;
        }
    }

    public function recentFetchSuccessRate($type = null): ?float
    {
        $results = FetchResult::where('project_id', $this->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->when($type, fn ($query) => $query->where('type', $type))
            ->get();

        return $results->isNotEmpty() ? $results->avg('success') : null;
    }

    public function scopeExclude($query, $value = [])
    {
        return $query->select(array_diff(
            $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable()),
            Arr::wrap($value)
        ));
    }

    public function scopeNotHidden($query)
    {
        return $query->where('is_hidden', false);
    }
}

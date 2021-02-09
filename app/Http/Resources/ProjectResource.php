<?php

namespace App\Http\Resources;

use Davaxi\Sparkline;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        self::withoutWrapping();
        $sparkline = new Sparkline();
        $sparkline->setData($this->getDebtScoreHistory());

        return array_merge(
            $this->resource->toArray(),
            [
                'url' => $this->resource->url(),
                'debt_score' => $this->debtScore(),
                'debt_score_graph' => $sparkline->toBase64(),
                'old_issues_count' => $this->oldIssues()->count(),
                'old_pull_requests_count' => $this->oldPullRequests()->count(),
                'hacktoberfestIssues' => $this->hacktoberfestIssues()->count(),
            ]
        );
    }
}

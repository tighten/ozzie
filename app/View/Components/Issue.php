<?php

namespace App\View\Components;

use App\GitHub\Dto\Issue as GitHubIssue;
use App\Project;
use Carbon\Carbon;
use Illuminate\View\Component;

class Issue extends Component
{
    public $issue;
    public $project;

    public function __construct(GitHubIssue $issue, Project $project)
    {
        $this->issue = $issue;
        $this->project = $project;
        $this->issue->date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $issue->created_at);
    }

    public function render()
    {
        return view('components.issue');
    }
}

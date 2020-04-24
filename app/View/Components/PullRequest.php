<?php

namespace App\View\Components;

use App\GitHub\Dto\Pr as GitHubPr;
use App\Project;
use Carbon\Carbon;
use Illuminate\View\Component;
use Parsedown;

class PullRequest extends Component
{
    public $prData;
    public $project;

    public function __construct(GitHubPr $prData, Project $project, Parsedown $parsedown)
    {
        $this->prData = $prData;
        $this->project = $project;
        $this->prData->date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $prData->created_at);
        $this->prData->body = $parsedown->parse($this->prData->body);
    }

    public function render()
    {
        return view('components.pull-request');
    }
}

<?php

namespace App\View\Components;

use App\GitHub\Dto\Pr as GitHubPr;
use App\Project;
use Illuminate\View\Component;
use Parsedown;

class PullRequest extends Component
{
    public $prData;
    public $project;

    public function __construct(GitHubPr $prData, Project $project)
    {
        $this->prData = $prData;
        $this->project = $project;
    }

    public function render()
    {
        return view('components.pull-request');
    }
}

<?php

namespace App\View\Components;

use App\GitHub\Dto\IssueData;
use App\Project as ProjectModel;
use Illuminate\View\Component;

class IssueDetail extends Component
{
    public $issue;
    public $project;

    public function __construct(IssueData $issueData, ProjectModel $project)
    {
        $this->issue = $issueData;
        $this->project = $project;
    }

    public function render()
    {
        return view('components.issue-detail');
    }
}

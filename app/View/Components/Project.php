<?php

namespace App\View\Components;

use App\Project as ProjectModel;
use Illuminate\View\Component;

class Project extends Component
{
    public $project;

    public function __construct(ProjectModel $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('components.project');
    }

    public function downloads()
    {
        if (! $this->project->hasDownloads()) {
            return null;
        }

        $monthly = number_format($this->project->downloads_last_30_days, 0);
        $total = number_format($this->project->downloads_total, 0);

        return  "{$total} downloads ({$monthly} per month)";
    }
}

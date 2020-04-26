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
}

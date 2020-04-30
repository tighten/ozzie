<?php

namespace App\View\Components;

use App\Project as ProjectModel;
use Illuminate\View\Component;

class Project extends Component
{
    public $project;
    public $inlineDebt;

    public function __construct(ProjectModel $project, bool $inlineDebt)
    {
        $this->project = $project;
        $this->inlineDebt = $inlineDebt;
    }

    public function render()
    {
        return view('components.project');
    }
}

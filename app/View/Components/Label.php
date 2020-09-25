<?php

namespace App\View\Components;

use App\GitHub\Dto\Label as GithubLabel;
use App\Project;
use Illuminate\View\Component;

class Label extends Component
{
    public $project;
    public $label;

    public function __construct(GithubLabel $label, Project $project)
    {
        $this->label = $label;
        $this->project = $project;
    }

    public function render()
    {
        return view('components.label');
    }
}

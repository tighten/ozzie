<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Label extends Component
{
    public $projectNamespace;
    public $projectName;
    public $label;

    public function __construct(string $projectNamespace, string $projectName, string $label)
    {
        $this->projectNamespace = $projectNamespace;
        $this->projectName = $projectName;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.label');
    }
}

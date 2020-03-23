<?php

namespace App\View\Components;

use App\GitHub\Dto\LabelData;
use Illuminate\View\Component;

class Label extends Component
{
    public $projectNamespace;
    public $projectName;
    public $label;

    public function __construct(LabelData $label, string $projectNamespace, string $projectName)
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

<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class DebtTable extends Component
{
    public $projects;
    public $hacktoberfest;

    public function __construct(Collection $projects, bool $hacktoberfest  = false)
    {
        $this->projects = $projects;
        $this->hacktoberfest = $hacktoberfest;
    }

    public function render()
    {
        return view('components.debt-table');
    }
}

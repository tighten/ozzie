<?php

namespace App\Http\Livewire;

use App\Projects;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DebtTable extends Component
{
    public $projects;
    public $hacktoberfest;
    public $inlineDebtTable = false;
    public $maintainers;
    public $selectedMaintainer;

    protected $listeners = [
        'toggleInlineDebtTable',
    ];

    public function toggleInlineDebtTable()
    {
        $this->inlineDebtTable = ! $this->inlineDebtTable;

        $this->projects = $this->setProjects();
        $this->maintainers = $this->setMaintainers();

        if (empty($this->selectedMaintainer)) {
            $this->selectedMaintainer = $this->maintainers[0];
        }
    }

    public function mount() {

        $this->hacktoberfest = (bool) Carbon::now()->isSameMonth(Carbon::parse('October'));
        $this->projects = $this->setProjects();
        $this->maintainers = $this->setMaintainers();
    }

    public function updatedSelectedMaintainer()
    {
        $this->projects = $this->setProjects();
    }

    public function render()
    {
        return view('livewire.debt-table');
    }

    protected function setMaintainers(): array
    {
        return (new Projects)->all()
            ->map(fn($project) => $project->maintainers)
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    protected function setProjects()
    {
        $projects = (new Projects)->all()->sortByDesc(
            function ($project) {
                return $project->debtScore();
            }
        );

        if (! empty($this->selectedMaintainer)) {
            $filtered = $projects->filter(function($project) {
                return in_array($this->selectedMaintainer, $project->maintainers);
            });

            return $filtered->all();
        }
        return $projects->toArray();
    }
}

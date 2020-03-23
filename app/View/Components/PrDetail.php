<?php

namespace App\View\Components;

use App\GitHub\Dto\PrData;
use App\Project as ProjectModel;
use Carbon\Carbon;
use Illuminate\View\Component;

class PrDetail extends Component
{
    public $prData;
    public $project;

    public function __construct(PrData $prData, ProjectModel $project)
    {
        $this->prData = $prData;
        $this->project = $project;
        $this->prData->date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $prData->created_at);
    }

    public function render()
    {
        return view('components.pr-detail');
    }
}

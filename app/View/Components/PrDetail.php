<?php

namespace App\View\Components;

use App\GitHub\Dto\PrData;
use App\Project as ProjectModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Parsedown;

class PrDetail extends Component
{
    public $prData;
    public $project;

    public function __construct(PrData $prData, ProjectModel $project, Parsedown $parsedown)
    {
        $this->prData = $prData;
        $this->project = $project;
        $this->prData->date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $prData->created_at);
        $this->prData->body = $parsedown->parse($this->prData->body);
    }

    public function render()
    {
        return view('components.pr-detail');
    }
}

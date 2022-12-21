<?php

namespace App\Nova\Metrics;

use App\Project;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ProjectsMaintainers extends Partition
{
    public function calculate(NovaRequest $request)
    {
        $projects = Project::with(['maintainers'])->get();

        $maintainerCounts = $projects->countBy(function ($project) {
            return count($project->maintainers);
        });

        return $this->result($maintainerCounts->toArray());
    }
}

<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ProjectsMaintainers;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function cards()
    {
        return [
            new ProjectsMaintainers,
        ];
    }
}

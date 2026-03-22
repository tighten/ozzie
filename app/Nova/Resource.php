<?php

namespace App\Nova;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Scout\Builder as ScoutBuilder;

abstract class Resource extends NovaResource
{
    public static function indexQuery(NovaRequest $request, Builder $query)
    {
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, ScoutBuilder $query)
    {
        return $query;
    }

    public static function detailQuery(NovaRequest $request, Builder $query)
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, Builder $query)
    {
        return parent::relatableQuery($request, $query);
    }
}

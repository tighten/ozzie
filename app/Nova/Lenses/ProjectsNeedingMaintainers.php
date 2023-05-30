<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class ProjectsNeedingMaintainers extends Lens
{
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->withCount('maintainers')
                ->whereHas('maintainers', operator: '=', count: 0)
                ->notHidden()
                ->orderBy('name')
        ));
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make(),
            Text::make('name')->readonly()->sortable(),
            Boolean::make('is_hidden')->filterable()->sortable(),
            BelongsToMany::make('Maintainers')->searchable()->showCreateRelationButton(),
            Number::make('# Maintainers', 'maintainers_count')->onlyOnIndex()->textAlign('center')->sortable(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    public function uriKey()
    {
        return 'projects-needing-maintainers';
    }
}

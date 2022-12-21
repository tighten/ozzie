<?php

namespace App\Nova;

use App\Nova\Metrics\ProjectsMaintainers;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    public static $model = \App\Project::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            return static::$model::count();
        });
    }

    public static function indexQuery(NovaRequest $request, $query) {
        // adds a `maintainers_count` column to the query result
        return $query->withCount('maintainers');
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
        return [
            new ProjectsMaintainers,
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}

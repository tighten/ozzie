<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Maintainer extends Resource
{
    public static $model = \App\Maintainer::class;

    public static $title = 'github_username';

    public static $search = [
        'github_username',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        // adds a `projects_count` column to the query result
        return $query->withCount('projects');
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        $model->user_id = 5;
    }

    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            return static::$model::count();
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('GitHub Username', 'github_username')->sortable(),
            Number::make('# Projects', 'projects_count')->onlyOnIndex()->textAlign('center')->sortable(),
            BelongsToMany::make('Projects'),
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

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}

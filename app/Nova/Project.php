<?php

namespace App\Nova;

use App\Nova\Actions\HideProject;
use App\Nova\Actions\UnHideProject;
use App\Nova\Lenses\ProjectsNeedingMaintainers;
use App\Nova\Metrics\ProjectsMaintainers;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    public static $model = \App\Models\Project::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        // adds a `maintainers_count` column to the query result
        return $query->withCount('maintainers');
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
            ID::make(),
            URL::make('Name', fn () => "https://github.com/{$this->namespace}/{$this->name}")
                ->displayUsing(fn () => $this->name)
                ->sortable()
                ->readonly()
                ->textAlign('left'),
            Boolean::make('Hidden?', 'is_hidden')
                ->sortable()
                ->filterable(),
            BelongsToMany::make('Maintainers')
                ->searchable()
                ->showCreateRelationButton(),
            Number::make('# Maintainers', 'maintainers_count')
                ->sortable()
                ->onlyOnIndex()
                ->textAlign('center'),
            Number::make('Issues', 'issues_count')
                ->sortable()
                ->onlyOnIndex()
                ->textAlign('center'),
            Number::make('PRs', 'pull_requests_count')
                ->sortable()
                ->onlyOnIndex()
                ->textAlign('center'),
            Number::make('Fetch Packagist Success', function () {
                $rate = $this->recentFetchSuccessRate('packagist');

                return is_null($rate) ? '—' : number_format(100 * $rate, 2).'%';
            })
                ->sortable()
                ->onlyOnIndex()
                ->textAlign('center'),
            Number::make('Fetch Github Success', function () {
                $rate = $this->recentFetchSuccessRate('github');

                return is_null($rate) ? '—' : number_format(100 * $rate, 2).'%';
            })
                ->sortable()
                ->onlyOnIndex()
                ->textAlign('center'),
            Text::make('Updated At')
                ->sortable()
                ->exceptOnForms()
                ->displayUsing(function ($updatedAt) {
                    if ($updatedAt === null) {
                        return null;
                    }

                    return $updatedAt->diffForHumans();
                }),
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
        return [
            new ProjectsNeedingMaintainers,
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new HideProject)->showInline(),
            (new UnHideProject)->showInline(),
        ];
    }
}

<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'email',
    ];

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

            Avatar::make('avatar_url')->disableDownload()->maxWidth(50)->thumbnail(function () {
                return $this->avatar_url ?? 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=50&d=mm';
            }),

            Text::make('Name')->sortable(),

            Text::make('Email')->readonly(),

            Text::make('GitHub Username', 'github_username')->readonly(),

            Text::make('GitHub ID', 'github_id')->readonly(),
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

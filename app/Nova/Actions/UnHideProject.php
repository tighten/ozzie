<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class UnHideProject extends Action
{
    public $name = 'Un-Hide Project';

    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            $model->is_hidden = false;
            $model->save();
        });
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}

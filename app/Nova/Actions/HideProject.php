<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class HideProject extends Action
{
    public $name = 'Hide Project';

    public $confirmText = 'Mark these projects as hidden? Authenticated users will still see them, but guest users will not.';

    public $confirmButtonText = 'Hide Project(s)';

    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            $model->is_hidden = true;
            $model->save();
        });
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}

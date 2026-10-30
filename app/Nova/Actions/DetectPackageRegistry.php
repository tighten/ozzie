<?php

namespace App\Nova\Actions;

use App\Remotes\PackageRegistryDetector;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class DetectPackageRegistry extends Action
{
    public $name = 'Detect Package Registry';

    public $confirmText = 'Look these projects up on Packagist and npm and set their package registry to whichever one they are published to? Any registry you have set by hand will be overwritten.';

    public $confirmButtonText = 'Detect Registry';

    public function handle(ActionFields $fields, Collection $models)
    {
        $detector = app(PackageRegistryDetector::class);
        $undetermined = collect();

        $models->each(function ($model) use ($detector, $undetermined) {
            if (is_null($detector->redetect($model))) {
                $undetermined->push($model->name);

                return;
            }

            $model->save();
        });

        if ($undetermined->isNotEmpty()) {
            return Action::danger("Could not reach a package registry for: {$undetermined->join(', ')}. Those projects were left unchanged.");
        }

        return Action::message('Package registry updated.');
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => fn () => $request->user() ? $request->user()->only([
                'name',
                'email',
                'github_username',
                'avatar_url',
            ]) : null,
        ]);
    }
}

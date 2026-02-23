<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        // Use our login controller instead of Nova's
        $this->app->alias(
            \App\Http\Controllers\Auth\LoginController::class,
            \Laravel\Nova\Http\Controllers\LoginController::class
        );

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->prepend(
                MenuItem::externalLink(
                    'Go to Public Site',
                    route('projects.index')
                )
            );
            $menu->append(
                MenuItem::externalLink(
                    'Logout',
                    route('logout')
                )
            );

            return $menu;
        });
    }

    public function tools()
    {
        return [];
    }

    public function register(): void
    {
        //
    }

    protected function routes()
    {
        Nova::routes()
            ->register();
    }

    protected function gate()
    {
        // All users that are in the database can access Nova, since their
        // GitHub account is associated to the organization in config/app.php
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }
}

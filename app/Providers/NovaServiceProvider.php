<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
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

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->register();
    }

    protected function gate()
    {
        // All users that in the database can access Nova,
        // since their GitHub account is associated to the organization
        // in config/app.php
        return true;
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }
}

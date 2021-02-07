<?php

use App\Http\Controllers\ProjectController;

Route::get('/', 'DashboardController@show')->name('dashboard');

Route::get('/inertia', [ProjectController::class, 'index'])->name('projects.index');

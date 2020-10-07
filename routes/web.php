<?php

Route::get('/', 'DashboardController@show')->name('dashboard');
Route::get('/projects/{namespace}/{name}', 'ProjectController@show')->name('projects.show');

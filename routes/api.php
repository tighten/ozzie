<?php

use App\Http\Controllers\Api\ProjectsController;

Route::get('projects', [ProjectsController::class, 'index']);
Route::get('projects/{namespace}/{name}', [ProjectsController::class, 'show']);

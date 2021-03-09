<?php

use App\Http\Controllers\Api\ProjectController;

Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{namespace}/{name}', [ProjectController::class, 'show']);

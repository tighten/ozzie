<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PullRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/pr', [PullRequestController::class, 'show'])->name('projects.show');

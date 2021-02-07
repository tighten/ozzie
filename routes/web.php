<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PullRequestController;

Route::get('/', 'DashboardController@show')->name('dashboard');
Route::get('inertia', [ProjectController::class, 'index'])->name('projects.index');
Route::get('inertia/projects/{namespace}/{name}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('inertia/projects/{namespace}/{projectName}/issues/{issueNumber}', [IssueController::class, 'show'])->name('issue.show');
Route::get('inertia/projects/{namespace}/{projectName}/prs/{pullRequestNumber}', [PullRequestController::class, 'show'])->name('pull-request.show');

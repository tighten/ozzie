<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PullRequestController;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::prefix('projects/{namespace}/{name}')->group(function () {
    Route::get('/', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('issues/{issueNumber}', [IssueController::class, 'show'])->name('issue.show');
    Route::get('prs/{pullRequestNumber}', [PullRequestController::class, 'show'])->name('pull-request.show');
});

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PullRequestController;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::prefix('projects/{vendor}/{name}')->group(function () {
    Route::get('/', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('issues/{id}', [IssueController::class, 'show'])->name('issue.show');
    Route::get('prs/{id}', [PullRequestController::class, 'show'])->name('pull-request.show');
});

Route::get('auth/redirect', [LoginController::class, 'redirectToProvider'])->name('auth.github');
Route::get('auth/callback', [LoginController::class, 'handleProviderCallback']);

Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('nova/login', function () {
    return redirect()->route('auth.github');
})->name('nova.login');

Route::any('nova/logout', function () {
    return redirect()->route('logout');
})->name('nova.logout');

<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SetUserAuthorization;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */


Route::middleware(['guest'])->group(function () {
    Route::post('testapi', function (Request $request) {});
    Route::post('login', [AuthenticatedSessionController::class, 'storeApi']);
});

Route::middleware(['auth:sanctum', SetUserAuthorization::class])->group(function () {
    Route::controller(ProjectController::class)->group(function () {
        Route::post('/project/create/{team}', 'store');
    });
    Route::controller(TeamController::class)->group(function () {
        Route::get('/teams', 'index');
        Route::get('/team/{team}', 'show');
        Route::post('/team/adduser/{team}', 'addUser');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'getuserdata');
    });
});

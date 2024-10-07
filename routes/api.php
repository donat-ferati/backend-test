<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Package\ListPackagesController;
use App\Http\Controllers\API\Package\RegisterPackageController;
use Illuminate\Support\Facades\Route;

//AUTHENTICATION
Route::post('login', LoginController::class)->name('login');
Route::post('register', RegisterController::class)->name('register');

Route::group(['middleware' => ['auth:sanctum'], 'as' => 'api.'], function () {

    //PACKAGES
    Route::get('/packages', ListPackagesController::class)->name('packages.index');
    Route::post('/packages/register', RegisterPackageController::class)->name('packages.register');
});

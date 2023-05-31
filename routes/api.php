<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', TokenController::class);

/**
 * Guest related
 */



Route::middleware(['auth:sanctum', 'apply_locale'])->group(function () {

    /**
     * Auth related
     */
    Route::get('/users/auth', AuthController::class);

    /**
     * Users
     */
    Route::put('/users/{user}/avatar', [UserController::class, 'updateAvatar']);
    Route::resource('users', UserController::class);

    /**
     * Roles
     */
    Route::get('/roles/search', [RoleController::class, 'search'])->middleware('throttle:400,1');

    Route::get('/dash-page-data', [HomeController::class, 'dashboardUserData']);
});


Route::get('/home-page-data', [HomeController::class, 'index']);




/**
 * include all route files in the allapiroutes folder except auth.php
 *
 */
$api_folder = __DIR__ . '/apiRoutes';
$dir = new DirectoryIterator($api_folder);
foreach ($dir as $file) {
    if ($file->isFile() && str_contains($file->getFilename(), '.php') && $file->getFilename() !== 'auth.php') {
        require __DIR__ . '/apiRoutes/' . $file->getFilename();
    }
}

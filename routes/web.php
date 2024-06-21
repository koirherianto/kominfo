<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [App\Http\Controllers\LandingController::class, 'index']);
Route::get('/blogs', [App\Http\Controllers\LandingController::class, 'blogs'])->name('blogs');
// Route::get('/blogs/{slug}', [App\Http\Controllers\LandingController::class, 'blog'])->name('blog');
// Route::post('bc/selectEvidences', [App\Http\Controllers\LandingController::class, 'selectEvidences'])->name('bc.selectEvidences');
// Route::post('bc/result', [App\Http\Controllers\LandingController::class, 'result'])->name('bc.result');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Auth::routes();
//df
Route::group(['middleware' => 'auth'], function () {

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    // Route::get('/homx', [App\Http\Controllers\HomeController::class, 'home'])->name('homex');

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('editProfile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::post('updatePassword', [UserController::class, 'updatePassword'])->name('update.password');
    Route::post('updateFotoProfile', [UserController::class, 'updateFotoProfile'])->name('update.foto.profile');
    
    
    Route::resource('users', UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
});



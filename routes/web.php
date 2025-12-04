<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FramerController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'FramerHome']);
//Route::post('/upload-framed-photo', [FramerController::class, 'uploadFramedPhoto'])->name('upload.framed.photo');
Route::post('/upload-framed-photo', [PublicController::class, 'uploadFramedPhoto'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/view-photo/{id}', [PublicController::class, 'ViewPhoto']);    

//Admin
Route::get('/login', [AuthController::class, 'LoginPage'])->name('login');
Route::post('check-login', [AuthController::class, 'LoginProcess']);

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'Dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'LogOut'])->name('logout');

    // User
    Route::get('/user/all', [AuthController::class, 'getAllUsers'])->name('all-users');
    Route::post('/user/insert', [AuthController::class, 'InsertUser'])->name('insert-user');
    Route::get('/user/new', [AuthController::class, 'NewUsers_form'])->name('new-users');
    Route::get('/user/edit/{id}', [AuthController::class, 'EditUser'])->name('edit-user');
    Route::put('/user/update/{id}', [AuthController::class, 'UpdateUser'])->name('update-user');
    Route::put('/user/active/{id}', [AuthController::class, 'UserActive'])->name('user-active');
    Route::put('/user/inactive/{id}', [AuthController::class, 'UserInActive'])->name('user-inactive');
    Route::delete('/user/delete/{id}', [AuthController::class, 'DeleteUser'])->name('delete-user');
    Route::get('/user/password-change/{id}', [AuthController::class, 'PasswordChange'])->name('password-change');
    Route::put('/user/update-password/{id}', [AuthController::class, 'UpdatePassword'])->name('update-password');
    Route::get('/user/profile/{id}', [AuthController::class, 'UserProfile'])->name('user-profile');

    Route::get('/frame/new', [FramerController::class, 'NewFrame'])->name('new-frame');
    Route::post('/frame/save', [FramerController::class, 'SaveFrame'])->name('save-frame');
    Route::get('/frame/delete/{id}', [FramerController::class, 'DeleteFrame'])->name('delete-frame');

    Route::get('/frame/active/{id}', [FramerController::class, 'ActiveFrame'])->name('active-frame');
    Route::get('/frame/inactive/{id}', [FramerController::class, 'InactiveFrame'])->name('inactive-frame');

     Route::get('/photo/delete/{id}', [FramerController::class, 'DeleteUploadedPhoto'])->name('delete-photo');




});

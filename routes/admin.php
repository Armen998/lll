<?php

use App\Http\Controllers\Admin\AdminAvatar\AdminAvatarController;
use App\Http\Controllers\Admin\AdminProfile\AdminController;
use App\Http\Controllers\Admin\Posts\PostsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Home\HomeController;
use App\Http\Controllers\Admin\Users\UsersController;


// Admin

Route::middleware('guest:admin')->group(function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');

    Route::post('login', [AuthController::class, 'signin'])->name('signin');
});

Route::middleware('auth:admin')->group(function () {

    //Home
    Route::get('home', [HomeController::class, 'index'])->name('home');

    //Logout
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');

    //Admin Profile
    Route::get('profile', [AdminController::class, 'adminProfile'])->name('admin-profile');

    Route::put('data-update', [AdminController::class, 'adminDataUpdate'])->name('data-update');

    Route::put('password-update', [AdminController::class, 'adminPasswordUpdate'])->name('password-update');

    //Admin Avatar
    Route::get('avatar-add', [AdminAvatarController::class, 'avatarAdd'])->name('avatar-add');

    Route::post('avatar-create', [AdminAvatarController::class, 'avatarCreate'])->name('avatar-create');

    Route::get('avatar-delete', [AdminAvatarController::class, 'avatarDestroy'])->name('avatar-destroy');

    //Post 
    Route::get('posts', [PostsController::class, 'index'])->name('posts');

    Route::put('posts-{id}-block', [PostsController::class, 'postBlock'])->name('posts-block');

    Route::put('posts-{id}-unlock', [PostsController::class, 'postUnlock'])->name('posts-unlock');

    Route::put('posts-{id}-favorite', [PostsController::class, 'postFavorite'])->name('posts-favorite');
    
    Route::delete('posts-{id}-unfavorite', [PostsController::class, 'postUnfavorite'])->name('posts-unfavorite');

    Route::delete('posts-{id}', [PostsController::class, 'postDestroy'])->name('posts-destroy');

    //User
    Route::get('users', [UsersController::class, 'users'])->name('users');

    Route::get('users-add', [UsersController::class, 'userAdd'])->name('user-add');

    Route::post('registration', [UsersController::class, 'signup'])->name('signup');

    Route::put('makeAdmin/{id}', [UsersController::class, 'makeAdmin'])->name('make-admin');

    Route::put('makeAegular-{id}', [UsersController::class, 'makeRegular'])->name('make-regular');

    Route::delete('users-{id}', [UsersController::class, 'userDestroy'])->name('urers-destroy');

    Route::get('users-{id}-data-change', [UsersController::class, 'usersDataChange'])->name('users-data-change');

    Route::get('users-{id}-home', [UsersController::class, 'usersHome'])->name('users-home');

});
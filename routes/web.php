<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Web\Category\CategoriesController;
use App\Http\Controllers\Web\Guest\AuthController;
use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Posts\Comments\PostsCommentsController;
use App\Http\Controllers\Web\Posts\Comments\PostsCommentsOpinionsController;
use App\Http\Controllers\Web\Posts\PostsController;
use App\Http\Controllers\Web\Posts\PostsOpinionsController;
use App\Http\Controllers\Web\Users\UsersController;
use App\Http\Controllers\Web\Users\UsersAvatasController;


//Guest
Route::middleware('guest')->group(function () {

    //Registration
    Route::get('registration', [AuthController::class, 'registration'])->name('registration');

    Route::post('registration', [AuthController::class, 'signup'])->name('signup');

    //Login
    Route::get('login', [AuthController::class, 'login'])->name('login');

    Route::post('login', [AuthController::class, 'signin'])->name('signin');
});

//Auth
Route::middleware('auth')->group(function () {

    // Home
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('/', [HomeController::class, 'index'])->name('/');

    //Logout
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');

    //Categories
    Route::get('categories-create', [CategoriesController::class, 'create'])->name('categories-create');

    Route::post('categories-store', [CategoriesController::class, 'store'])->name('categories-store');

    //Posts 
    Route::get('posts-create', [PostsController::class, 'create'])->name('posts-create');

    Route::post('posts-store', [PostsController::class, 'store'])->name('posts-store');

    Route::get('posts-{id}-create', [PostsController::class, 'statedCeate'])->name('posts-stated-create');

    Route::post('posts-{id}-store', [PostsController::class, 'statedStore'])->name('posts-stated-store');

    Route::get('posts-{id}-view', [PostsController::class, 'view'])->name('posts-view');

    Route::get('posts-{id}-edit', [PostsController::class, 'edit'])->name('posts-edit');

    Route::patch('posts-{id}-update', [PostsController::class, 'update'])->name('posts-update');

    Route::delete('posts-{id}', [PostsController::class, 'destroy'])->name('posts-destroy');

    //Post//Like//Dislike
    Route::post('posts-{id}-like', [PostsOpinionsController::class, 'postsLike'])->name('posts-like');

    Route::post('posts-{id}-dislike', [PostsOpinionsController::class, 'postsDislike'])->name('posts-dislike');

    //Post//Comment
    Route::post('posts-{id}-comments', [PostsCommentsController::class, 'store'])->name('posts-comments-store');

    Route::post('posts-{id}-comments-{comment_id}', [PostsCommentsController::class, 'reply'])->name('posts-comments-reply');

    //Comment//Like//Dislike
     Route::post('posts-comments-{id}-like', [PostsCommentsOpinionsController::class, 'postsCommentsLike'])->name('posts-comments-like');

     Route::post('posts-comments-{id}-dislike', [PostsCommentsOpinionsController::class, 'postCommentDislike'])->name('posts-comments-dislike');

    //User
    Route::get('users', [UsersController::class, 'index'])->name('users');

    Route::get('user-posts', [UsersController::class, 'posts'])->name('user-posts');

    Route::put('users-update', [UsersController::class, 'update'])->name('users-update');

    Route::put('users-password-update', [UsersController::class, 'passwordUpdate'])->name('users-password-update');

    //User Avatar
    Route::get('users-avatar-add', [UsersAvatasController::class, 'add'])->name('users-avatar-add');

    Route::post('users-avatar-create', [UsersAvatasController::class, 'create'])->name('users-avatar-create');

    Route::delete('users-avatar-delete', [UsersAvatasController::class, 'destroy'])->name('users-avatar-destroy');
});

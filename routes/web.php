<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;

// Route::get('/', function () {

// });
Auth::routes(['verify' => true]);
Route::get('/', [FrontController::class, 'index']);
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route Frontend
Route::get('/file/{post_slug}', [FrontController::class, 'show']);
Route::get('/files', [FrontController::class, 'post']);
Route::get('/search', [FrontController::class, 'search']);
Route::get('/category/{category_slug}', [FrontController::class, 'category']);
Route::get('/tag/{tag_slug}', [FrontController::class, 'tag']);
Route::get('/page/{slug}', [FrontController::class, 'page']);
Route::get('file/download/{uuid}', [FrontController::class, 'download']);
Route::get('file/download-file/{uuid}', [FrontController::class, 'download_process']);

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::post('/update-profile', [HomeController::class, 'update_profile'])->name('update-profile');
Route::get('/delete-profile', [HomeController::class, 'delete_profile'])->name('delete-profile');

Route::middleware('auth')->group(function () {

    Route::get('options', [OptionController::class, 'index']);
    Route::post('options/update', [OptionController::class, 'update']);

    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/create', [RoleController::class, 'create']);
    Route::post('roles/store', [RoleController::class, 'store']);
    Route::get('roles/show/{id}', [RoleController::class, 'show']);
    Route::get('roles/edit/{id}', [RoleController::class, 'edit']);
    Route::post('roles/update/{id}', [RoleController::class, 'update']);
    Route::delete('roles/delete/{id}', [RoleController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/create', [UserController::class, 'create']);
    Route::post('users/store', [UserController::class, 'store']);
    Route::get('users/edit/{id}', [UserController::class, 'edit']);
    Route::post('users/update/{id}', [UserController::class, 'update']);
    Route::get('users/banned/{id}', [UserController::class, 'banned']);
    Route::get('users/activated/{id}', [UserController::class, 'activated']);
    Route::post('users/delete/{id}', [UserController::class, 'destroy']);

    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/create', [PostController::class, 'create']);
    Route::post('posts/store', [PostController::class, 'store']);
    Route::get('posts/edit/{id}', [PostController::class, 'edit']);
    Route::post('posts/update/{post_id}', [PostController::class, 'update']);
    Route::delete('posts/delete/{post_id}', [PostController::class, 'destroy']);
    Route::get('posts/show/{post_id}', [PostController::class, 'show']);



    Route::get('user-posts', [PostController::class, 'user_posts']);
    Route::get('user-posts/show/{post_id}', [PostController::class, 'show']);

    Route::get('pages', [PageController::class, 'index']);
    Route::get('pages/create', [PageController::class, 'create']);
    Route::post('pages/store', [PageController::class, 'store']);
    Route::get('pages/edit/{id}', [PageController::class, 'edit']);
    Route::post('pages/update/{page_id}', [PageController::class, 'update']);
    Route::delete('pages/delete/{page_id}', [PageController::class, 'destroy']);

    Route::get('banners', [BannerController::class, 'index']);
    Route::get('banners/create', [BannerController::class, 'create']);
    Route::post('banners/store', [BannerController::class, 'store']);
    Route::get('banners/edit/{id}', [BannerController::class, 'edit']);
    Route::post('banners/update/{banner_id}', [BannerController::class, 'update']);
    Route::delete('banners/delete/{banner_id}', [BannerController::class, 'destroy']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories/store', [CategoryController::class, 'store']);
    Route::get('categories/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('categories/update/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/delete/{id}', [CategoryController::class, 'destroy']);

    Route::get('tags', [TagController::class, 'index']);
    Route::post('tags/store', [TagController::class, 'store']);
    Route::get('tags/edit/{id}', [TagController::class, 'edit']);
    Route::post('tags/update/{category}', [TagController::class, 'update']);
    Route::delete('tags/delete/{id}', [TagController::class, 'destroy']);
});

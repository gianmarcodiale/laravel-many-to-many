<?php

use App\Mail\PostUpdatedAdminMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Create route middleware for admin
Route::middleware('auth')
    ->prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function () {
        // Admin dashboard
        Route::get('/', 'HomeController@index')->name('dashboard');
        // Admin posts
        Route::resource('posts', 'PostController')->parameters([
            'posts' => 'post:slug'
        ]);
        // Create route for categories
        Route::resource('categories', 'CategoryController')->parameters([
            'categories' => 'category:slug'
        ])->except(['show', 'create', 'edit']);
        // Create route for tags
        Route::resource('tags', 'TagController')->parameters([
            'tags' => 'tag:slug'
        ])->except(['show', 'create', 'edit']);
    });

// Or we can create a route to redirect to the email that we send
// Route::get('mailable', function () {
//     $post = Post::findOrFail(1);
//     return new PostUpdatedAdminMessage($post);
// });

// fallback route MUST be inserted at the end of web.php
Route::get("{any?}", function () {
    return view('guest.home');
})->where('any', '.*');

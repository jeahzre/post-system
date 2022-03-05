<?php

use App\Mail\NewUserWelcomeMail;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

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
//   return view('welcome');
// });

Auth::routes();

Route::post('follow/{user}', [\App\Http\Controllers\FollowsController::class, 'store']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/email', function () {
  return new NewUserWelcomeMail();
});

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit']);
Route::patch('/profile/{user}',   [App\Http\Controllers\ProfilesController::class, 'update']);

Route::get('/', [App\Http\Controllers\PostController::class, 'index']);
Route::get('/p/create', [App\Http\Controllers\PostController::class, 'create'])->name('p.create');
Route::get('/p/{post}', [App\Http\Controllers\PostController::class, 'show']);
Route::post('/p', [App\Http\Controllers\PostController::class, 'store']);
Route::delete('/p/{post}', [App\Http\Controllers\PostController::class, 'destroy']);

Route::post('/comment/{post}', [App\Http\Controllers\CommentController::class, 'store']);

Route::post('/p/like/{post}', [App\Http\Controllers\PostLikeController::class, 'store']);

Route::get('/explore', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore');

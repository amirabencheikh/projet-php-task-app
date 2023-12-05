<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\SocialLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->controller()
    ->middleware('can:admin')
    ->group(function () {

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/users/delete/{user}', [UserController::class, 'remove'])->name('users.remove');
        Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('/users/edit/{user}', [UserController::class, 'update'])->name('users.update');
    });



Route::controller(TaskController::class)
    ->name('task.')
    ->group(function () {

        Route::get('/task', 'index')->name('index');
        Route::get('/task/assigned', 'MyTask')->name('MyTask');
        Route::get('/task/{task}', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/task/edit/{task}', 'edit')->name('edit');
        Route::post('/task/edit/{task}', 'update')->name('update');
        Route::get('/task/delete/{task}', 'remove')->name('remove');
        Route::get('/task/assign/{task}', 'assignView')->name('assignView');
        Route::post('/task/assign/{task}', 'assign')->name('assign');

        Route::post('/startTask/{task}', 'startTask')->name('startTask');
        Route::post('/maskAsTermined/{task}', 'maskAsTermined')->name('maskAsTermined');
    })->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('login/google',[SocialLoginController::class, 'redirectToGoogle']);
Route::get('login/google/callback',[SocialLoginController::class, 'handleGoogleCallback']);

Route::get('login/facebook',[SocialLoginController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback',[SocialLoginController::class, 'handleFacebookCallback']);

require __DIR__ . '/auth.php';

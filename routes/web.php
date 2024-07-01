<?php

use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\MyAuthController;
use App\Http\Controllers\User\UserController;
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
//     return view('welcome');
// });
Route::get('/login', [MyAuthController::class, 'login'])->name('login');
Route::post('/login', [MyAuthController::class, 'proc_login']);
Route::group(['middleware' => 'my_sys'], function() {
    Route::get('/', [UserController::class, 'home'])->name('sys_user.home');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'users'], function() {
        Route::get('', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/edit/{user}', [UserController::class, 'update']);
        Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::group(['prefix' => 'documents'], function() {
        Route::get('', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/create', [DocumentController::class, 'store']);
        Route::get('/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/edit/{document}', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::post('/edit/{document}', [DocumentController::class, 'update']);
        Route::get('/delete/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    });
    
});
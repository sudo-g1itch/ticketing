<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('client')->group(function () {
    Route::middleware(['auth:client_guard'])->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('/create-ticket', [App\Http\Controllers\TicketController::class, 'create']); 
        Route::get('/view-all-tickets', [App\Http\Controllers\TicketController::class, 'indexAll']); 
    });
});

Route::post('/tickets/store', [App\Http\Controllers\TicketController::class, 'store']);
Route::post('/comment/store/{id}', [App\Http\Controllers\CommentController::class, 'store']);
Route::get('/view/{id}', [App\Http\Controllers\TicketController::class, 'show']); 
// Auth::routes();

Route::post('logout', [App\Http\Controllers\Auth\LoginController::class , 'logout'])->name('logout');
Route::get('login-user', [App\Http\Controllers\Auth\LoginController::class , 'login'])->name('login-user');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/error', function (){
     return response()->json('failed');
});




Route::get('/view-tickets', [App\Http\Controllers\TicketController::class, 'index']); 
Route::get('/edit/{id}', [App\Http\Controllers\TicketController::class, 'edit']); 

Route::get('/support', [App\Http\Controllers\CommentController::class, 'support']);
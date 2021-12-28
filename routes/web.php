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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/create-ticket', [App\Http\Controllers\TicketController::class, 'create']); 
Route::post('/tickets/store', [App\Http\Controllers\TicketController::class, 'store']);
Route::post('/comment/store/{id}', [App\Http\Controllers\CommentController::class, 'store']);
Route::get('/view-all-tickets', [App\Http\Controllers\TicketController::class, 'indexAll']); 
Route::get('/view/{id}', [App\Http\Controllers\TicketController::class, 'show']); 


Route::middleware(['auth'])->group(function () {
    Route::get('/view-tickets', [App\Http\Controllers\TicketController::class, 'index']); 
    Route::get('/edit/{id}', [App\Http\Controllers\TicketController::class, 'edit']); 
});

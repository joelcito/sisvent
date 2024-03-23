<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){

    Route::get('/home', [HomeController::class, 'index']);

    Route::prefix('/cliente')->group(function(){
        Route::get('/listado', [ClienteController::class, 'listado']);
        Route::post('/ajaxListado', [ClienteController::class, 'ajaxListado']);
        Route::post('/guardarCliente', [ClienteController::class, 'guardarCliente']);
        Route::post('/eliminarCliente', [ClienteController::class, 'eliminarCliente']);
        
    });

    // AQUI CODIGO DE YERAA!!!
});
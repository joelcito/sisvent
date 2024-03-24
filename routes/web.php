<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;
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

     Route::prefix('/venta')->group(function(){
        Route::get('/listado', [VentaController::class, 'listado']);
        Route::post('/ajaxListado', [VentaController::class, 'ajaxListado']);
        Route::post('/guardarVenta', [VentaController::class, 'guardarVenta']);
        Route::post('/eliminarVenta', [VentaController::class, 'eliminarVenta']);
  
    });

    Route::prefix('/sucursal')->group(function(){
        Route::get('/listado', [SucursalController::class, 'listado']);
        Route::post('/ajaxListado', [SucursalController::class, 'ajaxListado']);
        Route::post('/guardarSucursal', [SucursalController::class, 'guardarSucursal']);
        Route::post('/eliminarSucursal', [SucursalController::class, 'eliminarSucursal']);

    });
       
    Route::prefix('/categoria')->group(function(){
        Route::get('/listado', [CategoriaController::class, 'listado']);
        Route::post('/ajaxListado', [CategoriaController::class, 'ajaxListado']);
        Route::post('/guardarCategoria', [CategoriaController::class, 'guardarCategoria']);
        Route::post('/eliminarCategoria', [CategoriaController::class, 'eliminarCategoria']);

    });


});

    


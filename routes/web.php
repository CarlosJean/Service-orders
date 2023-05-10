<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrdersSupController;
use App\Http\Controllers\GestionMaterialesController;
use App\Http\Controllers\GestionMaterialesBTNController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\ServiciosController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" smiddleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('asignar-tecnico', function(){
    return view('orders.assign_technician');
});

Route::get('registro-empleado/{id?}', [EmployeesController::class, 'index']);
Route::post('registro-empleado/{id?}', [EmployeesController::class, 'store']);
Route::get('employees', [EmployeesController::class, 'getEmployees']);

Route::get('registro-empleado', [EmployeesController::class, 'index']);
Route::post('registro-empleado', [EmployeesController::class, 'store']);
Route::get('/orders', [OrdersController::class, 'index']);
Route::get('/ordersSup', [OrdersSupController::class, 'index']);
Route::get('/GestionMateriales', [GestionMaterialesController::class, 'index']);
Route::get('/GestionMaterialesBTN', [GestionMaterialesBTNController::class, 'index']);
Route::get('/departamentos', [DepartamentosController::class, 'index']);
Route::get('/servicios', [ServiciosController::class, 'index']);


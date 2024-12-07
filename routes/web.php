<?php

use App\Http\Controllers\CustomerController;
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

Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::delete('customers/delete/{id}', [CustomerController::class, 'delete'])->name('customers.delete');
Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');

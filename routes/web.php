<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\CategoriesController;
use App\Livewire\CoinsController;
use App\Livewire\PosController;
use App\Livewire\ProductsController;
use App\Livewire\RolesController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('categories', CategoriesController::class);
Route::get('products', ProductsController::class);
Route::get('coins', CoinsController::class);
Route::get('pos', PosController::class);
Route::get('roles', RolesController::class);

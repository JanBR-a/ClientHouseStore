<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopcartController;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', [HomeController::class, 'index']);

Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');
Route::put('/properties/update/{id}', [PropertyController::class, 'update']);
Route::delete('/properties/delete/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
Route::post('/', [HomeController::class, 'store'])->name('properties.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');

Route::get('/shopcart', [ShopcartController::class, 'index'])->name('shopcart.index');
Route::post('/shopcart/add', [ShopcartController::class, 'add'])->name('shopcart.add');
Route::post('/shopcart/remove', [ShopcartController::class, 'remove'])->name('shopcart.remove');
Route::post('/shopcart/checkout', [ShopcartController::class, 'checkout'])->name('shopcart.checkout');


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as AuthController;

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

Route::get("/" , [AuthController::class , 'index'])->name("user.register");
Route::Post("/registered" , [AuthController::class , 'store'])->name("user.store");
Route::Post("/check_email" , [AuthController::class , 'check_email'])->name("user.check.email");
Route::get("allUsers" , [AuthController::class , 'allUsers'])->name("all.users");
Route::get("notifications" , [AuthController::class , 'notifications'])->name("all.notifications");

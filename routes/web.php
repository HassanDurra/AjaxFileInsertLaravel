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

Route::get("/registeration" , [AuthController::class , 'index'])->name("user.register");
Route::Post("/registered" , [AuthController::class , 'store'])->name("user.store");
Route::Post("/changeId" , [AuthController::class , 'changeIds'])->name("change.ids");
Route::Post("/check_email" , [AuthController::class , 'check_email'])->name("user.check.email");
Route::get("notifications" , [AuthController::class , 'notifications'])->name("all.notifications");
Route::get("/" , [AuthController::class,'login'])->name('Auth.login');
Route::post("user_login" , [AuthController::class,'authenticate'])->name('Auth.signing');
Route::get('/checkingSession'  , [AuthController::class , 'checkSession'])->name('check.session');
Route::get("/generateOtp" , [AuthController::class , 'generate_otp'])->name("otp.generate");
Route::prefix('admin')->middleware(['admin'])->group(function () {
Route::get("/" , [AuthController::class , 'allUsers'])->name("all.users");
Route::get("/logout" , [AuthController::class , 'logout'])->name("logout");
});

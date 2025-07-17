<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     // return view('app');
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('traveler.travelerLogin');
// });


// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TravelerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// */

Route::get('/', function () {
    return view('welcome'); // landing blade
})->name('landing');

// Redirect root to traveler login
// Route::get('/', function () {
//     return redirect()->route('traveler.travelerLogin');
// });

//Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Traveler specific routes
    Route::get('/traveler/login', [TravelerController::class, 'showLoginForm'])->name('traveler.travelerLogin');
    Route::post('/traveler/login', [TravelerController::class, 'login'])->name('traveler.login');
    
    Route::get('/traveler/register', [TravelerController::class, 'showRegistrationForm'])->name('traveler.travelerRegister');
    Route::post('/traveler/register', [TravelerController::class, 'register'])->name('traveler.register');
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    //staff
    Route::get('/staff/login', [LoginController::class, 'showStaffLoginForm'])->name('staff.login');
    Route::post('/staff/login', [LoginController::class, 'staffLogin']);

    // Admin
    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminLogin']);


});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Traveler protected routes
    Route::prefix('traveler')->group(function () {
        Route::get('/dashboard', [TravelerController::class, 'dashboard'])->name('traveler.dashboard');
        Route::post('/logout', [TravelerController::class, 'logout'])->name('traveler.logout');
    });
    
    // Add your luggage management routes here
    Route::prefix('luggage')->group(function () {
        Route::get('/', function () {
            return view('luggage.index');
        })->name('luggage.index');
        
        Route::get('/track', function () {
            return view('luggage.track');
        })->name('luggage.track');
        
        Route::get('/lost', function () {
            return view('luggage.lost');
        })->name('luggage.lost');
    });
});

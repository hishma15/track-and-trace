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
use App\Http\Controllers\Auth\AdminLoginController;
// use App\Http\Controllers\Auth\RegisterController;
// use App\Http\Controllers\Auth\ForgotPasswordController;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TravelerController;
use App\Http\Controllers\StaffController;

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

Route::view('/about', 'aboutUs')->name('about');

// Redirect root to traveler login
// Route::get('/', function () {
//     return redirect()->route('traveler.travelerLogin');
// });

//Authentication Routes
Route::middleware('guest')->group(function () {
    // Route::get('/login', [TravelerController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [TravelerController::class, 'login']);
    
    // Traveler specific routes
    Route::get('/traveler/login', [TravelerController::class, 'showLoginForm'])->name('traveler.travelerLogin');
    Route::post('/traveler/login', [TravelerController::class, 'login'])->name('traveler.login');
    
    Route::get('/traveler/register', [TravelerController::class, 'showRegistrationForm'])->name('traveler.travelerRegister');
    Route::post('/traveler/register', [TravelerController::class, 'register'])->name('traveler.register');
    
    // Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    // Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


    Route::get('/staff/login', [StaffController::class, 'showStaffLoginForm'])->name('staff.staffLogin');
    Route::post('/staff/login', [StaffController::class, 'login'])->name('staff.login');

    //staff
    Route::get('/staff/register', [StaffController::class, 'showStaffRegistrationForm'])->name('staff.staffRegister');
    Route::post('/staff/register', [StaffController::class, 'register'])->name('staff.register');

    // Admin
    Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'adminLogin']);


});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Traveler protected routes
    Route::prefix('traveler')->group(function () {
        Route::get('/dashboard', [TravelerController::class, 'dashboard'])->name('traveler.travelerDashboard');
        Route::post('/logout', [TravelerController::class, 'logout'])->name('traveler.logout');
    

        // Update profile routes here
        Route::get('/profile', [TravelerController::class, 'showProfileForm'])->name('traveler.profile.show');
        Route::post('/profile', [TravelerController::class, 'updateProfile'])->name('traveler.profile.update');
        Route::post('/profile/password', [TravelerController::class, 'updatePassword'])->name('traveler.profile.updatePassword');
        //Delete acccount 
        Route::delete('/traveler/profile/delete', [TravelerController::class, 'destroy'])->name('traveler.profile.destroy');

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

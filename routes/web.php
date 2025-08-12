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
use App\Http\Controllers\LuggageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;

use App\Http\Controllers\QRScanController;

use Illuminate\Support\Facades\Storage;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


    // Admin
    Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm'])->name('admin.adminLogin');
    Route::post('/admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');



});

// Protected Routes
Route::middleware('auth')->group(function () {
    
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

        Route::post('/traveler/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        // Route::get('/traveler/feedback', [FeedbackController::class, 'create'])->name('feedback.create');  //If having a feedback view blade file

        
        

    });

    Route::prefix('staff')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.staffDashboard');
        Route::post('/logout', [StaffController::class, 'logout'])->name('staff.logout');


    });

    // Show the staff registration form (GET)
        Route::get('/admin/staff/register', [AdminController::class, 'showStaffRegistrationForm'])->name('staff.register.form');
        Route::post('/admin/staff/register', [AdminController::class, 'registerStaff'])->name('staff.register');
        Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.adminDashboard');
        Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/admin/staff/{id}', [AdminController::class, 'showStaff'])->name('admin.staff.show');
        Route::post('/admin/staff/{id}/profile', [AdminController::class, 'updateProfile'])->name('staff.profile.update');
        Route::post('/admin/staff/{id}/password', [AdminController::class, 'updatePassword'])->name('staff.profile.updatePassword');
        Route::delete('/admin/staff/{id}/profile', [AdminController::class, 'destroy'])->name('staff.profile.destroy');
        Route::get('/admin/staff/{id}/profile', [AdminController::class, 'showStaff'])->name('staff.profile.show');
        Route::get('/profile', [StaffController::class, 'showProfileForm'])->name('staff.profile.show');





    


    // Add your luggage management routes here
    Route::prefix('luggage')->group(function () {

        // Luggage Registration Routes
        Route::get('/register', [LuggageController::class, 'create'])->name('luggage.create');
        Route::post('/register', [LuggageController::class, 'store'])->name('luggage.store');

        Route::get('/', [LuggageController::class, 'index'])->name('luggage.index'); 

        // Route::put('/luggages/{id}', [LuggageController::class, 'update'])->name('luggage.update');
        Route::put('/{id}', [LuggageController::class, 'update'])->name('luggage.update');
        Route::delete('/{id}', [LuggageController::class, 'destroy'])->name('luggage.destroy');

        Route::get('/traveler/report-lost-luggage', [LuggageController::class, 'reportlostluggage'])->name('traveler.reportlostluggage');
        Route::put('/{luggage}/mark-lost', [LuggageController::class, 'markLost'])->name('luggage.markLost');
        Route::put('/{luggage}/cancel-report', [LuggageController::class, 'cancelLostReport'])->name('luggage.cancelReport');




    });

            // QR Code routes
        Route::post('/luggage/{id}/generate-qr', [LuggageController::class, 'generateQrCode'])->name('luggage.generate-qr');
        Route::get('/luggage/{id}/download-qr', [LuggageController::class, 'downloadQrCode'])->name('luggage.download-qr');



    // QR Scanner page for staff
    Route::get('/staff/qr-scanner', [QRScanController::class, 'showScanner'])->name('staff.qr-scanner');
    
    // API routes for QR scanning
    Route::prefix('api/qr-scan')->group(function () {
        
        // Get luggage details by ID
        Route::get('/luggage/{luggage_id}', [QRScanController::class, 'getLuggageDetails'])
            ->name('api.qr-scan.luggage-details');
        
        // Mark luggage as found
        Route::post('/luggage/{luggage_id}/found', [QRScanController::class, 'markAsFound'])
            ->name('api.qr-scan.mark-found');
        
        // Get scan history
        Route::get('/luggage/{luggage_id}/history', [QRScanController::class, 'getScanHistory'])
            ->name('api.qr-scan.history');
        
        // Get staff dashboard stats
        Route::get('/stats', [QRScanController::class, 'getStaffStats'])
            ->name('api.qr-scan.stats');
    });

});

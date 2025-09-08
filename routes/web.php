<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\TravelerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LuggageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QRScanController;
use App\Http\Controllers\AdminStatisticsController;

use App\Http\Controllers\Auth\TravelerPasswordResetController;
use App\Http\Controllers\Auth\StaffPasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); // Landing page
})->name('landing');

Route::view('/about', 'aboutUs')->name('about');

/*
|--------------------------------------------------------------------------
| Guest Routes (not authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Traveler login & registration
    Route::get('/traveler/login', [TravelerController::class, 'showLoginForm'])->name('traveler.travelerLogin');
    Route::post('/traveler/login', [TravelerController::class, 'login'])->name('traveler.login');

    Route::get('/traveler/register', [TravelerController::class, 'showRegistrationForm'])->name('traveler.travelerRegister');
    Route::post('/traveler/register', [TravelerController::class, 'register'])->name('traveler.register');

    // Staff login
    Route::get('/staff/login', [StaffController::class, 'showStaffLoginForm'])->name('staff.staffLogin');
    Route::post('/staff/login', [StaffController::class, 'login'])->name('staff.login');

    // Admin login
    Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm'])->name('admin.adminLogin');
    Route::post('/admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');

    // Reset and forgot password [traveler]
    Route::get('traveler/forgot-password', [TravelerPasswordResetController::class, 'showLinkRequestForm'])->name('traveler.password.request');
    Route::post('traveler/forgot-password', [TravelerPasswordResetController::class, 'sendResetLink'])->name('traveler.password.email');
    Route::get('traveler/reset-password/{token}', [TravelerPasswordResetController::class, 'showResetForm'])->name('traveler.password.reset');
    Route::post('traveler/reset-password', [TravelerPasswordResetController::class, 'resetPassword'])->name('traveler.password.update');

    // Reset and forgot password [staff]
    Route::get('staff/forgot-password', [StaffPasswordResetController::class, 'showLinkRequestForm'])->name('staff.password.request');
    Route::post('staff/forgot-password', [StaffPasswordResetController::class, 'sendResetLink'])->name('staff.password.email');
    Route::get('staff/reset-password/{token}', [StaffPasswordResetController::class, 'showResetForm'])->name('staff.password.reset');
    Route::post('staff/reset-password', [StaffPasswordResetController::class, 'resetPassword'])->name('staff.password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Traveler Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('traveler')->group(function () {

        Route::get('/dashboard', [TravelerController::class, 'dashboard'])->name('traveler.travelerDashboard');
        Route::get('/verify-otp', [TravelerController::class, 'showOtpForm'])->name('traveler.verify-otp');
        Route::post('/verify-otp', [TravelerController::class, 'verifyOtp'])->name('traveler.otp.verify');
        Route::post('/resend-otp', [TravelerController::class, 'resendOtp'])->name('traveler.otp.resend');
        Route::post('/logout', [TravelerController::class, 'logout'])->name('traveler.logout');

        Route::post('/toggle-2fa', [TravelerController::class, 'toggle2FA'])->name('traveler.toggle-2fa');


        // Profile
        Route::get('/profile', [TravelerController::class, 'showProfileForm'])->name('traveler.profile.show');
        Route::post('/profile', [TravelerController::class, 'updateProfile'])->name('traveler.profile.update');
        Route::post('/profile/password', [TravelerController::class, 'updatePassword'])->name('traveler.profile.updatePassword');
        Route::delete('/profile/delete', [TravelerController::class, 'destroy'])->name('traveler.profile.destroy');

        // Feedback
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // Luggage management
        Route::get('/my-luggages', [LuggageController::class, 'index'])->name('traveler.myLuggages');
        Route::get('/luggage/register', [LuggageController::class, 'create'])->name('luggage.create');
        Route::post('/luggage/register', [LuggageController::class, 'store'])->name('luggage.store');
        Route::put('/luggage/{id}/update', [LuggageController::class, 'update'])->name('luggage.update');
        Route::delete('/luggage/{id}/delete', [LuggageController::class, 'destroy'])->name('luggage.destroy');

        // Lost luggage
        Route::get('/luggage/lost', [LuggageController::class, 'lostLuggage'])->name('traveler.lostLuggage');
        Route::get('/luggage/lost/reports', [LuggageController::class, 'lostLuggageReports'])->name('traveler.lostLuggageReports');
        Route::get('/report-lost-luggage', [LuggageController::class, 'reportLostLuggage'])->name('traveler.reportlostluggage');
        Route::put('/{luggage}/mark-lost', [LuggageController::class, 'markLost'])->name('luggage.markLost');
        Route::put('/{luggage}/cancel-report', [LuggageController::class, 'cancelLostReport'])->name('luggage.cancelReport');

        // QR code (generate/download)
        Route::post('/luggage/{id}/generate-qr', [LuggageController::class, 'generateQrCode'])->name('luggage.generate-qr');
        Route::get('/luggage/{id}/download-qr', [LuggageController::class, 'downloadQrCode'])->name('luggage.download-qr');

        Route::get('/notifications', [TravelerController::class, 'notifications'])->name('traveler.notification');
        Route::get('/notifications/{id}', [TravelerController::class, 'viewNotification'])->name('traveler.notification.details');

        
    });

    /*
    |--------------------------------------------------------------------------
    | Staff Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('staff')->group(function () {

        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.staffDashboard');
        Route::get('/verify-otp', [StaffController::class, 'showOtpForm'])->name('staff.verify-otp');
        Route::post('/verify-otp', [StaffController::class, 'verifyOtp'])->name('staff.otp.verify');
        Route::post('/resend-otp', [StaffController::class, 'resendOtp'])->name('staff.otp.resend');
        Route::post('/logout', [StaffController::class, 'logout'])->name('staff.logout');

        Route::post('/toggle-2fa', [StaffController::class, 'toggle2FA'])->name('staff.toggle-2fa');

        // Profile
        Route::get('/profile', [StaffController::class, 'showProfileForm'])->name('staff.profile.show');
        Route::post('/profile', [StaffController::class, 'updateProfile'])->name('staff.profile.update');
        Route::post('/profile/password', [StaffController::class, 'updatePassword'])->name('staff.profile.updatePassword');

        // Notifications
        Route::get('/luggage/{id}', [LuggageController::class, 'show'])->name('luggage.show');

        Route::get('/notifications', [StaffController::class, 'notifications'])->name('staff.notifications');

        // Lost luggages
        Route::get('/lost-luggages', [LuggageController::class, 'staffLostLuggages'])->name('staff.lost_luggages');

        // Manual lookup
        // Route::get('/manual-lookup', [LuggageController::class, 'showManualLookup'])->name('staff.manualLookup');
        // Route::get('/manual-lookup/api/{uniqueCode}', [LuggageController::class, 'lookupByUniqueCode'])->name('staff.lookupByUniqueCode');
        Route::post('/manual-lookup/mark-found/{id}', [LuggageController::class, 'markAsFoundManual'])->name('staff.markAsFoundManual');
        // Route::get('/manual-lookup/{unique_code}', [StaffController::class, 'manualLookup']);
        
        // Manual lookup page
        Route::get('/manual-lookup', [LuggageController::class, 'showManualLookup'])->name('staff.manualLookup');

        // Fetch luggage by unique code (browser-accessible)
        Route::get('/manual-lookup/{unique_code}', [LuggageController::class, 'manualLookup'])->name('staff.manualLookup.fetch');

        // Optional: API route
        Route::get('/manual-lookup/api/{uniqueCode}', [LuggageController::class, 'lookupByUniqueCode'])->name('staff.lookupByUniqueCode');

        // QR Scanner
        Route::get('/qr-scanner', [QRScanController::class, 'showScanner'])->name('staff.qr-scanner');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        // Dashboard & OTP
        Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.adminDashboard');
        Route::get('/verify-otp', [AdminLoginController::class, 'showOtpForm'])->name('admin.verify-otp');
        Route::post('/verify-otp', [AdminLoginController::class, 'verifyOtp'])->name('admin.verify-otp.submit');
        Route::get('/resend-otp', [AdminLoginController::class, 'resendOtp'])->name('admin.resend-otp');

        // Statistics routes
    Route::get('/statistics', [AdminStatisticsController::class, 'dashboard'])->name('statistics');
    Route::get('/statistics/advanced', [AdminStatisticsController::class, 'getAdvancedStats'])->name('statistics.advanced');
    Route::get('/statistics/export', [AdminStatisticsController::class, 'exportStatistics'])->name('statistics.export');
    Route::get('/statistics/realtime', [AdminStatisticsController::class, 'getRealtimeUpdates'])->name('statistics.realtime');

        // Staff management
        Route::get('/manage-staff', [AdminController::class, 'manageStaff'])->name('staff.manage');
        Route::get('/staff/register', [AdminController::class, 'showStaffRegistrationForm'])->name('staff.register.form');
        Route::post('/staff/register', [AdminController::class, 'registerStaff'])->name('staff.register');

        Route::get('/staff/{id}', [AdminController::class, 'showStaff'])->name('admin.staff.show');
        Route::get('/staff/{id}/profile', [AdminController::class, 'showStaff'])->name('admin.staff.profile.show');
        Route::post('/staff/{id}/profile', [AdminController::class, 'updateProfile'])->name('staff.profile.update');
        // Route::post('/staff/{id}/password', [AdminController::class, 'updatePassword'])->name('staff.profile.updatePassword');
        Route::delete('/staff/{id}/profile', [AdminController::class, 'destroy'])->name('staff.profile.destroy');

        Route::post('/staff/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('staff.profile.resetPassword');

        // view users
        Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');


        // feedback
        Route::get('/admin/feedback', [AdminController::class, 'viewFeedback'])->name('admin.feedback');
        Route::post('/admin/feedback/respond/{id}', [AdminController::class, 'respondFeedback'])->name('admin.feedback.respond');

    });

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    /*
    |--------------------------------------------------------------------------
    | API Routes for QR Scanning
    |--------------------------------------------------------------------------
    */
    Route::prefix('api/qr-scan')->group(function () {
        Route::get('/luggage/{luggage_id}', [QRScanController::class, 'getLuggageDetails'])->name('api.qr-scan.luggage-details');
        Route::post('/luggage/{luggage_id}/found', [QRScanController::class, 'markAsFound'])->name('api.qr-scan.mark-found');
        Route::get('/luggage/{luggage_id}/history', [QRScanController::class, 'getScanHistory'])->name('api.qr-scan.history');
        Route::get('/stats', [QRScanController::class, 'getStaffStats'])->name('api.qr-scan.stats');
    });
});

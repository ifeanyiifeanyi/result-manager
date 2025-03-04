<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AcademicSessionController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Student\ApplicationProcessController;
use App\Http\Controllers\Student\StudentProfileController;

Route::get('/', function () {
    return view('welcome');
});


// Custom verification route
// Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
//     ->name('verification.verify');

Route::get('dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('admin.dashboard');
    });

    Route::controller(AdminProfileController::class)->group(function () {
        Route::get('profile', 'index')->name('admin.profile');
        Route::put('profile/update', 'update')->name('admin.profile.update');
        Route::put('profile/update-password', 'updatePassword')->name('admin.profile.update-password');
        Route::post('profile/update-photo', 'updatePhoto')->name('admin.profile.update-photo');
        Route::delete('profile/delete-photo', 'deletePhoto')->name('admin.profile.delete-photo');
        Route::post('profile/logout-session/{session}', 'logoutSession')->name('admin.profile.logout-session');
        Route::post('profile/logout-all', 'logoutAllSessions')->name('admin.profile.logout-all');
    });

    Route::controller(SchoolController::class)->group(function () {
        Route::get('school-settings', 'index')->name('admin.school-settings');
        Route::get('school-settings/details', 'show')->name('admin.school-settings.show');
        Route::post('school-settings', 'update')->name('admin.school-settings.update');
    });

    Route::controller(AcademicSessionController::class)->group(function () {
        Route::get('academic-sessions', 'index')->name('admin.academic-sessions');
        Route::post('academic-sessions', 'store')->name('admin.academic-sessions.store');
        Route::get('academic-sessions/{academicSession}', 'show')->name('admin.academic-sessions.show');
        Route::put('academic-sessions/{academicSession}', 'update')->name('admin.academic-sessions.update');
        Route::delete('academic-sessions/{academicSession}', 'destroy')->name('admin.academic-sessions.destroy');
        Route::patch('academic-sessions/{academicSession}/toggle-active', 'toggleActive')->name('admin.academic-sessions.toggle-active');
    });

    Route::controller(QuestionsController::class)->group(function () {
        Route::get('questions', 'index')->name('admin.questions');
        Route::get('questions/create', 'create')->name('admin.questions.create');
        Route::post('bulk-questions', 'storeBulk')->name('admin.questions.storeBulk');

        Route::get('questions/{question}/edit', 'edit')->name('admin.questions.edit');
        Route::put('questions/{question}', 'update')->name('admin.questions.update');
        Route::delete('questions/{question}', 'destroy')->name('admin.questions.destroy');


        Route::post('questions/reorder', 'reorder')->name('admin.questions.reorder');
    });

    Route::controller(ApplicationController::class)->group(function () {
        Route::get('applications', 'index')->name('admin.applications');
        Route::get('applications/{application}', 'show')->name('admin.applications.show');
    });

    Route::controller(AdminStudentController::class)->group(function () {
        Route::get('students', 'index')->name('admin.students');
        Route::get('students/create', 'create')->name('admin.students.create');
        Route::get('students/{student}/edit', 'edit')->name('admin.students.edit');
        Route::post('students', 'store')->name('admin.students.store');
        Route::put('students/{student}', 'update')->name('admin.students.update');
        Route::delete('students/{student}', 'destroy')->name('admin.students.destroy');
        Route::get('students/{student}', 'show')->name('admin.students.show');

        Route::patch('students/{student}/toggle-active', 'toggleActive')->name('admin.students.toggle-active');
        Route::patch('students/{student}/toggle-blacklist', 'toggleBlacklist')->name('admin.students.toggle-blacklist');
        Route::post('students/{student}/reset-password', 'resetPassword')->name('admin.students.reset-password');
        Route::post('students/{student}/send-verification-email', 'sendVerificationEmail')->name('admin.students.send-verification-email');
    });

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->middleware('auth')->name('admin.analytics');
});


Route::prefix('student')->middleware(['auth', 'verified', 'role:student'])->group(function () {

    Route::controller(StudentController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('student.dashboard');
        Route::post('logout', 'logout')->name('student.logout');
    });



    Route::controller(StudentProfileController::class)->group(function () {
        Route::get('profile', 'show')->name('student.profile.show');
        Route::put('profile', 'update')->name('student.profile.update');
        Route::post('profile/photo', 'updatePhoto')->name('student.profile.photo');
        Route::put('profile/password', 'updatePassword')->name('student.profile.password');
        Route::post('profile/logout-session', 'logoutSession')->name('student.profile.logout_session');

    });

    Route::controller(ApplicationProcessController::class)->group(function(){
        Route::get('application', 'showApplicationForm')->name('student.application.start');
        Route::post('application/submit', 'submitApplication')->name('student.application.submit');
    });
});


require __DIR__ . '/auth.php';

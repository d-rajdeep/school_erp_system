<?php

use App\Http\Controllers\AcademicYearController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SchoolAdmin\DashboardController as SchoolAdminDashboard;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentAdmissionController;
use App\Http\Controllers\StudentRegisterController;
use App\Models\AcademicYear;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login.form');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');


Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super-admin')
    ->name('super_admin.')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/schools', [SchoolController::class, 'index'])
            ->name('schools.index');

        Route::get('/schools/create', [SchoolController::class, 'create'])
            ->name('schools.create');

        Route::post('/schools/store', [SchoolController::class, 'store'])
            ->name('schools.store');

        Route::get('/schools/{id}/edit', [SchoolController::class, 'edit'])
            ->name('schools.edit');

        Route::post('/schools/{id}/update', [SchoolController::class, 'update'])
            ->name('schools.update');

        Route::get('/schools/{id}/delete', [SchoolController::class, 'destroy'])
            ->name('schools.delete');
    });


Route::middleware(['auth', 'role:school_admin', 'tenant'])
    ->prefix('school-admin')
    ->name('school_admin.')
    ->group(function () {


        Route::get('/academic_year', [AcademicYearController::class, 'index'])->name('year.index');
        Route::get('/academic_year/create', [AcademicYearController::class, 'create'])->name('year.create');
        Route::post('/academic_year/store', [AcademicYearController::class, 'store'])->name('year.store');
        Route::get('/academic_year/status/{id}', [AcademicYearController::class, 'status'])->name('year.status');
        Route::get('/academic_year/set-year-active', [AcademicYearController::class, 'setYearActive'])->name('setYearActive');
        Route::post('/academic_year/delete', [AcademicYearController::class, 'delete'])->name('year.delete');


        Route::get('/students/register', [StudentRegisterController::class, 'index'])->name('student.register.index');
        Route::get('/student/register', [StudentRegisterController::class, 'create'])->name('student.register.create');
        Route::post('/student/register/store', [StudentRegisterController::class, 'store'])->name('student.register.store');


        Route::get('/dashboard', [SchoolAdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/students', [StudentAdmissionController::class, 'index'])
            ->name('students.index');

        Route::get('/students/create', [StudentAdmissionController::class, 'create'])
            ->name('students.create');

        Route::post('/students/store', [StudentAdmissionController::class, 'store'])
            ->name('students.store');

        Route::get('/students/search', [StudentAdmissionController::class, 'searchStudent'])->name('search');

        Route::get('/students/{id}/edit', [StudentAdmissionController::class, 'edit'])
            ->name('students.edit');

        Route::post('/students/{id}/update', [StudentAdmissionController::class, 'update'])
            ->name('students.update');

        Route::get('/students/{id}/delete', [StudentAdmissionController::class, 'destroy'])
            ->name('students.delete');

        Route::get('/classes', [ClassesController::class, 'index'])
            ->name('classes.index');

        Route::get('/classes/create', [ClassesController::class, 'create'])
            ->name('classes.create');

        Route::post('/classes/store', [ClassesController::class, 'store'])
            ->name('classes.store');

        Route::get('/classes/{id}/edit', [ClassesController::class, 'edit']);


        Route::get('/sections', [SectionController::class, 'index'])
            ->name('sections.index');

        Route::get('/sections/create', [SectionController::class, 'create'])
            ->name('sections.create');

        Route::post('/sections/store', [SectionController::class, 'store'])
            ->name('sections.store');
    });

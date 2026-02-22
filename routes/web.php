<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SchoolAdmin\DashboardController as SchoolAdminDashboard;
use App\Http\Controllers\StudentController;



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

        Route::get('/dashboard', [SchoolAdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/students', [StudentController::class, 'index'])
            ->name('students.index');

        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('students.create');

        Route::post('/students/store', [StudentController::class, 'store'])
            ->name('students.store');

        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])
            ->name('students.edit');

        Route::post('/students/{id}/update', [StudentController::class, 'update'])
            ->name('students.update');

        Route::get('/students/{id}/delete', [StudentController::class, 'destroy'])
            ->name('students.delete');
    });

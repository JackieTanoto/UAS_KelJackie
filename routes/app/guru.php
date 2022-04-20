<?php

use App\Http\Controllers\Guru\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guru\AuthController;
use App\Http\Controllers\Guru\TaskController;
use App\Http\Controllers\Guru\ScheduleController;
use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\AttendanceController;
use App\Http\Controllers\Guru\RaportController;
use App\Http\Controllers\Guru\RoomController;

Route::group(['domain' => ''], function() {
    Route::get('/', function () {
        return view('page.welcome');
    });   
    Route::prefix('guru')->name('guru.')->group(function(){
        Route::get('auth',[AuthController::class, 'index'])->name('auth.index');
        Route::prefix('auth')->name('auth.')->group(function(){
            Route::post('login',[AuthController::class, 'do_login'])->name('login');
            Route::post('register',[AuthController::class, 'do_register'])->name('register');
            Route::post('forgot',[AuthController::class, 'do_forgot'])->name('forgot');
            Route::post('reset',[AuthController::class, 'do_reset'])->name('reset');
        });
        Route::middleware(['auth:guru'])->group(function(){
            Route::get('verification',[AuthController::class, 'verification'])->name('auth.verification');
            Route::post('verify/{auth:email}',[AuthController::class, 'do_verify'])->name('auth.verify');
            Route::get('logout',[AuthController::class, 'do_logout'])->name('auth.logout');
            Route::get('raport/generatePDF', [RaportController::class, 'generatePDF'])->name('raport.generatePDF');
            Route::post('raport/list_kelas', [RaportController::class, 'list_kelas'])->name('raport.list_kelas');
            Route::post('raport/list_siswa', [RaportController::class, 'list_siswa'])->name('raport.list_siswa');
            Route::post('raport/getKehadiran', [RaportController::class, 'getKehadiran'])->name('raport.getKehadiran');
        });
        Route::group(['middleware' => ['auth:guru','verified']], function () {
            Route::redirect('/', 'dashboard', 301);
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('schedule', ScheduleController::class);
            Route::get('schedule/{schedule}/task', [ScheduleController::class, 'task'])->name('schedule.task');
            Route::get('schedule/{schedule}/attendance', [AttendanceController::class, 'index'])->name('schedule.attendance');
            Route::resource('task', TaskController::class);
            Route::get('task/{task}/download', [TaskController::class, 'download'])->name('task.download');
            Route::get('task/{task}/tugas', [TaskController::class, 'downloadTugas'])->name('task.tugas');
            Route::get('task/{task}/progress', [TaskController::class, 'progress'])->name('task.progress');
            Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
            Route::patch('attendance/{attendance}/update', [AttendanceController::class, 'update'])->name('attendance.update');
            Route::resource('raport', RaportController::class);
            Route::resource('profile', ProfileController::class);
            Route::resource('room', RoomController::class);
            // Route::post('raport/{raport}/update', [RaportController::class, 'update'])->name('raport.update');
        });
    });
});
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de Perfil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas Protegidas de Reportes y Usuarios
Route::middleware(['auth'])->group(function () {
    
    // --- SECCIÓN DE REPORTES ---
    // Listado principal (Admin, Empleado, Ciudadano)
    Route::get('/admin/reportes', [ReportesController::class, 'index'])->name('admin.reportes.index');
    
    // Creación de reporte (Ciudadano)
    Route::post('/reports', [ReportesController::class, 'store'])->name('reports.store');
    
    // Gestión de Reportes (Admin)
    Route::get('/admin/reportes/{id}', [ReportesController::class, 'show'])->name('admin.reportes.show');
    Route::post('/admin/reportes/{id}/assign', [ReportesController::class, 'assign'])->name('admin.reportes.assign');
    Route::delete('/admin/reportes/{id}/worker/{worker}', [ReportesController::class, 'detachWorker'])->name('admin.reportes.detach');
    
    // Finalización de Reporte (Empleado/Admin)
    Route::patch('/admin/reportes/{id}/finalizar', [ReportesController::class, 'finalizar'])->name('admin.reportes.finalizar');

    // --- SECCIÓN DE USUARIOS / EMPLEADOS (Solo Admin) ---
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    
});

// EL DASHBOARD SOLO LLEVA 'auth' Y 'verified'
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// LAS RUTAS DE ADMINISTRADOR LLEVAN 'auth' Y 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
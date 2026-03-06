<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
// Ruta para que el ciudadano envíe el reporte
Route::post('/reports', [ReportesController::class, 'store'])->name('reports.store');
// Rutas administrativas
Route::get('/admin/reports', [ReportesController::class, 'index'])->name('admin.reports.index');
Route::get('/admin/reports/{report}', [ReportesController::class, 'show'])->name('admin.reports.show');
Route::post('/admin/reportes/{id}/assign', [\App\Http\Controllers\ReportesController::class, 'assign'])->name('admin.reportes.assign');});
require __DIR__.'/auth.php';
// Ruta para el listado de trabajadores (La que te está dando el error)
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

// Ruta para el formulario de registro de nuevos trabajadores
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');

// Ruta para guardar el trabajador en la base de datos
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
// Ruta para ver el detalle de un reporte y asignar trabajadores
Route::get('/admin/reportes/{id}', [App\Http\Controllers\ReportesController::class, 'show'])->name('admin.reportes.show');
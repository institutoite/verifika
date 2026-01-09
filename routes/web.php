<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SumaController;
use App\Http\Controllers\PracticoController;
use App\Http\Controllers\RestaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Nueva generación de divisiones
Route::get('divisiones/crear-nueva', [App\Http\Controllers\DivisionNuevaController::class, 'create'])->name('divisiones.nueva.create');
Route::post('divisiones/generar-nueva', [App\Http\Controllers\DivisionNuevaController::class, 'generar'])->name('divisiones.nueva.generar');


// Solo rutas de sumas activas
Route::get('sumas/crear', [SumaController::class, 'create'])->name('sumas.create');
Route::post('sumas/generar', [SumaController::class, 'store'])->name('sumas.generar');

// Rutas para restas
Route::get('restas/crear', [RestaController::class, 'create'])->name('restas.create');
Route::post('restas/generar', [RestaController::class, 'store'])->name('restas.store');

// Rutas para multiplicaciones
Route::get('/multiplicaciones/create', [App\Http\Controllers\MultiplicacionController::class, 'create'])->name('multiplicaciones.create');
Route::post('/multiplicaciones/store', [App\Http\Controllers\MultiplicacionController::class, 'store'])->name('multiplicaciones.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
        Route::delete('practicos/{id}', [PracticoController::class, 'destroy'])->name('practicos.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Prácticos
    Route::get('practicos', [PracticoController::class, 'index'])->name('practicos.index');
    Route::get('practicos/{id}/ejercicios', [PracticoController::class, 'ejercicios'])->name('practicos.ejercicios');
    Route::get('practicos/{id}/imprimir-division-procedimiento', [PracticoController::class, 'imprimirDivisionProcedimiento'])->name('practicos.imprimirDivisionProcedimiento');
    Route::get('practicos/{id}/imprimir/{tipo}', [PracticoController::class, 'imprimir'])->name('practicos.imprimir');
    Route::get('practicos/{id}/edit', [PracticoController::class, 'edit'])->name('practicos.edit');
    Route::put('practicos/{id}', [PracticoController::class, 'update'])->name('practicos.update');
});

// Panel de administración (solo admin)
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'userDetail'])->name('users.show');
});

require __DIR__.'/auth.php';

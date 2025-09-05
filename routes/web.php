<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\MovimientoController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');


// Rutas de Responsables
Route::resource('responsables', ResponsableController::class);
Route::get('/responsables', [ResponsableController::class, 'index'])->name('responsables.index');
Route::get('/responsables/create', [ResponsableController::class, 'create'])->name('responsables.create');
Route::post('/responsables', [ResponsableController::class, 'store'])->name('responsables.store');

// Rutas de Ubicaciones
Route::resource('ubicaciones', UbicacionController::class);

// Rutas de Componentes
Route::resource('componentes', ComponenteController::class);

// Rutas de Equipos

Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
Route::get('/equipos/create', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');

// Rutas de Movimientos
Route::get('movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
Route::get('movimientos/create', [MovimientoController::class, 'create'])->name('movimientos.create');
Route::post('movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');
Route::get('movimientos/buscar', [MovimientoController::class, 'buscar'])->name('movimientos.buscar');
Route::get('/movimientos/reporte', [MovimientoController::class, 'reporte'])->name('movimientos.reporte');
Route::post('/movimientos/reporte', [MovimientoController::class, 'generarReporte'])->name('movimientos.generarReporte');
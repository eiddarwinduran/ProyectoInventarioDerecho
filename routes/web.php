<?php

use App\Http\Controllers\IPsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\BajaController;
Route::get('/', function () {
    return view('inicio');
})->name('inicio');


// Rutas de Responsables
Route::resource('responsables', ResponsableController::class);
Route::get('/responsables', [ResponsableController::class, 'index'])->name('responsables.index');
Route::get('/responsables/create', [ResponsableController::class, 'create'])->name('responsables.create');
Route::post('/responsables', [ResponsableController::class, 'store'])->name('responsables.store');

// Rutas de Ubicaciones
Route::resource('ubicaciones', UbicacionController::class)->except(['show']);
Route::get('ubicaciones/buscar', [UbicacionController::class, 'buscar'])->name('ubicaciones.buscar');
// Rutas de Componentes
Route::resource('componentes', ComponenteController::class);

// Rutas de Equipos

Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
Route::get('/equipos/create', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
Route::get('/equipos/buscar', [EquipoController::class, 'buscar'])->name('equipos.buscar');


// Rutas de Movimientos
Route::get('movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
Route::get('movimientos/create', [MovimientoController::class, 'create'])->name('movimientos.create');
Route::post('movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');
Route::get('movimientos/buscar', [MovimientoController::class, 'buscar'])->name('movimientos.buscar');
Route::get('/movimientos/reporte', [MovimientoController::class, 'reporte'])->name('movimientos.reporte');
Route::post('/movimientos/reportes', [MovimientoController::class, 'generarReporte'])->name('movimientos.generarReporte');
Route::match(['get', 'post'], '/movimientos/storeMultiple', [MovimientoController::class, 'storeMultiple'])->name('movimientos.storeMultiple');
Route::get('/movimientos/autocomplete', [MovimientoController::class, 'autocomplete'])->name('movimientos.autocomplete');

//rutas de bajas

Route::get('bajas/buscar', [BajaController::class, 'search'])->name('bajas.search');
Route::get('/bajas', [BajaController::class, 'index'])->name('bajas.index');
Route::get('/bajas/create', [BajaController::class, 'create'])->name('bajas.create');
Route::post('/bajas', [BajaController::class, 'store'])->name('bajas.store');
Route::get('/bajas/reportepdf', [BajaController::class, 'generarReporte'])->name('bajas.generaReporte');
Route::get('/bajas/reporte', [BajaController::class, 'reporte'])->name('bajas.reporte');
Route::get('/bajas/autocomplete', [BajaController::class, 'autocomplete'])->name('bajas.autocomplete');
Route::get('/bajas/get-responsable', [BajaController::class, 'getResponsable'])->name('bajas.getResponsable');

//rutas de ips
Route::get('ips', [IPsController::class, 'index'])->name('ips.index');
Route::get('ips/create', [IPsController::class, 'create'])->name('ips.create');
Route::get('ips/buscar', [IPsController::class, 'buscar'])->name('ips.buscar');
Route::post('ips', [IPsController::class, 'store'])->name('ips.store');
Route::get('ips/{id}/edit', [IPsController::class, 'edit'])->name('ips.edit');
Route::put('ips/{id}', [IPsController::class, 'update'])->name('ips.update');
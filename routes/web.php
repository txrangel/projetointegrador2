<?php

use App\Http\Controllers\DadoConsumoController;
use App\Http\Controllers\DiaDaSemanaController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TanqueController;
use App\Http\Controllers\UnidadeDeMedidaController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Rotas de DadoConsumo
    Route::prefix('dados-consumo')->group(function () {
        Route::get('/', [DadoConsumoController::class, 'index'])->name('dados_consumo.index');
        Route::get('/create', [DadoConsumoController::class, 'create'])->name('dados_consumo.create');
        Route::get('/edit/{id}', [DadoConsumoController::class, 'edit'])->name('dados_consumo.edit');
        Route::post('/store', [DadoConsumoController::class, 'store'])->name('dados_consumo.store');
        Route::put('/update/{id}', [DadoConsumoController::class, 'update'])->name('dados_consumo.update');
        Route::delete('/delete/{id}', [DadoConsumoController::class, 'delete'])->name('dados_consumo.delete');
    });

    // Rotas de Tanques
    Route::prefix('tanques')->group(function () {
        Route::get('/', [TanqueController::class, 'index'])->name('tanques.index');
        Route::get('/create', [TanqueController::class, 'create'])->name('tanques.create');
        Route::get('/edit/{id}', [TanqueController::class, 'edit'])->name('tanques.edit');
        Route::post('/store', [TanqueController::class, 'store'])->name('tanques.store');
        Route::put('/update/{id}', [TanqueController::class, 'update'])->name('tanques.update');
        Route::delete('/delete/{id}', [TanqueController::class, 'delete'])->name('tanques.delete');
    });

    // Rotas de Unidades de Medida
    Route::prefix('unidades-medida')->group(function () {
        Route::get('/', [UnidadeDeMedidaController::class, 'index'])->name('unidades_medida.index');
        Route::get('/create', [UnidadeDeMedidaController::class, 'create'])->name('unidades_medida.create');
        Route::get('/edit/{id}', [UnidadeDeMedidaController::class, 'edit'])->name('unidades_medida.edit');
        Route::post('/store', [UnidadeDeMedidaController::class, 'store'])->name('unidades_medida.store');
        Route::put('/update/{id}', [UnidadeDeMedidaController::class, 'update'])->name('unidades_medida.update');
        Route::delete('/delete/{id}', [UnidadeDeMedidaController::class, 'delete'])->name('unidades_medida.delete');
    });

    // Rotas de DiaDaSemana
    Route::prefix('dias-da-semana')->group(function () {
        Route::get('/', [DiaDaSemanaController::class, 'index'])->name('dias_da_semana.index');
        Route::get('/create', [DiaDaSemanaController::class, 'create'])->name('dias_da_semana.create');
        Route::get('/edit/{id}', [DiaDaSemanaController::class, 'edit'])->name('dias_da_semana.edit');
        Route::post('/store', [DiaDaSemanaController::class, 'store'])->name('dias_da_semana.store');
        Route::put('/update/{id}', [DiaDaSemanaController::class, 'update'])->name('dias_da_semana.update');
        Route::delete('/delete/{id}', [DiaDaSemanaController::class, 'delete'])->name('dias_da_semana.delete');
    });

    // Rotas de Planta
    Route::prefix('plantas')->group(function () {
        Route::get('/', [PlantaController::class, 'index'])->name('plantas.index');
        Route::get('/create', [PlantaController::class, 'create'])->name('plantas.create');
        Route::post('/store', [PlantaController::class, 'store'])->name('plantas.store');
        Route::get('/edit/{id}', [PlantaController::class, 'edit'])->name('plantas.edit');
        Route::put('/update/{id}', [PlantaController::class, 'update'])->name('plantas.update');
        Route::delete('/delete/{id}', [PlantaController::class, 'delete'])->name('plantas.delete');
    });    

    Route::get('/', [TanqueController::class, 'dashboard'])->name('dashboard');
});

require __DIR__.'/auth.php';

<?php
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

// Redireciona a rota raiz '/' para a lista de locais
Route::get('/', function () {
    return redirect()->route('locations.index');
});

// Rotas RESTful para LocationController
Route::resource('locations', LocationController::class);

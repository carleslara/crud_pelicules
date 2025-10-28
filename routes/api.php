<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí pots registrar les rutes de la teva API.
| Aquestes rutes es carreguen pel RouteServiceProvider dins del grup "api".
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutes per a Pel·lícules
Route::resource('pelicula', APIController::class)->only([
    'index', 'store', 'update', 'destroy', 'show'
]);
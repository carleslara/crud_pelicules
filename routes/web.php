<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebPeliculaController;
use App\Models\Pelicula;

/*
| Web routes
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {
    Route::get('/home', [WebPeliculaController::class, 'index'])->name('web.home');
    
    // Mostrar formulari per crear (GET)
    Route::get('/pelicula/create', function () {
        return view('pelicula.create');
    })->name('web.pelicula.create');

    // Processar formulari per crear (POST)
    Route::post('/pelicula', [WebPeliculaController::class, 'store'])->name('web.pelicula.store');

    // Mostrar formulari per editar (GET)
    Route::get('/pelicula/{id}/edit', function ($id) {
        $movie = Pelicula::findOrFail($id);
        return view('pelicula.edit', compact('movie'));
    })->name('web.pelicula.edit');

    // Processar formulari per actualitzar (PUT)
    Route::put('/pelicula/{id}', [WebPeliculaController::class, 'update'])->name('web.pelicula.update');
});

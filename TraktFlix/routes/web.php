<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\PeliculasListaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "Bienvenido";
});

Route::view("/","index");

Route::view("/index","index")->name('index');

Route::view('/welcome', 'welcome');

Route::view('/login', 'login');

Route::view('/registro', 'registro');

Route::view('/listas', 'listas')->name('listas');

Route::view('/detallePelicula', 'detallePelicula');

Route::get('/detallePelicula/{id}', function ($id) {
    return view('detallePelicula', ['peliculaId' => $id]);
});

Route::get('/busqueda/{busqueda?}', function ($busqueda = null) {
    return view('busqueda', ['busqueda' => $busqueda]);
})->name('resultadoBusqueda');

Route::post('/registro', [UserController::class, 'store'])->name('registro');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/creaLista', [ListaController::class, 'store'])->name('creaLista');

Route::post('/anadePeliculaLista', [PeliculasListaController::class, 'store'])->name('anadePeliculaLista');

Route::post('/desactivaPeliculaLista', [PeliculasListaController::class, 'deactivate'])->name('desactivaPeliculaLista');

Route::get('/anadeFavoritas');

Route::get('/compruebaCheck/{lista_id}/{trakt_id}', [PeliculasListaController::class, 'compruebaCheck'])->name('compruebaCheck');

Route::get('/nombreLista/{lista_id}', [ListaController::class, 'getNombreLista'])->name('nombreLista');

Route::get('/listasUsuario', [ListaController::class, 'mostrarListas'])->name('mostrarListas');

Route::view('/indexIniciado', 'indexIniciado')->name('indexIniciado');


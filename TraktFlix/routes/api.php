<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/trending-movies', function () {
    $client = new Client();
    $response = $client->request('GET', 'https://api.trakt.tv/movies/trending', [
        'headers' => [
            'Content-Type' => 'application/json',
            'trakt-api-version' => '2',
            'trakt-api-key' => '494123d3e780c8d1914dbf20767a078d288e7f663fc15888689fc9fa294a0922',
        ]
    ]);

    $trendingMovies = json_decode($response->getBody()->getContents(), true);

    return response()->json($trendingMovies);
});

Route::get('/movie-poster/{id}', function ($id) {
    $client = new Client();
    $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $id.'/images',[
        'query' => [
            'api_key' => '52d24e348c1319667ad9b2eec83523bb',
            'language' => 'es',
        ],
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Fallo al obtener el poster de esta película'], 500);
    }

    $movie = json_decode($response->getBody()->getContents(), true);

    $posterPath = $movie['posters'][0]['file_path'];

    return response()->json(['poster_path' => $posterPath]);
});

Route::get('/datos-pelicula/{id}', function ($id) {
    $client = new Client();
    $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $id,[
        'query' => [
            'api_key' => '52d24e348c1319667ad9b2eec83523bb',
            'language' => 'es'
        ],
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Fallo al obtener los detalles de esta película'], 500);
    }

    $movie = json_decode($response->getBody()->getContents(), true);

    return response()->json($movie);
});

Route::get('/creditos-pelicula/{id}', function ($id){
    $client = new Client();
    $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $id.'/credits',[
        'query' => [
            'api_key' => '52d24e348c1319667ad9b2eec83523bb',
            'language' => 'es'
        ],
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Fallo al obtener los creditos de esta película'], 500);
    }

    $movie = json_decode($response->getBody()->getContents(), true);

    return response()->json($movie);
});

Route::get('/trailer/{id}', function ($id) {
    $client = new Client();
    $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $id.'/videos',[
        'query' => [
            'api_key' => '52d24e348c1319667ad9b2eec83523bb',
            'language' => 'es-ES'
        ],
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Fallo al obtener los creditos de esta película'], 500);
    }

    $movie = json_decode($response->getBody()->getContents(), true);

    return response()->json($movie);
});

Route::get('/busca-peliculas/{busqueda}', function ($busqueda) {
    $client = new Client();
    $response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie',[
        'query' => [
            'api_key' => '52d24e348c1319667ad9b2eec83523bb',
            'language' => 'es-ES',
            'query' => $busqueda
        ],
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    if ($response->getStatusCode() != 200) {
        return response()->json(['error' => 'Fallo al buscar la película'], 500);
    }

    $movies = json_decode($response->getBody()->getContents(), true);

    return response()->json($movies);
});
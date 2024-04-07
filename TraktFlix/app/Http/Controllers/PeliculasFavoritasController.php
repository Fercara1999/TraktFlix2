<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeliculaFavorita;
use Illuminate\Support\Facades\Auth;

class PeliculasFavoritasController extends Controller
{
    public function index()
    {
        $peliculasFavoritas = PeliculaFavorita::all();
        return view('peliculas_favoritas.index', compact('peliculasFavoritas'));
    }

    public function create()
    {
        return view('peliculas_favoritas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trakt_id' => 'required',
        ]);

        $existingFavorita = PeliculaFavorita::where('trakt_id', $request->trakt_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        
        if($existingFavorita){
            $existingFavorita->update(['activo' => true]);
        }else{
            $pelicula_favorita_id = str_pad($request->lista_id, 5, '0', STR_PAD_LEFT) . '_MOV_' . str_pad(PeliculaLista::where('lista_id', $request->lista_id)->count() + 1, 5, '0', STR_PAD_LEFT);
        }

        PeliculaFavorita::create($request->all());

        return redirect()->route('peliculas_favoritas.index')
            ->with('success', 'Pelicula favorita creada exitosamente.');
    }

    public function edit(PeliculaFavorita $peliculaFavorita)
    {
        return view('peliculas_favoritas.edit', compact('peliculaFavorita'));
    }

    public function update(Request $request, PeliculaFavorita $peliculaFavorita)
    {
        $request->validate([
            'titulo' => 'required',
            'genero' => 'required',
            // Agrega aquí las validaciones adicionales que necesites
        ]);

        $peliculaFavorita->update($request->all());

        return redirect()->route('peliculas_favoritas.index')
            ->with('success', 'Pelicula favorita actualizada exitosamente.');
    }

    public function destroy(PeliculaFavorita $peliculaFavorita)
    {
        $peliculaFavorita->delete();

        return redirect()->route('peliculas_favoritas.index')
            ->with('success', 'Pelicula favorita eliminada exitosamente.');
    }
}
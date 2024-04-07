use Illuminate\Http\Request;
use App\Models\PeliculaFavorita;

<?php

namespace App\Http\Controllers;


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
            'titulo' => 'required',
            'genero' => 'required',
            // Agrega aquí las validaciones adicionales que necesites
        ]);

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
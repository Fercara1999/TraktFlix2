<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeliculaLista;
use App\Models\Lista;

class PeliculasListaController extends Controller
{
    public function create()
    {
        // Retorna la vista para crear una nueva película en la lista
        return view('peliculas.create');
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario que recibe como respuesta
        $request->validate([
            'lista_id' => 'required',
            'trakt_id' => 'required',
        ]);

        // Comprueba si ya existe una película en la lista con el mismo trakt_id y lista_id
        $existingPelicula = PeliculaLista::where('lista_id', $request->lista_id)
            ->where('trakt_id', $request->trakt_id)
            ->first();

        if (!$existingPelicula) {
            // Genera el valor de pelicula_lista_id
            $pelicula_lista_id = str_pad($request->lista_id, 5, '0', STR_PAD_LEFT) . '_MOV_' . str_pad(PeliculaLista::where('lista_id', $request->lista_id)->count() + 1, 5, '0', STR_PAD_LEFT);

            // Añade una nueva película en la lista
            PeliculaLista::create([
                'pelicula_lista_id' => $pelicula_lista_id,
                'lista_id' => $request->lista_id,
                'trakt_id' => $request->trakt_id,
                'activo' => true,
            ]);

            // Redirecciona a la página de inicio
            return redirect()->route('listas')->with('success', 'Película agregada correctamente');
        }else if ($existingPelicula && !$existingPelicula->activo) {
            // Actualiza el estado de activo a true
            $existingPelicula->update(['activo' => true]);

            // Redirecciona a la página de inicio
            return redirect()->route('listas')->with('success', 'Película activada correctamente');
        } else {
            // Redirecciona a la página de inicio con un mensaje de error
            return redirect()->route('listas')->with('error', 'Ya existe una película en la lista con el mismo trakt_id y lista_id');
        }
    }

    public function deactivate(Request $request)
    {
        $request->validate([
            'lista_id' => 'required',
            'trakt_id' => 'required',
        ]);
        
        // Busca la película por su ID
        $peliculaLista = PeliculaLista::where('lista_id', $request->lista_id)
            ->where('trakt_id', $request->trakt_id)
            ->first();

        // Verifica si la película existe
        if ($peliculaLista) {
            // Cambia el estado de activo a false
            $peliculaLista->update(['activo' => false]);

            // Redirecciona a la página de inicio
            return redirect()->route('listas')->with('success', 'Película desactiva de la lista correctamente');
        } else {
            // Redirecciona a la página de inicio con un mensaje de error
            return redirect()->route('listas')->with('success', 'No se encontró el id a borrar');
        }
    }

    public function getPeliculaListaId($lista_id, $trakt_id)
    {
        // Genera el valor de pelicula_lista_id
        $pelicula_lista_id = str_pad($lista_id, 5, '0', STR_PAD_LEFT) . '_MOV_' . str_pad(PeliculaLista::where('lista_id', $lista_id)->count() + 1, 5, '0', STR_PAD_LEFT);

        return $pelicula_lista_id;
    }

    public function edit(PeliculaLista $pelicula)
    {
        // Retorna la vista para editar una película en la lista
        return view('peliculas.edit', compact('pelicula'));
    }

    public function update(Request $request, PeliculaLista $pelicula)
    {
        // Valida los datos del formulario que recibe como respuesta
        $request->validate([
            'titulo' => 'required',
            'genero' => 'required',
        ]);

        // Actualiza los datos de la película en la lista
        $pelicula->update($request->all());

        // Redirecciona a la página de inicio
        return redirect()->route('peliculas.index')->with('success', 'Película actualizada correctamente');
    }

    public function destroy(PeliculaLista $pelicula)
    {
        // Elimina la película de la lista
        $pelicula->delete();

        // Redirecciona a la página de inicio
        return redirect()->route('peliculas.index')->with('success', 'Película eliminada correctamente');
    }

    public function compruebaCheck($lista_id, $trakt_id)
    {
        // Comprueba si existe una película con el mismo lista_id y trakt_id
        $duplicate = PeliculaLista::where('lista_id', $lista_id)
                                 ->where('trakt_id', $trakt_id)
                                 ->where('activo', 1)
                                 ->exists();

        return $duplicate;
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    public function index()
    {
        // Obtiene todas las listas
        $listas = Lista::all();

        // Retorna la vista con las listas
        return view('listas.index', compact('listas'));
    }

    public function create()
    {
        // Retorna la vista para crear una nueva lista
        return view('listas.create');
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario que recibe como respuesta
        $validatedData = $request->validate([
            'nombre_lista' => 'required|string|max:255',
            'descripcion' => 'sometimes|string|max:255'
        ]);

        // Obtiene el último user_id de la base de datos
        $ultimoListaId = Lista::max('lista_id');
        $ultimoListaId = substr($ultimoListaId, -5);

        // Si no hay listas en la base de datos, establecer el valor inicial en 1
        if (!$ultimoListaId) {
            $nuevaListaId = 1;
        } else {
            // Si hay incrementa el último lista_id
            $nuevaListaId = $ultimoListaId + 1;
        }

        $lista = Lista::create([
            'lista_id' => 'LST_' . str_pad($nuevaListaId, 5, '0', STR_PAD_LEFT),
            'user_id' => Auth::user()->user_id,
            'nombre_lista' => $validatedData['nombre_lista'],
            'descripcion' => $validatedData['descripcion'],
            'activo' => true,
        ]);

        // Redirecciona a la página de inicio
        return redirect()->route('listas')->with('success', 'Lista creada correctamente.');
    }

    public function show(Lista $lista)
    {
        // Devuelve la vista con los detalles de la lista
        return view('listas.show', compact('lista'));
    }

    public function edit(Lista $lista)
    {
        // Devuelve la vista para editar la lista
        return view('listas.edit', compact('lista'));
    }

    public function update(Request $request, Lista $lista)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        // Actualiza la lista con los datos del formulario
        $lista->update($request->all());

        // Redirecciona a la página de detalles de la lista
        return redirect()->route('listas.show', $lista);
    }

    public function destroy(Lista $lista)
    {
        // Elimina la lista
        $lista->delete();

        // Redirecciona a la página de inicio
        return redirect()->route('listas.index');
    }

    public function mostrarListas()
    {
    $user = Auth::user();
    $listas = $user->listas;

    $response = response()->json(compact('listas'));
    return $response;
    }

    public function getListaId($nombreLista, $userId)
    {
        // Obtiene el lista_id a partir del nombre_lista y user_id
        $lista = Lista::where('nombre_lista', $nombreLista)
                      ->where('user_id', $userId)
                      ->first();

        if ($lista) {
            return $lista->lista_id;
        } else {
            return null;
        }
    }

    public function getNombreLista($listaId)
{
    // Obtiene el nombre_lista a partir del lista_id
    $lista = Lista::find($listaId);

    if ($lista) {
        // Formatea la respuesta como un objeto JSON
        return response()->json(['nombre_lista' => $lista->nombre_lista]);
    } else {
        // Maneja el caso donde no se encuentra la lista
        return response()->json(['error' => 'Lista no encontrada'], 404);
    }
}

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Valida los datos del formulario que recibe como respuesta
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'fecha_nacimiento' => 'required|date',
            'usuario' => 'required|string|max:255',
        ]);

        // Obtiene el último user_id de la base de datos
        $ultimoUserId = User::max('user_id');
        $ultimoUserId = substr($ultimoUserId, -5);

        // Si no hay usuarios en la base de datos, establece el valor inicial en 1
        if (!$ultimoUserId) {
            $nuevoUserId = 1;
        } else {
            // Incrementa el último user_id y lo asigna al nuevo usuario
            $nuevoUserId = $ultimoUserId + 1;
        }

        // Crea un nuevo usuario
        $user = User::create([
            'user_id' => 'USR_' . str_pad($nuevoUserId, 5, '0', STR_PAD_LEFT),
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'fecha_registro' => now(),
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'usuario' => $validatedData['usuario'],
            'activo' => true,
        ]);

        // Redirige al usuario a una página después de crear el usuario
        return redirect()->route('index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Controla el inicio de sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Obtiene el valor de la casilla de recordar sesión
        $remember = $request->has('remember');

        // Intenta autentica al usuario por correo electrónico
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            // Autenticación exitosa
            return redirect()->route('indexIniciado')->with('success', 'Inicio de sesión exitoso.');
        }

        // Intentar autenticar al usuario por nombre de usuario
        if (Auth::attempt(['usuario' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            // Autenticación exitosa
            return redirect()->route('indexIniciado')->with('success', 'Inicio de sesión exitoso.');
        }

        // Autenticación fallida
        return redirect()->back()->withErrors(['email' => 'Credenciales inválidas.'])->withInput();
    }
}

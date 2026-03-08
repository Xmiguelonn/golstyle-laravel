<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validar los datos que envía Angular
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ape1' => 'required|string|max:255',
            'ape2' => 'nullable|string|max:255', // Opcional
            'correo' => 'required|string|email|max:255|unique:usuario', // unique comprueba que el email no exista ya en la tabla 'usuario'
            'password' => 'required|string|min:8', // Mínimo 8 caracteres
            'rol' => 'required|string|in:admin,cliente', // Solo permite estos dos roles (ajusta según tus necesidades)
        ]);

        // 2. Crear el usuario en la base de datos
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'ape1' => $request->ape1,
            'ape2' => $request->ape2,
            'correo' => $request->correo,
            'password' => Hash::make($request->password), // ¡MUY IMPORTANTE! Encriptar la contraseña
            'rol' => $request->rol,
        ]);

        // 3. (Opcional) Autenticar al usuario inmediatamente después de registrarse
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // 4. Devolver la respuesta a Angular
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'usuario' => $usuario
        ], 201); // 201 Created
    }

    public function login(Request $request)
    {
        // 1. Validar los datos que llegan desde Angular
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Buscar al usuario en la base de datos por su correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // 3. Comprobar si el usuario existe y si la contraseña coincide
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Las credenciales son incorrectas.'
            ], 401);
        }

        // 4. Crear el token de Sanctum para este usuario
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // 5. Devolver la respuesta a Angular con el token
        return response()->json([
            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'usuario' => $usuario // Opcional: mandamos los datos del usuario por si Angular los necesita
        ]);
    }

    public function logout(Request $request)
    {
        // Borrar el token actual de la base de datos para cerrar sesión
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
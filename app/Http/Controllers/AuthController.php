<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Summary of register
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? POST /api/register
     * ! Registrar a un nuevo usuario
     */
    public function register(Request $request)
    {
        // Validación de datos
        $request->validate([

            'nombre' => 'required|string|max:255',
            'ape1' => 'required|string|max:255',
            'ape2' => 'nullable|string|max:255', 
            'correo' => 'required|string|email|max:255|unique:usuario', 
            'password' => 'required|string|min:8', 
        ]);

        // Crear el usuario en la base de datos
        $usuario = Usuario::create([

            'nombre' => $request->nombre,
            'ape1' => $request->ape1,
            'ape2' => $request->ape2,
            'correo' => $request->correo,
            // Crear la consetraña encriptada
            'password' => Hash::make($request->password), 
        ]);

        // Lanzamos el correo de verificación automáticamente
        $usuario->sendEmailVerificationNotification();

        // Devolver la respuesta
        return response()->json([

            'mensaje' => 'Registro casi listo. Por favor, verifica tu correo.',
        ], 201);
    }

    /**
     * Summary of login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? POST /api/login
     * ! Hacer el loguin para un usuario
     */
    public function login(Request $request)
    {
        // Validación de datos
        $request->validate([

            'correo' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar al usuario en la base de datos por su correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // Comprobar si el usuario existe y si la contraseña coincide
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {

            return response()->json([

                'message' => 'Las credenciales son incorrectas.'
            ], 401);
        }

        // Comprobar si el usuario ha verificado su cuenta
        if (!$usuario->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Debes verificar tu correo electrónico antes de poder iniciar sesión. Revisa tu bandeja de entrada.'
            ], 403); // Devolvemos un 403 (Prohibido)
        }

        // Crear el token de Sanctum para este usuario
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Devolver la respuesta a Angular con el token
        return response()->json([

            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'usuario' => $usuario
        ]);
    }

    /**
     * Summary of logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * ? POST /api/logout
     * ! Cerrar sesión
     */
    public function logout(Request $request)
    {
        // Borrar el token actual de la base de datos para cerrar sesión
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
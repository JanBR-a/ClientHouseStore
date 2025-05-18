<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Enviar la solicitud de registro directamente a la API
        $response = Http::post('http://127.0.0.1:8002/api/register', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // Verificar si la API respondió correctamente
        if ($response->successful()) {
            $token = $response->json()['token']; // Obtener el token
            session()->put('api_token', $token); // Guardar el token en sesión
            return redirect()->intended('/home');
        }

        // Si hay error, mostrar el mensaje que devuelve la API
        return back()->withErrors(['msg' => $response->json()['message'] ?? 'Error en el registro.']);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}

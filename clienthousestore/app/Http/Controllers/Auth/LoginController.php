<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Enviar la solicitud a la API
        $response = Http::post('http://127.0.0.1:8002/api/login', $credentials);

        if ($response->successful()) {
            $token = $response->json()['token'];
            session()->put('api_token', $token);
            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas.']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}

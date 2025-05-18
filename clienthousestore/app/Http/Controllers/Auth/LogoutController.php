<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    public function logout()
    {
        session()->forget('api_token');  // Eliminar el token de sesión
        return redirect('/');
    }
}

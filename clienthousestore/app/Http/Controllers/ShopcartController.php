<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Http;

class ShopcartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('shopcart', compact('cart'));
    }

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        // Evitar duplicados
        foreach ($cart as $item) {
            if ($item['id'] == $request->id) {
                return response()->json(['message' => 'Esta propiedad ya está en el carrito']);
            }
        }

        // Agregar la propiedad correctamente
        $cart[] = [
            'id' => $request->id,
            'title' => $request->title,
            'image' => $request->image,
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Propiedad añadida al carrito']);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'El carrito está vacío'], 400);
        }

        $token = session()->get('api_token');  // Obtener el token de la sesión
        $response = Http::withToken($token)->get('http://127.0.0.1:8002/api/user');

        if ($response->successful()) {
            $user_id = $response->json()['id'];
        } else {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Preparar los datos de las reservas
        $reservations = [];
        foreach ($cart as $property) {
            $reservations[] = [
                'property_id' => $property['id'],
                'user_id' => $user_id,
            ];
        }

        try {
            $response = Http::withToken($token)->post('http://127.0.0.1:8002/api/reservations', [
                'reservations' => $reservations
            ]);

            if (!$response->successful()) {
                return response()->json(['message' => 'Error al procesar la reserva'], 500);
            }

            session()->forget('cart');  // Limpiar el carrito después de la reserva

            // Retornar respuesta JSON en lugar de redirigir
            return response()->json(['message' => 'Reserva realizada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error de conexión con la API'], 500);
        }
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        // Filtrar para eliminar la propiedad con el ID indicado
        $cart = array_filter($cart, function ($property) use ($request) {
            return $property['id'] != $request->property_id;
        });

        session()->put('cart', $cart);

        return response()->json(['message' => 'Propiedad eliminada del carrito']);
    }
}

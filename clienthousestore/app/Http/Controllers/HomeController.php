<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://127.0.0.1:8002/api/properties/');

            if ($response->successful()) {
                $properties = $response->json()['data'];
            } else {
                $properties = [];
            }
        } catch (\Exception $e) {
            $properties = [];
        }

        return view('home', ['properties' => $properties]);
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $price = $request->input('price');
        $address = $request->input('address');
        $image = $request->input('image');
        $type = $request->input('type');
        $garden = $request->input('garden');
        $state = $request->input('state');
        $bedrooms = $request->input('bedrooms');
        $bathrooms = $request->input('bathrooms');
        $m2 = $request->input('m2');
        $token = session()->get('api_token');
        // dd($token);

        $response = Http::withToken($token)->get('http://127.0.0.1:8002/api/user');

        if ($response->successful()) {
            $user_id = $response->json()['id'];
        } else {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        try {
            $response = Http::withToken($token)->post('http://127.0.0.1:8002/api/properties/', [
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'address' => $address,
                'image' => $image,
                'type' => $type,
                'garden' => $garden,
                'state' => $state,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'm2' => $m2,
                'user_id' => $user_id,
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['msg' => 'Error al crear la propiedad']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error de conexión con la API']);
        }

        return redirect('/');
    }
}

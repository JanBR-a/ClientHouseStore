<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    public function show($id)
    {
        try {
            $response = Http::get("http://127.0.0.1:8002/api/properties/{$id}");

            if ($response->successful()) {
                $property = $response->json()[0];
            } else {
                return back()->withErrors(['msg' => 'Propiedad no encontrada']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error de conexión con la API']);
        }

        return view('property', ['property' => $property]);
    }

    public function update(Request $request, $id)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $price = $request->input('price');
        $token = $request->session()->get('api_token');

        try {
            $response = Http::withToken($token)->put("http://127.0.0.1:8002/api/properties/{$id}", [
                'title' => $title,
                'description' => $description,
                'price' => $price
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['msg' => 'Error al actualizar la propiedad']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error de conexión con la API']);
        }

        return redirect("/properties/{$id}");
    }

    public function destroy(Request $request, $id)
    {
        $token = $request->session()->get('api_token');

        try {
            $response = Http::withToken($token)->delete("http://127.0.0.1:8002/api/properties/{$id}");

            if (!$response->successful()) {
                return back()->withErrors(['msg' => 'Error al eliminar la propiedad']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error de conexión con la API']);
        }

        return redirect('/');
    }
}


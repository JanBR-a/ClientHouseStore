<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles de la Propiedad</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f3f3f3;
        margin: 0;
        padding: 20px;
    }

    h1 {
        color: #333;
        text-align: center;
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        width: calc(100% - 10px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    textarea {
        height: 100px;
    }

    button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold text-center my-8">Detalles de la Propiedad</h1>
        <form method="POST" action="/properties/update/{{$property['id']}}" id="edit-form" class="hidden">
            @csrf
            @method('PUT')
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ $property['title'] }}" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" rows="4" required>{{ $property['description'] }}</textarea>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" value="{{ $property['price'] }}" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="{{ $property['address'] }}" required>

            <label for="image">Imagen:</label>
            <input type="text" id="image" name="image" value="{{ $property['image'] }}" requires>

            <label for="type">Tipo:</label>
            <select id="type" name="type" required>
                <option value="casa">Casa</option>
                <option value="chalet">Chalet</option>
                <option value="apartamento">Apartamento</option>
                <option value="solar">Solar</option>
            </select>

            <label for="garden">¿Tiene jardín?</label>
            <select id="garden" name="garden" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>

            <label for="state">Estado:</label>
            <select id="state" name="state" required>
                <option value="compra">Compra</option>
                <option value="alquiler">Alquiler</option>
            </select>

            <label for="bedrooms">Habitaciones:</label>
            <input type="number" id="bedrooms" name="bedrooms" value="{{ $property['bedrooms'] }}" required>

            <label for="bathrooms">Baños:</label>
            <input type="number" id="bathrooms" name="bathrooms" value="{{ $property['bathrooms'] }}" required>

            <label for="m2">Metros Cuadrados:</label>
            <input type="number" id="m2" name="m2" value="{{ $property['m2'] }}" required>

            <button type="submit">Actualizar Propiedad</button>
        </form>
        

        <!-- Confirmación de eliminación -->
        <div id="deleteProperty" class="hidden">
            <h2 class="text-2xl font-semibold text-center my-8">¿Seguro que quieres borrar esta propiedad?</h2>
            <form method="POST" action="{{ route('properties.destroy', $property['id']) }}" id="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="ml-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">Borrar</button>
            </form>
        </div>

        <!-- Información de la propiedad -->
        <div id="propertyData" class="bg-white shadow-lg rounded-lg p-4">
            <img src="{{ $property['image'] }}" alt="Imagen de la propiedad" class="w-full h-64 object-cover rounded-lg mb-4">
            <h2 class="text-lg font-semibold mb-2">{{ $property['title'] }}</h2>
            <p class="text-gray-600 mb-4">Precio: {{ $property['price'] }} €</p>
            <p class="text-gray-700">{{ $property['description'] }}</p>
            <p class="text-gray-700">Dirección: {{ $property['address'] }}</p>
            <p class="text-gray-700">Tipo: {{ $property['type'] }}</p>
            <p class="text-gray-700">Jardín: {{ $property['garden'] == 1 ? 'Sí' : 'No' }}</p>
            <p class="text-gray-700">Estado: {{ $property['state'] }}</p>
            <p class="text-gray-700">Habitaciones: {{ $property['bedrooms'] }}</p>
            <p class="text-gray-700">Baños: {{ $property['bathrooms'] }}</p>
            <p class="text-gray-700">Metros Cuadrados: {{ $property['m2'] }}</p>


            @if (session()->has('api_token'))
            <div class="mt-4">
                <button onclick="editProperty()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">Actualizar</button>
                <button onclick="deleteProperty()" class="ml-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">Borrar</button>
            </div>
            @endif
        </div>
    </div>

    <script>
        function editProperty() {
            document.getElementById("edit-form").classList.remove("hidden");
            document.getElementById("propertyData").classList.add("hidden");
        }

        function deleteProperty() {
            document.getElementById("deleteProperty").classList.remove("hidden");
            document.getElementById("propertyData").classList.add("hidden");
        }
    </script>
</body>
</html>


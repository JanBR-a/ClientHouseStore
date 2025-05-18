<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="fixed top-0 right-0 p-6 text-right z-10">
        @if (session()->has('api_token'))
            <a href="{{ url('/shopcart') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400">Carrito</a>
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400">Dashboard</a>
            <!-- Usamos un formulario para enviar la solicitud POST -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="ml-4 font-semibold text-red-600 hover:text-red-900 bg-transparent border-none cursor-pointer">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400">Log in</a>
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400">Register</a>
        @endif
    </div>

    <main class="container mx-auto px-4">
        <h1 id="PropertiesTitle" class="text-3xl font-semibold text-center my-8">Lista de Propiedades</h1>
        <div id="listProperties" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($properties as $property)
            <a href="{{ route('properties.show', $property['id']) }}">

            <div class="bg-white shadow-lg rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $property['title'] }}</h2>
                    <img src="{{ $property['image'] }}" alt="">
                    <p class="text-gray-600 mb-4">Precio: {{ $property['price'] }} €</p>
                    <p class="text-gray-700">{{ $property['description'] }}</p>

                    @if (session()->has('api_token'))
                        <button onclick='addToCart(@json(['id' => $property['id'], 'title' => $property['title'], 'image' => $property['image']]))'
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                            Añadir al carrito
                        </button>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @if (session()->has('api_token'))
            <div class="flex justify-center my-4" id="addProperty">
                <button onclick=addProperty()
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                    Añadir propiedad
                </button>
            </div>
        @endif
        <div id="addForm" class="container mx-auto px-4 hidden">
            <h1 class="text-3xl font-semibold text-center my-8">Añadir Propiedad</h1>
            <form action="{{ route('properties.store') }}" method="POST">
                @csrf
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>

                <label for="description">Descripción:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="price">Precio:</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="address">Dirección:</label>
                <input type="text" id="address" name="address" required>

                <label for="image">Imagen:</label>
                <input type="text" id="image" name="image">

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
                <input type="number" id="bedrooms" name="bedrooms" value="1" required>

                <label for="bathrooms">Baños:</label>
                <input type="number" id="bathrooms" name="bathrooms" value="1" required>

                <label for="m2">Metros Cuadrados:</label>
                <input type="number" id="m2" name="m2" required>

                <button type="submit">Agregar Propiedad</button>
            </form>
        </div>
    </main>
    <script>
        function addProperty() {
            document.getElementById('addForm').style.display = 'block';
            document.getElementById('listProperties').style.display = 'none';
            document.getElementById('addProperty').style.display = 'none';
            document.getElementById('PropertiesTitle').style.display = 'none';

        }

        function showProperties(properties) {
            var listProperties = document.getElementById('listProperties');
            listProperties.innerHTML = '';
            properties.forEach(property => {
                var card = document.createElement('div');
                card.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'p-4');
                var title = document.createElement('h2');
                title.classList.add('text-lg', 'font-semibold', 'mb-2');
                title.textContent = property.title;
                var price = document.createElement('p');
                price.classList.add('text-gray-600', 'mb-4');
                price.textContent = 'Precio: ' + property.price + ' €';
                var description = document.createElement('p');
                description.classList.add('text-gray-700');
                description.textContent = property.description;
                card.appendChild(title);
                card.appendChild(price);
                card.appendChild(description);
                listProperties.appendChild(card);
            });
        }

        function addToCart(property) {
            fetch('/shopcart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(property)
                }).then(response => response.json())
                .then(data => alert(data.message));
        }
    </script>
</body>

</html>

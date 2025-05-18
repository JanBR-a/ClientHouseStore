<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrito de compra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold text-center my-8">Carrito de compra</h1>

        @if (session()->has('cart') && !empty(session('cart')))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (session('cart') as $property)
                    <div class="bg-white shadow-lg rounded-lg p-4">
                        <h2 class="text-lg font-semibold mb-2">🏠 {{ $property['title'] }}</h2>
                        <img src="{{ $property['image'] }}" alt=""
                            class="w-32 h-32 object-cover rounded-lg mb-2">
                        <p class="text-gray-600 mb-2">ID: {{ $property['id'] }}</p>
                        <button onclick="removeFromCart({{ $property['id'] }})"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
                            ❌ Eliminar
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-center">
                <p class="text-lg font-semibold">Total de propiedades en el carrito: <span
                        class="text-blue-500">{{ count(session('cart')) }}</span></p>
                <button onclick="checkout()"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md mt-4">
                    ✅ Confirmar reserva
                </button>
            </div>
        @else
            <p class="text-center text-gray-600 text-lg">El carrito está vacío. 📭</p>
        @endif
    </div>

    <script>
        function removeFromCart(propertyId) {
            fetch('/shopcart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        property_id: propertyId
                    })
                })
                .then(response => response.json())
                .then(data => alert(data.message))
                .then(() => window.location.reload()); // Recargar la página para actualizar el carrito
        }

        function checkout() {
            console.log("Botón de Checkout presionado");

            fetch('/shopcart/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta de la API:", data); 
                    alert(data.message);
                    window.location.href = "/";
                })
                .catch(error => console.error("Error en la solicitud:", error));
        }
    </script>
</body>

</html>

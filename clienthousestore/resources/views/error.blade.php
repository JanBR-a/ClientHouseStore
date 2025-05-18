<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>
    <style>
        body {
            background-color: red;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 20px;
            border: 2px solid white;
            border-radius: 10px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>¡Error!</h1>
        <p>Ocurrió un problema inesperado.</p>
        <p>Por favor, intenta nuevamente o contacta con soporte.</p>
    </div>
</body>

</html>

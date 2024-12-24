<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento - {{ $event->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }

        .logo img {
            width: auto;
            max-height: 80px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .header {
            background-color: #000;
            color: white;
            padding: 24px;
            /* Aumentar o padding */
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            /* Aumentar o espaçamento */
        }

        .header-icon {
            background-color: #3490dc;
            color: white;
            border-radius: 50%;
            width: 80px;
            /* Aumentar o tamanho do ícone */
            height: 80px;
            /* Aumentar o tamanho do ícone */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content-title {
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
            /* Aumentar o texto */
            font-size: 2.5rem;
            /* Aumentar o tamanho da fonte do título */
        }

        .mb-8 p {
            font-size: 1.25rem;
            /* Aumentar o tamanho da fonte nos parágrafos */
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
        <div class="header mb-8">
            <div class="logo mb-8">
                <img src="{{ public_path('Logo.png') }}" alt="Logo">
            </div>
            <h1 class="text-3xl font-bold">QuickMatch</h1>
        </div>

        <h1 class="text-5xl text-center text-gray-800 mb-8 content-title">Detalhes do Evento: {{ $event->name }}</h1>

        <div class="mb-8">
            <p class="text-lg text-gray-700"><strong>Descrição:</strong></p>
            <p class="text-gray-600">{{ $event->description }}</p>
        </div>

        <div class="mb-8">
            <p class="text-lg text-gray-700"><strong>Data e Hora:</strong></p>
            <p class="text-gray-600 text-xl">{{ $event->event_date_time }}</p>
        </div>

        <div class="mb-8">
            <p class="text-lg text-gray-700"><strong>Preço:</strong></p>
            <p class="text-gray-600 text-xl">{{ $event->price }} €</p>
        </div>

        <div class="mb-8">
            <p class="text-lg text-gray-700"><strong>Campo:</strong></p>
            <p class="text-gray-600 text-xl">{{ $event->field->name }}</p>
        </div>

        <div class="mb-8">
            <p class="text-lg text-gray-700"><strong>Localização:</strong></p>
            <p class="text-gray-600 text-xl">{{ $event->field->location }}</p>
        </div>
    </div>

</body>

</html>
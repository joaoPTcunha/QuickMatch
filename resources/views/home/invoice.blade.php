<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento - {{ $event->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
        <img src="{{ asset('public/Logo.png') }}" alt="Logo" class="h-16 mx-auto mb-8">
        <h1 class="text-4xl text-center text-gray-800 mb-6">Detalhes do Evento: {{ $event->name }}</h1>

        <div class="mb-4">
            <p class="text-lg text-gray-700"><strong>Descrição:</strong> {{ $event->description }}</p>
        </div>

        <div class="mb-4">
            <p class="text-lg text-gray-700"><strong>Data e Hora:</strong> {{ $event->event_date_time }}</p>
        </div>

        <div class="mb-4">
            <p class="text-lg text-gray-700"><strong>Preço:</strong> {{ $event->price }} €</p>
        </div>

        <div class="mb-4">
            <p class="text-lg text-gray-700"><strong>Campo:</strong> {{ $event->field->name }}</p>
        </div>

        <div class="mb-4">
            <p class="text-lg text-gray-700"><strong>Localização:</strong> {{ $event->field->location }}</p>
        </div>

        <div>
            <p class="text-lg text-gray-700"><strong>Participante(s):</strong> {{ $event->user->user_name }}</p>
        </div>
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>

        body {
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 800px;
        }

        .logo img {
            width: auto;
            max-height: 150px; /* Aumentando o tamanho da imagem */
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .header {
            background-color: #ffffff;
            color: #333;
            padding: 16px;
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
        }

        .header-icon {
            background-color: #3490dc;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            margin-bottom: 16px;
        }

        .content-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 16px;
        }

        .content-section {
            margin-bottom: 16px;
            padding: 16px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .content-section p {
            margin: 4px 0;
        }

        .content-section strong {
            color: #4a5568;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
        <div class="header mb-8">
            <div class="logo">
                <img src="{{ public_path('logonome.png') }}" alt="Logo">
            </div>
            <h1 class="content-title">Detalhes do Evento</h1>
        </div>

        <div class="content-section">
            <p><strong>Descrição:</strong></p>
            <p>{{ $event->description }}</p>
        </div>

        <div class="content-section">
            <p><strong>Data e Hora:</strong></p>
            <p>{{ $event->event_date_time }}</p>
        </div>

        <div class="content-section">
            <p><strong>Preço:</strong></p>
            <p>{{ $event->price }} €</p>
        </div>

        <div class="content-section">
            <p><strong>Campo:</strong></p>
            <p>{{ $event->field->name }}</p>
        </div>

        <div class="content-section">
            <p><strong>Localização:</strong></p>
            <p>{{ $event->field->location }}</p>
        </div>
    </div>

</body>

</html>

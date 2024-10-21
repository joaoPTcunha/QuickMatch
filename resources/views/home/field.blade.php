@include('home.css')

@include('home.header')

<body class="bg-gray-100 flex flex-col min-h-screen">
    <h1>Campos</h1>
    <div class="container mx-auto">
        <div class="bg-gray-200 rounded-lg p-6">
            <img src="{{ asset('images/campo_de_futebol.jpg') }}" alt="Campo de Futebol" class="w-full rounded-lg mb-4" />
            <h1 class="text-2xl font-bold">Futebol</h1>
            <p>Olá a todos! Estamos à procura de 12 "futebolistas" para uma partida de 11x11.</p>
            <p>
                <strong>Data:</strong>
                16/10/2024
            </p>
            <p>
                <strong>Horário:</strong>
                20:00
            </p>
            <p>
                <strong>Custo:</strong>
                2€ por pessoa
            </p>
            <p>
                <strong>Local:</strong>
                Campo Municipal Póvoa de Varzim
            </p>
            <div class="rating">
                <span class="text-yellow-500">★★★★★</span>
                5 estrelas
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Conversar com o dono</button>
        </div>
    </div>

    @include('home.footer')

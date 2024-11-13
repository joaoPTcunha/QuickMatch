<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-4 text-center text-gray-800">Olá, {{ $name }}! ({{ $usertype }})</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <canvas id="realizacaoJogosChart" width="100" height="100"></canvas>
            <p class="mt-4 text-3xl font-semibold text-blue-500">91%</p>
            <p class="text-gray-600">% de realização de jogos (mensal)</p>
        </div>

        <div class="text-center bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <canvas id="utilizadoresAtivosChart" width="100" height="100"></canvas>
            <p class="mt-4 text-3xl font-semibold text-green-500">83%</p>
            <p class="text-gray-600">% utilizadores ativos</p>
        </div>
        <div class="text-center bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <canvas id="jogosNaoRealizadosChart" width="100" height="100"></canvas>
            <p class="mt-4 text-3xl font-semibold text-red-500">2%</p>
            <p class="text-gray-600">% jogos não realizados (mensal)</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 text-center">
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-5xl font-bold text-indigo-600">{{ $userCount }}</p>
            <p class="text-gray-600">Total de Utilizadores</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-5xl font-bold text-green-600">{{ $fieldCount }}</p>
            <p class="text-gray-600">Número de campos</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-5xl font-bold text-yellow-600">23</p>
            <p class="text-gray-600">Total de eventos criados por realizar</p>
        </div>
    </div>
</div>

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Olá,{{ $name }}! ({{ $usertype }})</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Gráfico 1: % de realização de jogos -->
        <div class="text-center">
            <canvas id="realizacaoJogosChart" width="100" height="100"></canvas>
            <p class="mt-4 font-semibold">91%</p>
            <p>% de realização de jogos (mensal)</p>
        </div>

        <!-- Gráfico 2: % de utilizadores ativos -->
        <div class="text-center">
            <canvas id="utilizadoresAtivosChart" width="100" height="100"></canvas>
            <p class="mt-4 font-semibold">83%</p>
            <p>% utilizadores ativos</p>
        </div>

        <!-- Gráfico 3: % de jogos não realizados -->
        <div class="text-center">
            <canvas id="jogosNaoRealizadosChart" width="100" height="100"></canvas>
            <p class="mt-4 font-semibold">2%</p>
            <p>% jogos não realizados (mensal)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 text-center">
        <!-- Número de utilizadores criados -->
        <div>
            <p class="text-4xl font-bold">1657</p>
            <p>Número de utilizadores criados:</p>
        </div>

        <!-- Número de eventos ativos -->
        <div>
            <p class="text-4xl font-bold">88</p>
            <p>Número de eventos ativos:</p>
        </div>

        <!-- Novos utilizadores que criaram conta -->
        <div>
            <p class="text-4xl font-bold">23</p>
            <p>Novos utilizadores que criaram conta:</p>
        </div>
    </div>
</div>
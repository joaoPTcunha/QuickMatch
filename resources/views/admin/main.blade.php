<div class="container mx-auto py-2">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12 text-center">
        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-4xl font-bold text-indigo-600">{{ $userCount }}</p>
            <p class="text-gray-600">Total de Utilizadores</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-4xl font-bold text-green-600">{{ $fieldCount }}</p>
            <p class="text-gray-600">Número de Campos</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-4xl font-bold text-yellow-600">{{ $eventCount }}</p>
            <p class="text-gray-600">Total de Eventos Criados por Realizar</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <p class="text-4xl font-bold text-red-600">{{ $problemCount }}</p>
            <p class="text-gray-600">Total de Problemas por Responder</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg mt-6 relative">
        <div class="absolute top-2 right-2 flex space-x-2">
            <a id="filter-month" class="text-blue-500 py-1 px-3 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition duration-300">Mês</a>
            <a id="filter-day" class="text-green-500 py-1 px-3 rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 transition duration-300">Dia</a>
        </div>
        <div class="absolute top-2 left-2">
            <select id="year-dropdown" class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 transition duration-300">
            </select>
        </div>
        <canvas id="activityChart" class="w-full h-64"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        let chart;
        let currentYear = new Date().getFullYear();
        let currentPeriod = 'month';

        function loadYears() {
            fetch('/admin/available-years')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Falha ao carregar os anos');
                    }
                    return response.json();
                })
                .then(data => {
                    const dropdown = document.getElementById('year-dropdown');
                    dropdown.innerHTML = '';

                    if (data.years && Array.isArray(data.years)) {
                        data.years.forEach(year => {
                            const option = document.createElement('option');
                            option.value = year;
                            option.textContent = year;
                            if (year == currentYear) option.selected = true;
                            dropdown.appendChild(option);
                        });
                    } else {
                        console.error('Dados de anos não encontrados');
                    }
                    dropdown.addEventListener('change', () => {
                        currentYear = dropdown.value;
                        updateChart(currentPeriod);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar anos:', error);
                });
        }

        function updateChart(period, month = null) {
            let url = `/admin/chart-data?filter=${period}&year=${currentYear}`;
            if (month) url += `&month=${month}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const {
                        eventsByPeriod,
                        usersByPeriod,
                        fieldsByPeriod,
                        problemsByPeriod,
                        labels
                    } = data;

                    if (chart) chart.destroy();

                    const maxValue = Math.max(
                        ...usersByPeriod,
                        ...fieldsByPeriod,
                        ...eventsByPeriod,
                        ...problemsByPeriod
                    );

                    let suggestedMax = 20;
                    while (suggestedMax < maxValue) suggestedMax *= 2;

                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Utilizadores Criados',
                                    data: usersByPeriod,
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                },
                                {
                                    label: 'Campos Criados',
                                    data: fieldsByPeriod,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                },
                                {
                                    label: 'Eventos Criados',
                                    data: eventsByPeriod,
                                    borderColor: 'rgba(245, 158, 11, 1)',
                                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                },
                                {
                                    label: 'Problemas Criados',
                                    data: problemsByPeriod,
                                    borderColor: 'rgba(220, 38, 38, 1)',
                                    backgroundColor: 'rgba(220, 38, 38, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: suggestedMax,
                                },
                            },
                        },
                    });
                });
        }

        // Inicializa os anos disponíveis e o gráfico
        loadYears();
        updateChart(currentPeriod);

        // Eventos de filtro
        document.getElementById('filter-month').addEventListener('click', () => {
            currentPeriod = 'month';
            updateChart(currentPeriod);
        });

        document.getElementById('filter-day').addEventListener('click', () => {
            currentPeriod = 'day';
            updateChart(currentPeriod);
        });
    });
</script>
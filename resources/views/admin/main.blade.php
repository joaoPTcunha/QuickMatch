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
    <div class="text-center mb-6 my-5">
        <select id="year-dropdown" class="py-2 px-4 rounded-lg bg-white text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200 border border-gray-300"></select>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white p-6 rounded-lg shadow-lg relative">
            <canvas id="activityChart" class="w-full h-96"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg relative">
            <div class="w-full h-96 mx-auto flex justify-center">
                <canvas id="eventStatusChart" class="w-4/5 h-auto"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const eventStatusCtx = document.getElementById('eventStatusChart').getContext('2d');
        let activityChart, eventStatusChart;
        let currentYear = new Date().getFullYear();
        let currentPeriod = 'month';

        function loadYears() {
            fetch('/admin/available-years')
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar anos');
                    return response.json();
                })
                .then(data => {
                    const dropdown = document.getElementById('year-dropdown');
                    dropdown.innerHTML = '';
                    if (Array.isArray(data.years)) {
                        data.years.forEach(year => {
                            const option = document.createElement('option');
                            option.value = year;
                            option.textContent = year;
                            option.selected = year === currentYear;
                            dropdown.appendChild(option);
                        });
                    } else {
                        console.error('Formato inesperado de dados ao carregar anos.');
                    }
                    dropdown.addEventListener('change', () => {
                        currentYear = dropdown.value;
                        updateCharts();
                    });
                })
                .catch(error => console.error(error.message));
        }

        function updateActivityChart() {
            const url = `/admin/chart-data?filter=${currentPeriod}&year=${currentYear}`;
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar os dados do gráfico');
                    return response.json();
                })
                .then(data => {
                    const {
                        eventsByPeriod,
                        usersByPeriod,
                        fieldsByPeriod,
                        problemsByPeriod,
                        labels
                    } = data;

                    if (activityChart) activityChart.destroy();

                    const maxValue = Math.max(
                        ...usersByPeriod,
                        ...fieldsByPeriod,
                        ...eventsByPeriod,
                        ...problemsByPeriod
                    );

                    const suggestedMax = maxValue > 20 ? Math.ceil(maxValue * 1.2) : 20;

                    activityChart = new Chart(activityCtx, {
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
                })
                .catch(error => console.error(error.message));
        }

        function updateEventStatusChart() {
            const url = `/admin/event-status-data?year=${currentYear}`;
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao carregar dados do estado dos eventos');
                    return response.json();
                })
                .then(data => {
                    const {
                        succeeded,
                        failed,
                        pending
                    } = data;

                    if (eventStatusChart) eventStatusChart.destroy();

                    eventStatusChart = new Chart(eventStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Sucesso', 'Falha', 'Pendente'],
                            datasets: [{
                                data: [succeeded, failed, pending],
                                backgroundColor: [
                                    'rgba(34, 197, 94, 0.7)',
                                    'rgba(220, 38, 38, 0.7)',
                                    'rgba(255, 165, 0, 0.7)',
                                ],
                                borderColor: [
                                    'rgba(34, 197, 94, 1)',
                                    'rgba(220, 38, 38, 1)',
                                    'rgba(255, 165, 0, 1)',
                                ],
                                borderWidth: 2,
                            }],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 25,
                                    },
                                },
                            },
                        },
                    });
                })
                .catch(error => console.error(error.message));
        }



        function updateCharts() {
            updateActivityChart();
            updateEventStatusChart();
        }

        loadYears();
        updateCharts();

        document.getElementById('filter-month').addEventListener('click', () => {
            currentPeriod = 'month';
            updateActivityChart();
        });

    });
</script>
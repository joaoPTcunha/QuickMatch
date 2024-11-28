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
        <canvas id="activityChart" class="w-full h-64"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');

        let chart;
        let currentPeriod = 'month';

        function updateChart(period, month = null) {
            const year = new Date().getFullYear();
            let url = `/admin/chart-data?filter=${period}&year=${year}`;
            if (month) {
                url += `&month=${month}`;
            }

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

                    if (chart) {
                        chart.destroy();
                    }
                    const allData = [
                        ...usersByPeriod,
                        ...fieldsByPeriod,
                        ...eventsByPeriod,
                        ...problemsByPeriod
                    ];

                    const maxValue = Math.max(...allData);

                    let suggestedMax = 20;
                    while (suggestedMax < maxValue) {
                        suggestedMax *= 2;
                    }

                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels.map((label, index) => `${label} ${year}`),
                            datasets: [{
                                label: 'Utilizadores Criados',
                                data: usersByPeriod,
                                borderColor: 'rgba(59, 130, 246, 1)',
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                fill: true,
                                borderWidth: 2,
                                tension: 0.4,
                            }, {
                                label: 'Campos Criados',
                                data: fieldsByPeriod,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                borderWidth: 2,
                                tension: 0.4,
                            }, {
                                label: 'Eventos Criados',
                                data: eventsByPeriod,
                                borderColor: 'rgba(245, 158, 11, 1)',
                                backgroundColor: 'rgba(245, 158, 11, 0.2)',
                                fill: true,
                                borderWidth: 2,
                                tension: 0.4,
                            }, {
                                label: 'Problemas Criados',
                                data: problemsByPeriod,
                                borderColor: 'rgba(220, 38, 38, 1)',
                                backgroundColor: 'rgba(220, 38, 38, 0.2)',
                                fill: true,
                                borderWidth: 2,
                                tension: 0.4,
                            }],
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    ticks: {
                                        font: {
                                            size: 12,
                                        },
                                    },
                                },
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: suggestedMax,
                                    title: {
                                        display: true,
                                    },
                                    ticks: {
                                        stepSize: 5,
                                    },
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.raw} registos`;
                                        },
                                    },
                                },
                            },
                        },
                    });
                })
        }

        updateChart(currentPeriod);

        ctx.canvas.addEventListener('click', function(e) {
            const activePoints = chart.getElementsAtEventForMode(e, 'nearest', {
                intersect: true
            }, false);

            if (activePoints.length > 0) {
                const clickedIndex = activePoints[0].index;
                if (currentPeriod === 'month') {
                    const clickedMonth = clickedIndex + 1;
                    currentPeriod = 'day';
                    updateChart('day', clickedMonth);
                }
            }
        });

        document.getElementById('filter-month').addEventListener('click', function() {
            currentPeriod = 'month';
            updateChart(currentPeriod);
        });

        document.getElementById('filter-day').addEventListener('click', function() {
            const currentMonth = new Date().getMonth() + 1;
            currentPeriod = 'day';
            updateChart(currentPeriod, currentMonth);
        });
    });
</script>
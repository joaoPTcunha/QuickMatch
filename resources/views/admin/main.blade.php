<div class="container mx-auto py-6">

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 px-3">
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex flex-col items-center">
            <p class="text-2xl font-bold text-indigo-600 text-center">{{ $userCount }}</p>
            <p class="text-gray-600 text-sm text-center">Total de Utilizadores</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex flex-col items-center">
            <p class="text-2xl font-bold text-green-600 text-center">{{ $fieldCount }}</p>
            <p class="text-gray-600 text-sm text-center">Número de Campos</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex flex-col items-center">
            <p class="text-2xl font-bold text-yellow-600 text-center">{{ $eventCount }}</p>
            <p class="text-gray-600 text-sm text-center">Total de Eventos</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex flex-col items-center">
            <p class="text-2xl font-bold text-red-600 text-center">{{ $problemCount }}</p>
            <p class="text-gray-600 text-sm text-center">Total de Problemas</p>
        </div>
    </div>

    <div class="flex justify-center mb-6">
        <select id="year-dropdown" class="py-2 px-3 rounded-lg bg-white text-gray-700 shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200 border border-gray-300 w-40">
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6 px-3">
        <div class="bg-white p-8 rounded-lg shadow-lg relative">
            <canvas id="activityChart" class="w-full h-[100px] sm:h-[400px] md:h-96"></canvas>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg relative">
            <h2 class="text-xl font-semibold text-gray-700 text-center mb-4">Estado dos Eventos</h2>
            <div class="w-full flex justify-center">
                <canvas id="eventStatusChart" class="w-full h-[250px] md:w-2/3 md:h-60"></canvas>
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
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        ticks: {
                                            font: {
                                                size: window.innerWidth < 768 ? 10 : 12,
                                            },
                                        },
                                    },
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: suggestedMax,
                                        ticks: {
                                            font: {
                                                size: window.innerWidth < 768 ? 10 : 12,
                                            },
                                        },
                                    },
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: window.innerWidth < 768 ? 10 : 12,
                                            },
                                            boxWidth: window.innerWidth < 768 ? 10 : 15,
                                        },
                                        maxHeight: 50,
                                        display: true,
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: context => `${context.dataset.label}: ${context.raw}`,
                                        },
                                    },
                                },
                                layout: {
                                    padding: {
                                        top: 20,
                                        bottom: 10,
                                    },
                                },
                            },
                        });

                        if (window.innerWidth < 768) {
                            document.querySelector('#activityChart').style.height = '400px';
                        } else {
                            document.querySelector('#activityChart').style.height = '500px';
                        }
                    })
                    .catch(error => console.error(error.message));
            }

            function updateEventStatusChart() {
                const url = `/admin/event-status-data?year=${currentYear}`;
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Erro ao carregar os dados do gráfico');
                        return response.json();
                    })
                    .then(data => {
                        const months = Array.from({
                                length: 12
                            }, (_, i) =>
                            new Date(0, i).toLocaleString('pt-PT', {
                                month: 'long'
                            })
                        );
                        const succeededData = Array(12).fill(0);
                        const failedData = Array(12).fill(0);
                        const pendingData = Array(12).fill(0);

                        data.forEach(event => {
                            const monthIndex = event.month - 1; // Meses começam em 0 no JavaScript
                            succeededData[monthIndex] = event.succeeded;
                            failedData[monthIndex] = event.failed;
                            pendingData[monthIndex] = event.pending;
                        });

                        if (eventStatusChart) eventStatusChart.destroy();

                        eventStatusChart = new Chart(eventStatusCtx, {
                            type: 'pie',
                            data: {
                                labels: ['Eventos Realizados', 'Eventos Falhados', 'Eventos Pendentes'],
                                datasets: [{
                                    data: [
                                        succeededData.reduce((a, b) => a + b, 0),
                                        failedData.reduce((a, b) => a + b, 0),
                                        pendingData.reduce((a, b) => a + b, 0),
                                    ],
                                    backgroundColor: ['#A7F3D0', '#FECACA', '#FDE68A'],
                                    borderColor: ['#FFFFFF', '#FFFFFF', '#FFFFFF'],
                                    borderWidth: 4,
                                }],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        align: 'center',
                                        labels: {
                                            font: {
                                                size: window.innerWidth < 768 ? 10 : 12,
                                            },
                                        },
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const dataset = context.chart.data.datasets[0];
                                                const total = dataset.data.reduce((sum, value) => sum + value, 0);
                                                const percentage = ((context.raw / total) * 100).toFixed(1);

                                                let detailedInfo = '';
                                                if (context.label === 'Eventos Realizados') {
                                                    detailedInfo = succeededData
                                                        .map((val, i) => val > 0 ? `${months[i]}: ${val} evento(s)` : null)
                                                        .filter(item => item !== null)
                                                        .join(', ');
                                                } else if (context.label === 'Eventos Falhados') {
                                                    detailedInfo = failedData
                                                        .map((val, i) => val > 0 ? `${months[i]}: ${val} evento(s)` : null)
                                                        .filter(item => item !== null)
                                                        .join(', ');
                                                } else if (context.label === 'Eventos Pendentes') {
                                                    detailedInfo = pendingData
                                                        .map((val, i) => val > 0 ? `${months[i]}: ${val} evento(s)` : null)
                                                        .filter(item => item !== null)
                                                        .join(', ');
                                                }

                                                return `${context.label}: ${context.raw} (${percentage}%)\nMeses: ${detailedInfo}`;
                                            },
                                        },
                                    },
                                },
                            },
                        });

                        const chartContainer = document.querySelector('#eventStatusChart');
                        if (window.innerWidth < 768) {
                            chartContainer.style.height = '300px';
                        } else {
                            chartContainer.style.height = '400px';
                        }

                        chartContainer.style.display = 'flex';
                        chartContainer.style.justifyContent = 'center';
                        chartContainer.style.alignItems = 'center';
                        chartContainer.style.marginTop = '8px';
                    })
                    .catch(error => console.error(error.message));
            }






            function updateCharts() {
                updateActivityChart();
                updateEventStatusChart();
            }

            loadYears();
            updateCharts();
        });
    </script>
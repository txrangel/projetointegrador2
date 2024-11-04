<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between">
                <div class="grid gap-4 grid-cols-2">
                    <div>
                        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
                            {{$tanque->nome}}
                        </h5>
                    </div>
                </div>
            </div>
            <canvas id="line-chart-{{$tanque->nome}}" width="400" height="200"></canvas> <!-- ID único para cada tanque -->
        </div>
    </div>
</div>

<script>
    function renderizarGrafico() {
        const ctx = document.getElementById('line-chart-{{$tanque->nome}}').getContext('2d');

        // Transformar os dados de PHP em JSON para o JavaScript
        const dados = {!! json_encode($tanque->EstoqueFuturo) !!};
        const valorMinimo = {{$tanque->minimo}};
        const valorMaximo = {{$tanque->maximo}};

        // Extrair as labels (datas) e os níveis do tanque para o gráfico
        const dadosLabels = dados.map(item => item.data);
        const dadosNiveis = dados.map(item => item.nivel);

        // Criar arrays constantes para as linhas de máximo e mínimo
        const linhaMaximo = Array(dadosLabels.length).fill(valorMaximo);
        const linhaMinimo = Array(dadosLabels.length).fill(valorMinimo);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dadosLabels,
                datasets: [
                    {
                        label: 'Nível do Tanque',
                        data: dadosNiveis,
                        borderColor: 'rgb(75, 255, 75)',
                        fill: false,
                    },
                    {
                        label: 'Máximo',
                        data: linhaMaximo,
                        borderColor: 'rgb(255, 75, 75)',
                        fill: false,
                    },
                    {
                        label: 'Mínimo',
                        data: linhaMinimo,
                        borderColor: 'rgb(75, 75, 255)',
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'yyyy-MM-dd' // Formato da data para o tooltip
                        }
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,  // Define o valor mínimo do eixo Y
                        max: valorMaximo+((0-valorMinimo)*-1)   // Define o valor máximo do eixo Y
                    }
                }
            }
        });
    }

    // Chamando a função para renderizar o gráfico
    renderizarGrafico();
</script>
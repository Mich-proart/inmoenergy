<div style="">
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <div class="" style="width: 500px; height: 700px">
                    <div wire:ignore>
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="" style="">
                    <div wire:ignore>
                        <canvas id="horizontalBar"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
                <div class="">
                    <div wire:ignore>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div>Cantidad trámites:</div>
            </div>
        </div>
    </div>
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="/vendor/custom/statistic.code.js"></script>
    <style>
        .chart-container {

            width: 700px !important;
            height: 700px !important;

        }
    </style>
    @endassets

    @script
    <script>
        const ctx = document.getElementById('myChart');
        const doughnut_ctx = document.getElementById('doughnut');
        const horizontalBar_ctx = document.getElementById('horizontalBar');

        let labels = [];
        const gotten_labels = @json($labels);
        const gotten_dataset = @json($dataset)[0];

        console.log(gotten_dataset)

        if (Array.isArray(gotten_labels[0])) {
            labels = gotten_labels[0].map((item) => {
                return item;
            })
        }

        console.log(labels);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: gotten_dataset.label,
                    data: gotten_dataset.data,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    }
                }
            }
        });
        Livewire.on('updateChart', data => {
            console.log(data);
            const doughnut_set = doughnutfnt(data[0].doughnutChart);
            const horizontalBar_set = horizontalBarfnt(data[0].horizontalBarChart);
            //console.log('doughnut_set', doughnut_set);
            console.log('horizontalBar_set', horizontalBar_set);
            doughnut.data = doughnut_set;
            horizontalBar.data = horizontalBar_set;
            doughnut.update();
            horizontalBar.update();

            /*
            chart.data = {
                labels: data.labels,
                datasets: [{
                    label: data.datasets[0].label,
                    data: data.datasets[0].data,
                    borderWidth: 1
                }]
            };

             */
            chart.update();
        });

        const doughnut = new Chart(doughnut_ctx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    label: 'Suministro',
                    data: [],
                    backgroundColor: [],
                    hoverOffset: 4
                }]
            },
        })
        const horizontalBar = new Chart(horizontalBar_ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'RANKING',
                    data: [],
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true
            }
        });
    </script>
    @endscript
</div>

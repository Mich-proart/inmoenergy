<div style="">
    <div class="container text-center">
        <div class="row align-items-center mb-5">
            <div class="col d-flex justify-content-center">
                <div class="" style="height: 350px; width: 350px">
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
        <div class="row align-items-start mt-5">
            <div class="col">
                <div class="" style="height: 50px; width: auto;">
                    <div wire:ignore>
                        <canvas id="verticalBar"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="container text-start">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div>Cantidad trámites:</div>
                                </div>
                                <div class="col-4"><p>{{$totalCount}}</p></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <div>Tiempo promedio trámite:</div>
                                </div>
                                <div class="col-4"><p>{{$timeAvg}}</p></div>
                            </div>
                        </div>

                    </div>
                </div>
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
        const doughnut_ctx = document.getElementById('doughnut');
        const horizontalBar_ctx = document.getElementById('horizontalBar');
        const verticalBar_ctx = document.getElementById('verticalBar');


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
                    backgroundColor: users.backgroundColor,
                    data: [],
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true
            }
        });
        const verticalBar = new Chart(verticalBar_ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: []
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
            const verticalBar_set = verticalBarfnt(data[0].verticalBarChart);
            //console.log('doughnut_set', doughnut_set);
            //console.log('horizontalBar_set', horizontalBar_set);
            console.log('verticalBar_set', verticalBar_set);
            doughnut.data = doughnut_set;
            horizontalBar.data = horizontalBar_set;
            verticalBar.data = verticalBar_set;
            doughnut.update();
            horizontalBar.update();
            verticalBar.update();

        });
    </script>
    @endscript
</div>

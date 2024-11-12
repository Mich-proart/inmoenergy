<div>

    <div class="main_canvas">
        <canvas id="myChart"></canvas>
    </div>
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <style>
        .main_canvas {

            width: 1000px !important;
            height: 600px !important;

        }
    </style>
    @endassets

    @script
    <script>
        const ctx = document.getElementById('myChart');

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
            chart.data = {
                labels: data.labels,
                datasets: [{
                    label: data.datasets[0].label,
                    data: data.datasets[0].data,
                    borderWidth: 1
                }]
            };
            // chart.update();
        });
    </script>
    @endscript
</div>

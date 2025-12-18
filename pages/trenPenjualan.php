<?php
//data barchart
include __DIR__ . '/../data/dataTren.php';
?>

<div id="content">
    <p class="highcharts-description">
        Tren Penjualan
    </p>
    <!-- CHART -->
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold">
            Tren Penjualan Tahunan
        </div>
        <div class="card-body">
            <div id="trendChart" style="height:450px;"></div>
        </div>
    </div>

    <script>
        Highcharts.chart('trendChart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Tren Penjualan Tahunan'
            },
            subtitle: {
                text: 'Perbandingan total produk terjual dan total pendapatan'
            },
            xAxis: {
                categories: <?= json_encode($categories) ?>,
                title: {
                    text: 'Tahun'
                }
            },
            yAxis: [{
                title: {
                    text: 'Total Produk Terjual (Unit)'
                }
            }, {
                title: {
                    text: 'Total Pendapatan'
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Total Produk Terjual',
                data: <?= json_encode($series[0]['data']) ?>,
                yAxis: 0
            }, {
                name: 'Total Pendapatan',
                data: <?= json_encode($series[1]['data']) ?>,
                yAxis: 1
            }]
        });
    </script>
</div>
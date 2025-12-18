<?php
include __DIR__ . '/../data/dataProduk.php';
?>

<div class="content">
    <!-- <div class="card mb-4">
        <div class="card-header py-3"> -->
    <h5 class="m-0 font-weight-bold text-primary">
        Produk Terlaris Adventure Work
    </h5>
    <!-- </div> -->
    <div>
        <p class="highcharts-description">
            Berikut merupakan grafik untuk menampilkan produk terlaris pada Adventure Work.
        </p>
        <div id="linechart" class="grafik"></div>
    </div>
</div>

<!-- Script untuk membuat line chart -->
<script>
    Highcharts.chart('linechart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Produk Paling Laris Per Tahun'
        },
        subtitle: {
            text: 'Klik diagram untuk melihat 10 produk terlaris di tahun tersebut'
        },
        xAxis: {
            type: 'category',
            style: {
                color: '#000',
                textDecoration: 'none',
                cursor: 'default'
            }
        },
        yAxis: {
            title: {
                text: 'Jumlah Terjual (Unit)'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false,
                    format: '{point.y}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:14px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> unit<br/>'
        },
        series: [{
            name: "Produk Teratas",
            colorByPoint: true,
            data: <?= json_encode($top_product_per_year); ?>
        }],
        drilldown: {
            series: <?= json_encode($drilldown_series); ?>
        }
    });
</script>
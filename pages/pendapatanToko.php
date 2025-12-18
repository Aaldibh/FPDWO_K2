<?php
// Mengambil data dari data7.php
include __DIR__ . '/../data/dataToko.php';
?>

<!-- Main Content -->
<div id="content">

    <!-- Begin Page Content -->
    <p class="highcharts-description">
        Pendapatan Setiap Toko
    </p>
    <!-- ================= CHART ================= -->
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold">
            Pendapatan Toko
        </div>
        <div class="card-body">
            <div id="revenueChart" style="height:450px;"></div>
        </div>
    </div>

    <script>
        Highcharts.chart('revenueChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pendapatan Toko'
            },
            subtitle: {
                text: '10 Toko Dengan Pendapatan Tertinggi'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Pendapatan'
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
                        format: '{point.y:,.0f}'
                    }
                }
            },
            series: [{
                name: 'Pendapatan',
                colorByPoint: true,
                data: <?= json_encode($series) ?>
            }],
            drilldown: {
                series: <?= json_encode($drilldownSeries) ?>
            }
        });
    </script>

    <!-- ================= LIST TOKO ================= -->
    <div class="card shadow mb-4">
        <div class="card-header font-weight-bold">Daftar Pendapatan Seluruh Toko</div>
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $offset + 1; ?>
                    <?php foreach ($storeList as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $s['store'] ?></td>
                            <td><?= number_format($s['revenue'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- ================= PAGINATION ================= -->
            <nav>
                <ul class="pagination justify-content-center">
                    <!-- PREV -->
                    <li class="page-item <?= ($hal <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?page=pendapatanToko&hal=<?= $hal - 1 ?>">«</a>
                    </li>
                    <?php $start = max(1, $hal - 2);
                    $end = min($totalPage, $hal + 2);
                    if ($start > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                        if ($start > 2) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                    }
                    for ($i = $start; $i <= $end; $i++): ?> <li class="page-item <?= ($i == $hal) ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?page=pendapatanToko&hal=<?= $i ?>"> <?= $i ?> </a>
                        </li> <?php endfor; ?>
                    <?php if ($end < $totalPage) {
                        if ($end < $totalPage - 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPage . '">' . $totalPage . '</a></li>';
                    } ?>
                    <!-- NEXT -->
                    <li class="page-item <?= ($hal >= $totalPage) ? 'disabled' : '' ?>"> <a class="page-link" href="index.php?page=pendapatanToko&hal=<?= $hal + 1 ?>">»</a> </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
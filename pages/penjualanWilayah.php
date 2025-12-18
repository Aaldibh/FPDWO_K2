<?php
$selectedProduct   = $_GET['product'] ?? 'ALL';
$selectedTerritory = $_GET['territory'] ?? '';

include __DIR__ . '/../data/dataWilayah.php';
?>


<!-- Main Content -->
<div id="content">

    <!-- Begin Page Content -->
    <p class="highcharts-description">
        Penjualan Berdasarkan Wilayah
    </p>
    <!-- ================= DROPDOWN ================= -->
    <form method="GET" action="index.php" class="mb-4">
        <input type="hidden" name="page" value="penjualanWilayah">
        <input type="hidden" name="territory" value="<?= $selectedTerritory ?>">

        <div class="col-md-4 pl-0">
            <label>Pilih Produk</label>
            <select class="form-control select2" onchange="changeProduct(this.value)">
                <option value="ALL" <?= $selectedProduct == 'ALL' ? 'selected' : '' ?>>
                    Semua Produk
                </option>

                <?php foreach ($produkList as $p): ?>
                    <option value="<?= $p['ProductID'] ?>"
                        <?= $selectedProduct == $p['ProductID'] ? 'selected' : '' ?>>
                        <?= $p['ProductName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <script>
        function changeProduct(product) {
            const territory = '<?= $selectedTerritory ?>';

            let url = 'index.php?page=penjualanWilayah&product=' +
                encodeURIComponent(product);

            if (territory) {
                url += '&territory=' + encodeURIComponent(territory);
            }

            window.location.href = url;
        }
    </script>



    <!-- ================= PIE CHART ================= -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Distribusi Penjualan per Wilayah
            </h6>
        </div>
        <div class="card-body">
            <div id="pieWilayah" style="height:400px;"></div>
        </div>
    </div>

    <!-- ================= LINE CHART ================= -->
    <?php if ($selectedTerritory): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Tren Penjualan Bulanan – <?= $selectedTerritory ?>
                </h6>
            </div>
            <div class="card-body">
                <div id="lineYear" style="height:400px;"></div>
            </div>
        </div>
    <?php endif; ?>


</div>
<!-- ================= PIE SCRIPT ================= -->
<script>
    Highcharts.chart('pieWilayah', {
        chart: {
            type: 'pie'
        },
        title: {
            text: null
        },
        plotOptions: {
            pie: {
                cursor: 'pointer',
                dataLabels: {
                    enabled: true
                },
                point: {
                    events: {
                        click: function() {
                            const product = '<?= $selectedProduct ?>';
                            window.location =
                                'index.php?page=penjualanWilayah' +
                                '&product=' + encodeURIComponent(product) +
                                '&territory=' + encodeURIComponent(this.name);
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Penjualan',
            data: [
                <?php foreach ($dataWilayah as $w): ?> {
                        name: '<?= $w["wilayah"] ?>',
                        y: <?= $w["total"] ?>
                    },
                <?php endforeach; ?>
            ]
        }]
    });
</script>

<!-- ================= LINE SCRIPT ================= -->
<?php if ($selectedTerritory): ?>
    <script>
        Highcharts.chart('lineYear', {
            chart: {
                type: 'line'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: [
                    <?php foreach ($dataLine as $d): ?> '<?= $d["periode"] ?>',
                    <?php endforeach; ?>
                ]
            },
            yAxis: {
                title: {
                    text: 'Total Penjualan'
                }
            },
            series: [{
                name: 'Penjualan',
                data: [
                    <?php foreach ($dataLine as $d): ?>
                        <?= $d["total"] ?>,
                    <?php endforeach; ?>
                ]
            }]
        });
    </script>
<?php endif; ?>
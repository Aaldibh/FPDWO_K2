<?php
$type = $_GET['type'] ?? '';
$product = $_GET['product'] ?? '';
$page = $_GET['page'] ?? 1;

// Mengambil data dari file PHP
include __DIR__ . '/../data/dataCust.php';

?>


<!-- Main Content -->
<div id="content">

    <!-- Begin Page Content -->
    <p class="highcharts-description">
        Berikut merupakan grafik untuk menampilkan data jumlah customer dari setiap kategori.
    </p>
    <!-- <div id="barchart2" class="grafik"></div> -->
    <div class="row mb-5">

        <div class="col-md-6">
            <a href="index.php?page=customer&type=Store" class="text-decoration-none">
                <div class="card shadow text-center <?= $type == 'Store' ? 'border-left-primary' : '' ?>">
                    <div class="card-body">
                        <i class="fas fa-store fa-3x text-primary mb-3"></i>
                        <h5 class="font-weight-bold">Pelanggan Store</h5>
                        <p class="text-muted">Pembelian berbasis toko</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="index.php?page=customer&type=Individual" class="text-decoration-none">
                <div class="card shadow text-center <?= $type == 'Individual' ? 'border-left-success' : '' ?>">
                    <div class="card-body">
                        <i class="fas fa-user fa-3x text-success mb-3"></i>
                        <h5 class="font-weight-bold">Pelanggan Individual</h5>
                        <p class="text-muted">Pembelian perorangan</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- ================= DROPDOWN PRODUK ================= -->
    <?php if (!empty($type)): ?>
        <form method="GET" class="mb-4">
            <input type="hidden" name="type" value="<?= $type ?>">
            <input type="hidden" name="page" value="customer">
            <div class="col-md-4 pl-0">
                <label>Pilih Produk</label>
                <select name="product" class="form-control select2" onchange="this.form.submit()">
                    <option value="">-- Pilih Produk --</option>
                    <?php foreach ($produkList as $p): ?>
                        <option value="<?= $p['ProductID'] ?>" <?= $product == $p['ProductID'] ? 'selected' : '' ?>>
                            <?= $p['ProductName'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    <?php endif; ?>

    <!-- ================= CHART ================= -->
    <?php if (!empty($product)): ?>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="chartProduk" style="height:400px;"></div>
            </div>
        </div>

        <script>
            Highcharts.chart('chartProduk', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Tren Penjualan Produk'
                },
                xAxis: {
                    categories: <?= json_encode($categories) ?>
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Terjual (Unit)'
                    }
                },
                series: <?= json_encode($series) ?>
            });
        </script>

        <!-- ================= TABLE CUSTOMER ================= -->
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold">
                Daftar Pelanggan (<?= $totalData ?> pelanggan)
            </div>
            <div class="card-body">

                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Customer</th>
                            <th>Total Pembelian (Unit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customerList as $c): ?>
                            <tr>
                                <td><?= $c['CustomerName'] ?></td>
                                <td><?= $c['total_qty'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <nav>
                    <ul class="pagination justify-content-center">

                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=customer&type=<?= $type ?>&product=<?= $product ?>&page=<?= $page - 1 ?>">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($start > 1): ?>
                            <li class="page-item"><a class="page-link" href="index.php?page=customer&type=<?= $type ?>&product=<?= $product ?>&page=1">1</a></li>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?page=customer&type=<?= $type ?>&product=<?= $product ?>&hal=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end < $totalPage): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <li class="page-item"><a class="page-link" href="index.php?page=customer&type=<?= $type ?>&product=<?= $product ?>&page=<?= $totalPage ?>"><?= $totalPage ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < $totalPage): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?page=customer&type=<?= $type ?>&product=<?= $product ?>&page=<?= $page + 1 ?>">&raquo;</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>

            </div>
        </div>
    <?php endif; ?>

</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
<?php
include 'koneksi.php';

// =======================
// AMBIL DATA PRODUK TERLARIS PER TAHUN
// =======================
$sqlYears = "
    SELECT dt.Year AS tahun, SUM(fs.OrderQty) AS total_qty
    FROM factsales fs
    JOIN dimproduct dp ON fs.ProductID = dp.ProductID
    JOIN dimtime dt ON fs.DateKey = dt.DateKey
    GROUP BY dt.Year
    ORDER BY dt.Year ASC
";

$resultYears = mysqli_query($conn, $sqlYears);

$drilldown_series = [];
$year_categories = [];

while ($rowYear = mysqli_fetch_assoc($resultYears)) {
    $year = $rowYear['tahun'];
    $year_categories[] = $year;

    // Ambil top 10 produk di tahun tersebut
    $sqlTopProducts = "
        SELECT dp.ProductName AS barang, SUM(fs.OrderQty) AS jumlah
        FROM factsales fs
        JOIN dimproduct dp ON fs.ProductID = dp.ProductID
        JOIN dimtime dt ON fs.DateKey = dt.DateKey
        WHERE dt.Year = '$year'
        GROUP BY dp.ProductName
        ORDER BY jumlah DESC
        LIMIT 10
    ";
    $resultTop = mysqli_query($conn, $sqlTopProducts);

    $topProducts = [];
    while ($rowTop = mysqli_fetch_assoc($resultTop)) {
        $topProducts[] = [
            'name' => $rowTop['barang'],
            'y' => (int)$rowTop['jumlah']
        ];
    }

    // Simpan drilldown untuk tahun ini
    $drilldown_series[] = [
        'id' => 'tahun_' . $year,
        'name' => 'Top 10 Produk ' . $year,
        'data' => $topProducts
    ];
}

// Ambil produk paling laris per tahun (hanya 1 produk teratas per tahun)
$top_product_per_year = [];
foreach ($year_categories as $year) {
    $sqlTop1 = "
        SELECT dp.ProductName AS barang, SUM(fs.OrderQty) AS jumlah
        FROM factsales fs
        JOIN dimproduct dp ON fs.ProductID = dp.ProductID
        JOIN dimtime dt ON fs.DateKey = dt.DateKey
        WHERE dt.Year = '$year'
        GROUP BY dp.ProductName
        ORDER BY jumlah DESC
        LIMIT 1
    ";
    $resultTop1 = mysqli_query($conn, $sqlTop1);
    $rowTop1 = mysqli_fetch_assoc($resultTop1);
    $top_product_per_year[] = [
        'name' => (string)$year,
        'y' => (int)$rowTop1['jumlah'],
        'drilldown' => 'tahun_' . $year
    ];
}

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

/* =========================
   DATA TREN PENJUALAN TAHUNAN
========================= */

$categories = [];
$dataQty    = [];
$dataRevenue = [];

$qTrend = mysqli_query($conn, "
    SELECT 
        dt.Year,
        SUM(fs.OrderQty) AS total_qty,
        SUM(fs.SalesAmount) AS total_revenue
    FROM factsales fs
    JOIN dimtime dt ON fs.DateKey = dt.DateKey
    GROUP BY dt.Year
    ORDER BY dt.Year
");

while ($row = mysqli_fetch_assoc($qTrend)) {
    $categories[]  = $row['Year'];
    $dataQty[]     = (int)$row['total_qty'];
    $dataRevenue[] = (float)$row['total_revenue'];
}

$series = [
    [
        'name' => 'Total Produk Terjual',
        'data' => $dataQty
    ],
    [
        'name' => 'Total Pendapatan',
        'data' => $dataRevenue
    ]
];

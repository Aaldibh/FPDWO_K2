<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

/* =========================
   PAGINATION
========================= */
$hal  = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
if ($hal < 1) $hal = 1;

$limit  = 10;
$offset = ($hal - 1) * $limit;

/* =========================
   DRILLDOWN CHART DATA
========================= */
$series = [];
$drilldownSeries = [];

/* ===== LEVEL 1: TOP 10 TOKO ===== */
$qStore = mysqli_query($conn, "
    SELECT 
        dc.CustomerID,
        dc.CustomerName AS store,
        SUM(fs.SalesAmount) AS revenue
    FROM factsales fs
    JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
    WHERE dc.CustomerType = 'Store'
    GROUP BY dc.CustomerID, dc.CustomerName
    ORDER BY revenue DESC
    LIMIT 10
");

while ($s = mysqli_fetch_assoc($qStore)) {

    $storeId   = $s['CustomerID'];
    $storeName = $s['store'];

    $series[] = [
        'name' => $storeName,
        'y'    => (float)$s['revenue'],
        'drilldown' => 'store_' . $storeId
    ];

    /* ===== LEVEL 2: TAHUN ===== */
    $yearData = [];
    $qYear = mysqli_query($conn, "
        SELECT dt.Year, SUM(fs.SalesAmount) AS revenue
        FROM factsales fs
        JOIN dimtime dt ON fs.DateKey = dt.DateKey
        WHERE fs.CustomerID = '$storeId'
        GROUP BY dt.Year
        ORDER BY dt.Year
    ");

    while ($y = mysqli_fetch_assoc($qYear)) {
        $year = $y['Year'];

        $yearData[] = [
            'name' => (string)$year,
            'y'    => (float)$y['revenue'],
            'drilldown' => 'store_' . $storeId . '_year_' . $year
        ];

        /* ===== LEVEL 3: BULAN ===== */
        $monthData = [];
        $qMonth = mysqli_query($conn, "
            SELECT dt.MonthName, SUM(fs.SalesAmount) AS revenue
            FROM factsales fs
            JOIN dimtime dt ON fs.DateKey = dt.DateKey
            WHERE fs.CustomerID = '$storeId'
              AND dt.Year = '$year'
            GROUP BY dt.Month, dt.MonthName
            ORDER BY dt.Month
        ");

        while ($m = mysqli_fetch_assoc($qMonth)) {
            $monthData[] = [
                $m['MonthName'],
                (float)$m['revenue']
            ];
        }

        $drilldownSeries[] = [
            'id'   => 'store_' . $storeId . '_year_' . $year,
            'name' => 'Pendapatan Bulanan ' . $year,
            'data' => $monthData
        ];
    }

    $drilldownSeries[] = [
        'id'   => 'store_' . $storeId,
        'name' => 'Pendapatan Tahunan ' . $storeName,
        'data' => $yearData
    ];
}

/* =========================
   LIST TOKO + PAGINATION
========================= */

/* TOTAL DATA */
$qTotal = mysqli_query($conn, "
    SELECT COUNT(DISTINCT dc.CustomerID) AS total
    FROM factsales fs
    JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
    WHERE dc.CustomerType = 'Store'
");
$totalData = mysqli_fetch_assoc($qTotal)['total'];
$totalPage = ceil($totalData / $limit);

/* DATA TABLE */
$storeList = [];
$qTable = mysqli_query($conn, "
    SELECT 
        dc.CustomerName AS store,
        SUM(fs.SalesAmount) AS revenue
    FROM factsales fs
    JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
    WHERE dc.CustomerType = 'Store'
    GROUP BY dc.CustomerID, dc.CustomerName
    ORDER BY revenue DESC
    LIMIT $limit OFFSET $offset
");

while ($r = mysqli_fetch_assoc($qTable)) {
    $storeList[] = $r;
}

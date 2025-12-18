<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

/* =======================
   PARAMETER
======================= */
$type    = $_GET['type'] ?? '';
$product = $_GET['product'] ?? '';
$hal = isset($_GET['hal']) ? max(1, (int)$_GET['hal']) : 1;

$limit  = 10;
$offset = ($hal - 1) * $limit;

/* =======================
   LIST PRODUK (SUDAH TERJUAL)
======================= */
$produkList = [];
if (!empty($type)) {
    $qProduk = mysqli_query($conn, "
        SELECT DISTINCT dp.ProductID, dp.ProductName
        FROM factsales fs
        JOIN dimproduct dp ON fs.ProductID = dp.ProductID
        JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
        WHERE dc.CustomerType = '$type'
        ORDER BY dp.ProductName
    ");
    while ($row = mysqli_fetch_assoc($qProduk)) {
        $produkList[] = $row;
    }
}

/* =======================
   DATA CHART & CUSTOMER
======================= */
$categories   = [];
$series       = [];
$customerList = [];
$totalPage    = 0;
$totalData    = 0;

if (!empty($type) && !empty($product)) {

    /* ===== CHART WAKTU ===== */
    $qChart = mysqli_query($conn, "
        SELECT 
            CONCAT(dt.MonthName,' ',dt.Year) AS periode,
            SUM(fs.OrderQty) AS total_qty
        FROM factsales fs
        JOIN dimtime dt ON fs.DateKey = dt.DateKey
        JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
        WHERE fs.ProductID = '$product'
          AND dc.CustomerType = '$type'
        GROUP BY dt.Year, dt.Month
        ORDER BY dt.Year, dt.Month
    ");

    $qtyData = [];
    while ($r = mysqli_fetch_assoc($qChart)) {
        $categories[] = $r['periode'];
        $qtyData[]    = (int)$r['total_qty'];
    }

    $series[] = [
        'name' => 'Jumlah Terjual',
        'data' => $qtyData
    ];

    /* ===== HITUNG TOTAL CUSTOMER ===== */
    $qTotal = mysqli_query($conn, "
        SELECT COUNT(DISTINCT dc.CustomerID) AS total
        FROM factsales fs
        JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
        WHERE fs.ProductID = '$product'
          AND dc.CustomerType = '$type'
    ");
    $totalData = mysqli_fetch_assoc($qTotal)['total'];
    $totalPage = ceil($totalData / $limit);

    /* ===== LIST CUSTOMER PER PAGE ===== */
    $qCustomer = mysqli_query($conn, "
        SELECT 
            dc.CustomerName,
            SUM(fs.OrderQty) AS total_qty
        FROM factsales fs
        JOIN dimcustomer dc ON fs.CustomerID = dc.CustomerID
        WHERE fs.ProductID = '$product'
          AND dc.CustomerType = '$type'
        GROUP BY dc.CustomerID, dc.CustomerName
        ORDER BY total_qty DESC
        LIMIT $limit OFFSET $offset
    ");

    while ($c = mysqli_fetch_assoc($qCustomer)) {
        $customerList[] = $c;
    }

    /* ===== PAGINATION RANGE ===== */
    $start = max(1, $hal - 2);
    $end   = min($totalPage, $hal + 2);

    if ($hal <= 3) $end = min(5, $totalPage);
    if ($hal > $totalPage - 2) $start = max(1, $totalPage - 4);
}

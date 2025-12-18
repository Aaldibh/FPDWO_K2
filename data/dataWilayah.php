<?php
require('koneksi.php');

// ===============================
// Ambil parameter filter
// ===============================
$selectedProduct   = isset($_GET['product']) ? $_GET['product'] : 'ALL';
$selectedTerritory = isset($_GET['territory']) ? $_GET['territory'] : null;


// ===============================
// Dropdown: list produk
// ===============================
$sqlProdukList = "
    SELECT DISTINCT
        dp.ProductID,
        dp.ProductName
    FROM factsales fs
    JOIN dimproduct dp ON fs.ProductID = dp.ProductID
    ORDER BY dp.ProductName
";
$resultProdukList = mysqli_query($conn, $sqlProdukList);

$produkList = [];
while ($row = mysqli_fetch_assoc($resultProdukList)) {
    $produkList[] = $row;
}


// ===============================
// PIE CHART: Penjualan per Wilayah
// ===============================
$sqlPie = "
    SELECT dt.TerritoryName AS wilayah,
           SUM(fs.SalesAmount) AS total_penjualan
    FROM factsales fs
    JOIN dimterritory dt ON fs.TerritoryID = dt.TerritoryID
";

$wherePie = [];

if ($selectedProduct !== 'ALL') {
    $sqlPie .= " JOIN dimproduct dp ON fs.ProductID = dp.ProductID ";
    $wherePie[] = "dp.ProductID = '$selectedProduct'";
}

if (!empty($wherePie)) {
    $sqlPie .= " WHERE " . implode(" AND ", $wherePie);
}

$sqlPie .= "
    GROUP BY dt.TerritoryName
    ORDER BY total_penjualan DESC
";

$resultPie = mysqli_query($conn, $sqlPie);

$dataWilayah = [];
while ($row = mysqli_fetch_assoc($resultPie)) {
    $dataWilayah[] = [
        'wilayah' => $row['wilayah'],
        'total'   => (float)$row['total_penjualan']
    ];
}


// ===============================
// LINE CHART: Penjualan per BULAN
// (filter wilayah + produk)
// ===============================
$dataLine = [];

if ($selectedTerritory) {

    $sqlLine = "
        SELECT dtime.Year,
               dtime.Month,
               dtime.MonthName,
               SUM(fs.SalesAmount) AS total_penjualan
        FROM factsales fs
        JOIN dimtime dtime ON fs.DateKey = dtime.DateKey
        JOIN dimterritory dt ON fs.TerritoryID = dt.TerritoryID
    ";

    $whereLine = ["dt.TerritoryName = '$selectedTerritory'"];

    if ($selectedProduct !== 'ALL') {
        $sqlLine .= " JOIN dimproduct dp ON fs.ProductID = dp.ProductID ";
        $whereLine[] = "dp.ProductID = '$selectedProduct'";
    }

    $sqlLine .= "
        WHERE " . implode(" AND ", $whereLine) . "
        GROUP BY dtime.Year, dtime.Month, dtime.MonthName
        ORDER BY dtime.Year, dtime.Month
    ";

    $resultLine = mysqli_query($conn, $sqlLine);

    while ($row = mysqli_fetch_assoc($resultLine)) {
        $dataLine[] = [
            'periode' => $row['MonthName'] . ' ' . $row['Year'],
            'total'   => (float)$row['total_penjualan']
        ];
    }
}

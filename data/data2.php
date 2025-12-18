<?php
require 'koneksi.php';

$sql1 = "SELECT s.teritoryname AS kategori,
                t.bulan AS bulan,
                SUM(fp.SalesAmount) AS pendapatan
         FROM dimsalesterritory s
         JOIN factsales fp ON s.teritoryid = fp.TerritoryID
         JOIN dimtime t ON fp.TimeID = t.timeID
         GROUP BY kategori, bulan
         ORDER BY kategori, bulan";

$result1 = mysqli_query($conn, $sql1);

$pendapatan = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($pendapatan, array(
        "kategori" => $row['kategori'],
        "bulan" => $row['bulan'],
        "pendapatan" => $row['pendapatan'],
    ));
}

$data2 = json_encode($pendapatan);

<?php
session_start();

// jika belum login → tendang ke login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard ADVENTURE WORK</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body id="page-top">

    <div id="wrapper">
        <?php include "sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <?php
            $page = $_GET['page'] ?? 'home';

            switch ($page) {
                case 'produkLaris':
                    include "pages/produkLaris.php";
                    break;

                case 'penjualanWilayah':
                    include "pages/penjualanWilayah.php";
                    break;

                case 'tren':
                    include "pages/trenPenjualan.php";
                    break;

                case 'customer':
                    include "pages/customerTiapProduk.php";
                    break;

                case 'pendapatanToko':
                    include "pages/pendapatanToko.php";
                    break;

                case 'olap':
                    include "pages/olap.php";
                    break;

                // Default halaman home
                case 'home':
                default:
                    include "pages/home.php"; // file yang berisi welcome text
                    break;
            }
            ?>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

</body>

</html>
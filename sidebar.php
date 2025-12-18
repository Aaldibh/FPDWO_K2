<?php
$page = $_GET['page'] ?? 'home';
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bicycle"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3 text-warning">ADVENTURE WORK</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?= ($page == 'home') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=home">
            <i class="fas fa-shopping-cart"></i>
            <span>Home</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Grafik Data
    </div>

    <!-- Menu 1 -->
    <li class="nav-item <?= ($page == 'produkLaris') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=produkLaris">
            <i class="fas fa-shopping-cart"></i>
            <span>Barang Terlaris</span>
        </a>
    </li>

    <!-- Menu 2 -->
    <li class="nav-item <?= ($page == 'penjualanWilayah') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=penjualanWilayah">
            <i class="far fa-clock"></i>
            <span>Penjualan Tiap Wilayah</span>
        </a>
    </li>

    <!-- Menu 3 -->
    <li class="nav-item <?= ($page == 'tren') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=tren">
            <i class="fas fa-money-bill"></i>
            <span>Tren Penjualan</span>
        </a>
    </li>

    <!-- Menu 4 -->
    <li class="nav-item <?= ($page == 'customer') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=customer">
            <i class="fas fa-tasks"></i>
            <span>Customer</span>
        </a>
    </li>

    <!-- Menu 5 -->
    <li class="nav-item <?= ($page == 'pendapatanToko') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=pendapatanToko">
            <i class="fas fa-money-bill-alt"></i>
            <span>Pendapatan Tiap Toko</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        OLAP
    </div>

    <!-- OLAP -->
    <li class="nav-item <?= ($page == 'olap') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=olap">
            <i class="fas fa-database"></i>
            <span>Mondrian</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
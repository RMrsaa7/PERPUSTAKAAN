<?php
// Koneksi ke database
include(__DIR__ . '/../../app/koneksi.php');

// Query untuk mendapatkan jumlah peminjaman dengan status 'dipinjam'
$queryPeminjaman = mysqli_query($conn, "SELECT COUNT(*) as total_peminjaman FROM peminjaman WHERE status_peminjaman='dipinjam'");
if (!$queryPeminjaman) {
    die("Query gagal: " . mysqli_error($conn));
}
$resultPeminjaman = mysqli_fetch_assoc($queryPeminjaman);
$totalPeminjaman = $resultPeminjaman['total_peminjaman'];

// Query untuk mendapatkan total buku berdasarkan jumlah id_buku yang ada di tabel buku dengan keterangan stok tersedia
$queryTotalBuku = mysqli_query($conn, "SELECT COUNT(id_buku) as total_buku FROM buku WHERE stok > 0");
if (!$queryTotalBuku) {
    die("Query gagal: " . mysqli_error($conn));
}
$resultTotalBuku = mysqli_fetch_assoc($queryTotalBuku);
$totalBuku = $resultTotalBuku['total_buku'];

// Query untuk mendapatkan jumlah stok dari tabel stok
$queryJumlahStok = mysqli_query($conn, "SELECT SUM(sisa_stok) as sisa_stok FROM stok");
if (!$queryJumlahStok) {
    die("Query gagal: " . mysqli_error($conn));
}
$resultJumlahStok = mysqli_fetch_assoc($queryJumlahStok);
$jumlahStok = $resultJumlahStok['sisa_stok'];

// Hitung sisa buku
$sisaBuku = $jumlahStok - $totalPeminjaman;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Resume Dashboard</title>
    <link href="/PERPUSTAKAAN/files/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/PERPUSTAKAAN/files/public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg" rel="shortcut icon">

    <style>
        .page-heading {
            margin-top: 20px;
        }

        .card-spacing {
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">ADMIN PERPUSTAKAAN</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/PERPUSTAKAAN/files/views/template/main.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>DATA</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/anggota.php">Data Anggota</a>
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/petugas.php">Data Petugas</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>PEMINJAMAN</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/peminjaman.php">Peminjaman</a>
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/pengembalian.php">Pengembalian</a>
                    </div>
                </div>
            </li>
            <!--Collapse Buku-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBuku" aria-expanded="true" aria-controls="collapseBuku">
                    <i class="fas fa-fw fa-book"></i>
                    <span>BUKU</span>
                </a>
                <div id="collapseBuku" class="collapse" aria-labelledby="headingBuku" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/buku.php">Buku</a>
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/kategori.php">Kategori</a>
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/rak.php">Rak</a>
                        <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/stok.php">Stok</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="https://ars.ac.id" target="_blank" role="button">
                                <!-- Counter - Alerts -->
                                <span>ARS UNIVERSITY</span>
                            </a>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="page-heading">
                        <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
                        <p class="mb-4">Resume data peminjaman perpustakaan</p>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Buku Card -->
                        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalBuku; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book-reader fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah stok buku Card -->
                        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Stok buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahStok; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Peminjaman Card -->
                        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Peminjaman</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPeminjaman; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sisa Buku Card -->
                        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sisa Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sisaBuku; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Content Row -->
                     <hr>
                    <p class="mb-2"><b>Total buku</b> diambil dari jumlah baris id_buku pada tabel buku</p>
                    <p class="mb-2"><b>Stok buku</b> diambil dari jumlah keseluruhan jumlah_stok pada tabel stok</p>
                    <p class="mb-2"><b>Total peminjaman</b> diambil dari jumlah status dipinjam pada tabel peminjaman</p>
                    <p class="mb-2"><b>Sisa buku</b> diambil dari hasil jumlah stok - total peminjaman</p>

                </div>
                <!-- End Container Fluid -->

            </div>
            <!-- End Main Content -->

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="/PERPUSTAKAAN/files/public/vendor/jquery/jquery.min.js"></script>
    <script src="/PERPUSTAKAAN/files/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/PERPUSTAKAAN/files/public/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/PERPUSTAKAAN/files/public/js/sb-admin-2.min.js"></script>

</body>

</html>
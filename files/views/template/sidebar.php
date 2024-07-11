<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Custom fonts for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-text mx-3">ADMIN PERPUSTAKAAN</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/PERPUSTAKAAN/files/index.php?controller=resume">
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
                    <a class="collapse-item" href="/PERPUSTAKAAN/files/index.php?controller=anggota">Data Anggota</a>
                    <a class="collapse-item" href="../../../../PERPUSTAKAAN/files/views/template/petugas.php">Data Petugas</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
                <span>PEMINJAMAN</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/PERPUSTAKAAN/files/index.php?controller=peminjaman">Peminjaman</a>
                    <a class="collapse-item" href="/PERPUSTAKAAN/files/index.php?controller=pengembalian">Pengembalian</a>
                    <a class="collapse-item" href="/PERPUSTAKAAN/files/index.php?controller=buku">Buku</a>

                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

    </ul>
    <!-- End of Sidebar -->

    <!-- Bootstrap core JavaScript-->
    <script src="../../../../PERPUSTAKAAN/files/public/vendor/jquery/jquery.min.js"></script>
    <script src="../../../../PERPUSTAKAAN/files/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../../../PERPUSTAKAAN/files/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../../../PERPUSTAKAAN/files/public/js/sb-admin-2.min.js"></script>
</body>

</html>
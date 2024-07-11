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

// Query untuk mendapatkan stok buku
$queryBuku = mysqli_query($conn, "SELECT SUM(stok) as stok FROM buku");
if (!$queryBuku) {
    die("Query gagal: " . mysqli_error($conn));
}
$resultBuku = mysqli_fetch_assoc($queryBuku);
$totalStok = $resultBuku['stok'];

$sisaBuku = $totalStok - $totalPeminjaman;
$totalBuku = $totalPeminjaman + $totalStok;
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
    <link href="../../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">
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
<body>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-heading">
        <h1 class="h3 mb-0 text-gray-800">RESUME DASHBOARD</h1>
    </div>
    <div class="row">
        <!-- Peminjaman Card -->
        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalPeminjaman; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sisa Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sisaBuku; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Buku Card -->
        <div class="col-xl-3 col-md-6 mb-4 card-spacing">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Buku</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $totalStok; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= ($totalStok > 0) ? ($sisaBuku / $totalStok * 100) : 0; ?>%" aria-valuenow="<?= ($totalStok > 0) ? ($sisaBuku / $totalStok * 100) : 0; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../public/vendor/jquery/jquery.min.js"></script>
<script src="../../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../public/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../public/js/sb-admin-2.min.js"></script>
</body>
</html>

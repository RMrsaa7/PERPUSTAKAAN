<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Pengembalian</title>

    <!-- Custom fonts for this template -->
    <link href="../../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg" rel="shortcut icon">

    <style>
        .page-heading {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<?php
include(__DIR__ . '/../../app/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $id_petugas = $_POST['id_petugas'];
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tenggat = $_POST['tenggat'];
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

        $status_keterlambatan = (strtotime($tanggal_pengembalian) > strtotime($tenggat)) ? 'Terlambat' : 'Tidak Terlambat';

        $update = mysqli_query(
            $conn,
            "UPDATE pengembalian SET id_petugas='$id_petugas', id_anggota='$id_anggota', id_buku='$id_buku', tgl_pinjam='$tgl_pinjam', tenggat='$tenggat', tanggal_pengembalian='$tanggal_pengembalian', status_keterlambatan='$status_keterlambatan' WHERE id_pengembalian='$id'"
        );

        if ($update) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $id_peminjaman = $_POST['id_peminjaman'];
        $id_petugas = $_POST['id_petugas'];
        $id_anggota = $_POST['id_anggota'];
        $id_buku = $_POST['id_buku'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tenggat = $_POST['tenggat'];
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

        $status_keterlambatan = (strtotime($tanggal_pengembalian) > strtotime($tenggat)) ? 'Terlambat' : 'Tidak Terlambat';

        $insert = mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, id_petugas, id_anggota, id_buku, tgl_pinjam, tenggat, tanggal_pengembalian, status_keterlambatan) VALUES ('$id_peminjaman', '$id_petugas', '$id_anggota', '$id_buku', '$tgl_pinjam', '$tenggat', '$tanggal_pengembalian', '$status_keterlambatan')");
        if ($insert) {
            // Update status peminjaman menjadi "Dikembalikan"
            $update = mysqli_query($conn, "UPDATE peminjaman SET status_peminjaman='Dikembalikan' WHERE id_peminjaman='$id_peminjaman'");

            if ($update) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error updating peminjaman: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

$query = mysqli_query($conn, "SELECT * FROM pengembalian ORDER BY id_pengembalian ASC");
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $hapus = $conn->query("DELETE FROM pengembalian WHERE id_pengembalian='$id'");
    echo "<script>window.location.href='pengembalian.php';</script>";
}

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM pengembalian WHERE id_pengembalian='$id'");
    $editData = mysqli_fetch_assoc($editQuery);
}
?>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

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
                    <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/buku.php">Buku</a>
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
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
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
<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <h1 class="h3 mb-3 mt-1 text-gray-800 page-heading">Data Pengembalian</h1>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah data</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr style="font-size: 13px;">
                                        <th>pengembalian</th>
                                        <th>pinjam</th>
                                        <th>petugas</th>
                                        <th>anggota</th>
                                        <th>buku</th>
                                        <th>pinjam</th>
                                        <th>tenggat</th>
                                        <th>pengembalian</th>
                                        <th>status</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_pengembalian = 1;
                                    while ($data = $query->fetch_object()) {
                                    ?>
                                        <tr style="font-size: 13px;">
                                            <td><?= $id_pengembalian; ?></td>
                                            <td><?= $data->id_peminjaman; ?></td>
                                            <td><?= $data->id_petugas; ?></td>
                                            <td><?= $data->id_anggota; ?></td>
                                            <td><?= $data->id_buku; ?></td>
                                            <td><?= $data->tgl_pinjam; ?></td>
                                            <td><?= $data->tenggat; ?></td>
                                            <td><?= $data->tanggal_pengembalian; ?></td>
                                            <td><?= $data->status_keterlambatan; ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?= $data->id_pengembalian; ?>" data-id_peminjaman="<?= $data->id_peminjaman; ?>" data-id_petugas="<?= $data->id_petugas; ?>" data-id_anggota="<?= $data->id_anggota; ?>" data-id_buku="<?= $data->id_buku; ?>" data-tgl_pinjam="<?= $data->tgl_pinjam; ?>" data-tenggat="<?= $data->tenggat; ?>"data-tanggal_pengembalian="<?= $data->tanggal_pengembalian; ?>" data-status_keterlambatan="<?= $data->status_keterlambatan; ?>"><i class="fa fa-edit"></i> Edit</button>
                                                <a href="?hapus=<?= $data->id_pengembalian; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $id_pengembalian++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">FORM INPUT PENGEMBALIAN</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>ID Peminjaman</label>
                                    <input type="text" name="id_peminjaman" id="id_peminjaman" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>ID Petugas</label>
                                    <input type="text" name="id_petugas" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>ID Anggota</label>
                                    <input type="text" name="id_anggota" id="id_anggota" class="form-control" required="" onchange="fetchPeminjamanData()">
                                </div>
                                <div class="form-group">
                                    <label>ID Buku</label>
                                    <input type="text" name="id_buku" id="id_buku" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tenggat</label>
                                    <input type="date" name="tenggat" id="tenggat" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" class="form-control" required="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">FORM EDIT PENGEMBALIAN</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>ID Peminjaman</label>
                                    <input type="text" name="id_peminjaman" id="edit_id_peminjaman" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>ID Petugas</label>
                                    <input type="text" name="id_petugas" id="edit_id_petugas" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>ID Anggota</label>
                                    <input type="text" name="id_anggota" id="edit_id_anggota" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>ID Buku</label>
                                    <input type="text" name="id_buku" id="edit_id_buku" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" id="edit_tgl_pinjam" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tenggat</label>
                                    <input type="date" name="tenggat" id="edit_tenggat" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" id="edit_tanggal_pengembalian" class="form-control" required="">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../../public/vendor/jquery/jquery.min.js"></script>
<script src="../../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../public/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../../public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../public/js/demo/datatables-demo.js"></script>

<script>
    function fetchPeminjamanData() {
        var id_anggota = document.getElementById('id_anggota').value;
        if (id_anggota) {
            $.ajax({
                url: 'get_peminjaman.php',
                type: 'GET',
                data: { id_anggota: id_anggota },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data) {
                        document.getElementById('id_buku').value = data.id_buku;
                        document.getElementById('tenggat').value = data.tenggat;
                        document.getElementById('tgl_pinjam').value = data.tgl_pinjam;

                    } else {
                        alert('Data peminjaman tidak ditemukan.');
                    }
                }
            });
        }
    }

    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var id_peminjaman = button.data('id_peminjaman');
        var id_petugas = button.data('id_petugas');
        var id_anggota = button.data('id_anggota');
        var id_buku = button.data('id_buku');
        var tgl_pinjam = button.data('tgl_pinjam');
        var tenggat = button.data('tenggat');
        var tanggal_pengembalian = button.data('tanggal_pengembalian');
        var status_keterlambatan = button.data('status_keterlambatan');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_id_peminjaman').val(id_peminjaman);
        modal.find('#edit_id_petugas').val(id_petugas);
        modal.find('#edit_id_anggota').val(id_anggota);
        modal.find('#edit_id_buku').val(id_buku);
        modal.find('#edit_tgl_pinjam').val(tgl_pinjam);
        modal.find('#edit_tenggat').val(tenggat);
        modal.find('#edit_tanggal_pengembalian').val(tanggal_pengembalian);
        modal.find('#edit_status_keterlambatan').val(status_keterlambatan);
    });
</script>

</body>

</html>

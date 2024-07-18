<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data anggota</title>

    <!-- Custom fonts for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../../../PERPUSTAKAAN/files/public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../../../PERPUSTAKAAN/files/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg" rel="shortcut icon">

    <style>
        .page-heading {
            margin-top: 20px;
        }
    </style>
</head>

<?php
include(__DIR__ . '/../../app/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $nama_anggota = $_POST['nama_anggota'];
        $jurusan = $_POST['jurusan'];
        $no_telp = $_POST['no_telp'];

        $update = mysqli_query($conn, "UPDATE anggota SET nama_anggota='$nama_anggota', jurusan='$jurusan', no_telp='$no_telp' WHERE id_anggota='$id'");

        if ($update) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $nama_anggota = $_POST['nama_anggota'];
        $jurusan = $_POST['jurusan'];
        $no_telp = $_POST['no_telp'];

        $insert = mysqli_query($conn, "INSERT INTO anggota (nama_anggota, jurusan, no_telp) VALUES ('$nama_anggota', '$jurusan', '$no_telp')");

        if ($insert) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

$query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id_anggota ASC");
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $hapus = $conn->query("DELETE FROM anggota WHERE id_anggota='$id'");
    echo "<script>window.location.href='anggota.php';</script>";
}

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota='$id'");
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
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="https://ars.ac.id" target="_blank" role="button">
                                <!-- Counter - Alerts -->
                                <span>ARS UNIVERSITY</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 page-heading">Tabel data anggota</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah data</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id_anggota</th>
                                            <th>nama_anggota</th>
                                            <th>jurusan</th>
                                            <th>no_telp</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id_anggota = 1;
                                        while ($data = $query->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?= $id_anggota; ?></td>
                                                <td><?= $data->nama_anggota; ?></td>
                                                <td><?= $data->jurusan; ?></td>
                                                <td><?= $data->no_telp; ?></td>
                                                <td>
                                                    <a href="?edit=<?= $data->id_anggota; ?>" class="btn btn-warning" style="font-size: 14px; padding: 2px 5px;" data-target="#editModal">
                                                        <i class="fa fa-edit" style="font-size: 14px;"></i> Edit
                                                    </a>
                                                    <a href="?hapus=<?= $data->id_anggota; ?>" class="btn btn-danger btn-sm" style="font-size: 14px; padding: 2px 5px;" onclick="return confirm('Yakin menghapus data ini?');">
                                                        <i class="fa fa-trash" style="font-size: 14px;"></i> Hapus
                                                    </a>
                                                </td>



                                                </td>
                                            </tr>
                                        <?php
                                            $id_anggota++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">FORM INPUT DATA ANGGOTA</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Bagian Form-->
                        <div class="modal-body">
                            <form method="post" action="../../../../PERPUSTAKAAN/files/views/template/anggota.php">
                                <div class="form-group">
                                    <label>JUDUL anggota</label>
                                    <input type="text" name="nama_anggota" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>jurusan</label>
                                    <input type="text" name="jurusan" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>no_telp</label>
                                    <input type="text" name="no_telp" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>tahun_terbit</label>
                                    <input type="text" name="tahun_terbit" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>id_kategori</label>
                                    <input type="text" name="id_kategori" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>stok</label>
                                    <input type="text" name="stok" class="form-control">
                                </div>
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BAGIAN FORM EDIT -->

            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">FORM EDIT DATA ANGGOTA</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../../../../PERPUSTAKAAN/files/views/template/anggota.php" method="post">
                                <input type="hidden" name="edit_id" value="<?= isset($editData['id_anggota']) ? $editData['id_anggota'] : '' ?>">
                                <div class="form-group">
                                    <label for="nama_anggota">nama anggota</label>
                                    <input type="text" name="nama_anggota" class="form-control" value="<?= isset($editData['nama_anggota']) ? $editData['nama_anggota'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="jurusan">jurusan</label>
                                    <input type="text" name="jurusan" class="form-control" value="<?= isset($editData['jurusan']) ? $editData['jurusan'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">no_telp</label>
                                    <input type="text" name="no_telp" class="form-control" value="<?= isset($editData['no_telp']) ? $editData['no_telp'] : '' ?>">
                                </div>
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <?php if (isset($_GET['edit'])) { ?>
        <script>
            $(document).ready(function() {
                $('#editModal').modal('show');
            });
        </script>
    <?php } ?>

</body>

</html>
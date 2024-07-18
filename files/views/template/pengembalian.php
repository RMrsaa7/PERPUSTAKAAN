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
            // Proses update pengembalian
            $id = $_POST['edit_id'];
            $id_admin = $_POST['id_admin'];
            $nim = $_POST['nim'];
            $id_buku = $_POST['id_buku'];
            $tgl_pinjam = $_POST['tgl_pinjam'];
            $tenggat = $_POST['tenggat'];
            $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

            $status_pengembalian = (strtotime($tanggal_pengembalian) <= strtotime($tenggat)) ? 'Tepat Waktu' : 'Terlambat';

            $update = mysqli_query(
                $conn,
                "UPDATE pengembalian SET id_admin='$id_admin', nim='$nim', id_buku='$id_buku', tgl_pinjam='$tgl_pinjam', tenggat='$tenggat', tanggal_pengembalian='$tanggal_pengembalian', status_pengembalian='$status_pengembalian' WHERE id_pengembalian='$id'"
            );

            if ($update) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // Proses insert pengembalian
            $id_peminjaman = $_POST['id_peminjaman'];
            $id_admin = $_POST['id_admin'];
            $nim = $_POST['nim'];
            $id_buku = $_POST['id_buku'];
            $tgl_pinjam = $_POST['tgl_pinjam'];
            $tenggat = $_POST['tenggat'];
            $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

            $status_pengembalian = (strtotime($tanggal_pengembalian)  <= strtotime($tenggat)) ? 'Tepat Waktu' : 'Terlambat';

            $insert = mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, id_admin, nim, id_buku, tgl_pinjam, tenggat, tanggal_pengembalian, status_pengembalian) VALUES ('$id_peminjaman', '$id_admin', '$nim', '$id_buku', '$tgl_pinjam', '$tenggat', '$tanggal_pengembalian', '$status_pengembalian')");
            if ($insert) {
                // Update status peminjaman menjadi "Dikembalikan"
                $updatePeminjaman = mysqli_query($conn, "UPDATE peminjaman SET status_peminjaman='Dikembalikan' WHERE id_peminjaman='$id_peminjaman'");

                if ($updatePeminjaman) {
                    // Update stok buku
                    $updateStok = mysqli_query($conn, "UPDATE stok SET sisa_stok = sisa_stok + 1 WHERE id_buku='$id_buku'");

                    if ($updateStok) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Error updating stok: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error updating peminjaman: " . mysqli_error($conn);
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    if (isset($_GET['hapus'])) {
        // Proses hapus pengembalian
        $id = $_GET['hapus'];
        $hapus = mysqli_query($conn, "DELETE FROM pengembalian WHERE id_pengembalian='$id'");
        if ($hapus) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Ambil data pengembalian
    $query = mysqli_query($conn, "SELECT id_pengembalian, id_peminjaman, id_admin, nim, id_buku, tgl_pinjam, tenggat, tanggal_pengembalian, 
CASE 
    WHEN tanggal_pengembalian <= tenggat THEN 'Tepat Waktu' 
    ELSE 'Terlambat' 
END AS status_pengembalian 
FROM pengembalian ORDER BY id_pengembalian ASC");
    if (!$query) {
        die("Query gagal: " . mysqli_error($conn));
    }

    // Ambil data untuk edit
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
                            <a class="collapse-item" href="/PERPUSTAKAAN/files/views/template/admin.php">Data admin</a>
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
                                                            <th>ID</th>
                                                            <th>pinjam</th>
                                                            <th>admin</th>
                                                            <th>nim</th>
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
                                                                <td><?= $data->id_admin; ?></td>
                                                                <td><?= $data->nim; ?></td>
                                                                <td><?= $data->id_buku; ?></td>
                                                                <td><?= $data->tgl_pinjam; ?></td>
                                                                <td><?= $data->tenggat; ?></td>
                                                                <td><?= $data->tanggal_pengembalian; ?></td>
                                                                <td><?= $data->status_pengembalian; ?></td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm" data-id="<?= $data->id_pengembalian; ?>" data-id_peminjaman="<?= $data->id_peminjaman; ?>" data-id_admin="<?= $data->id_admin; ?>" data-nim="<?= $data->nim; ?>" data-id_buku="<?= $data->id_buku; ?>" data-tgl_pinjam="<?= $data->tgl_pinjam; ?>" data-tenggat="<?= $data->tenggat; ?>" data-tanggal_pengembalian="<?= $data->tanggal_pengembalian; ?>" data-status_pengembalian="<?= $data->status_pengembalian; ?>" data-toggle="modal" data-target="#editModal">
                                                                        Edit
                                                                    </button>
                                                                    <a href="?hapus=<?= $data->id_pengembalian; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php $id_pengembalian++;
                                                        } ?>
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
                                                        <label for="id_peminjaman">ID Peminjaman</label>
                                                        <input type="text" name="id_peminjaman" id="id_peminjaman" class="form-control" required="" onchange="fetchPeminjamanData()">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="id_admin">ID Admin</label>
                                                        <input type="text" name="id_admin" id="id_admin" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nim">NIM</label>
                                                        <input type="text" name="nim" id="nim" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="id_buku">ID Buku</label>
                                                        <input type="text" name="id_buku" id="id_buku" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tgl_pinjam">Tanggal Pinjam</label>
                                                        <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tenggat">Tenggat</label>
                                                        <input type="date" name="tenggat" id="tenggat" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                                        <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                                                        <label>ID Admin</label>
                                                        <input type="text" name="id_admin" id="edit_id_admin" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>NIM</label>
                                                        <input type="text" name="nim" id="edit_nim" class="form-control" required="">
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
                            var id_peminjaman = document.getElementById('id_peminjaman').value;
                            if (id_peminjaman) {
                                $.ajax({
                                    url: 'get_peminjaman.php',
                                    type: 'GET',
                                    data: {
                                        id_peminjaman: id_peminjaman
                                    },
                                    success: function(response) {
                                        console.log(response); // Tambahkan ini untuk melihat response di console
                                        var data = JSON.parse(response);
                                        if (data) {
                                            document.getElementById('id_admin').value = data.id_admin;
                                            document.getElementById('nim').value = data.nim;
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
                            var id_admin = button.data('id_admin');
                            var nim = button.data('nim');
                            var id_buku = button.data('id_buku');
                            var tgl_pinjam = button.data('tgl_pinjam');
                            var tenggat = button.data('tenggat');
                            var tanggal_pengembalian = button.data('tanggal_pengembalian');
                            var status_pengembalian = button.data('status_pengembalian');

                            var modal = $(this);
                            modal.find('#edit_id').val(id);
                            modal.find('#edit_id_peminjaman').val(id_peminjaman);
                            modal.find('#edit_id_admin').val(id_admin);
                            modal.find('#edit_nim').val(nim);
                            modal.find('#edit_id_buku').val(id_buku);
                            modal.find('#edit_tgl_pinjam').val(tgl_pinjam);
                            modal.find('#edit_tenggat').val(tenggat);
                            modal.find('#edit_tanggal_pengembalian').val(tanggal_pengembalian);
                            modal.find('#edit_status_pengembalian').val(status_pengembalian);
                        });
                    </script>
    </body>

</html>
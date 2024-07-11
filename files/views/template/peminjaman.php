<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data Peminjaman</title>
    <link href="../../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../../PERPUSTAKAAN/files/public/assets/ARS.jpg" rel="shortcut icon">
    <style>
        .page-heading {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-grup {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 page-heading">Data Peminjaman</h1>
                    <p class="mb-4">DataTables adalah plugin pihak ketiga yang digunakan untuk menghasilkan tabel demo di bawah ini. Untuk informasi lebih lanjut tentang DataTables, silakan kunjungi <a target="_blank" href="https://datatables.net">dokumentasi resmi DataTables</a>.</p>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Peminjaman</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Peminjaman</th>
                                            <th>Id Anggota</th>
                                            <th>Id Petugas</th>
                                            <th>Id Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include("../../app/koneksi.php");

                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                            if (isset($_POST['edit_id'])) {
                                                $id = $_POST['edit_id'];
                                                $id_anggota = $_POST['id_anggota'];
                                                $id_petugas = $_POST['id_petugas'];
                                                $id_buku = $_POST['id_buku'];
                                                $tgl_pinjam = $_POST['tgl_pinjam'];
                                                $status_peminjaman = $_POST['status_peminjaman'];

                                                $update = mysqli_query($conn, "UPDATE anggota SET nama_anggota='$nama_anggota', jurusan='$jurusan', no_telp='$no_telp' WHERE id_anggota='$id'");

                                                if ($update) {
                                                    header("Location: " . $_SERVER['PHP_SELF']);
                                                    exit();
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            } else {
                                                $id_anggota = $_POST['id_anggota'];
                                                $id_petugas = $_POST['id_petugas'];
                                                $id_buku = $_POST['id_buku'];
                                                $tgl_pinjam = $_POST['tgl_pinjam'];
                                                $status_peminjaman = $_POST['status_peminjaman'];

                                                $insert = mysqli_query($conn, "INSERT INTO peminjaman (id_anggota, id_petugas, id_buku, tgl_pinjam, status_peminjaman) VALUES ('$id_anggota', '$id_petugas', '$id_buku', '$tgl_pinjam', '$status_peminjaman')");
                                                if ($insert) {
                                                    header("Location: " . $_SERVER['PHP_SELF']);
                                                    exit();
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            }
                                        }

                                        $query = mysqli_query($conn, "SELECT * FROM peminjaman ORDER BY id_peminjaman ASC");
                                        if ($query) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['id_peminjaman'] . "</td>";
                                                echo "<td>" . $row['id_anggota'] . "</td>";
                                                echo "<td>" . $row['id_petugas'] . "</td>";
                                                echo "<td>" . $row['id_buku'] . "</td>";
                                                echo "<td>" . $row['tgl_pinjam'] . "</td>";
                                                echo "<td>" . $row['status_peminjaman'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "Query gagal: " . mysqli_error($conn);
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
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Bagian Form -->
                <div class="modal-body">
                    <form method="post" action="peminjaman.php">
                        <div class="form-group">
                            <label for="id_anggota">Id Anggota</label>
                            <input type="text" name="id_anggota" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="id_petugas">Id Petugas</label>
                            <input type="text" name="id_petugas" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="id_buku">Buku</label>
                            <input type="text" name="id_buku" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tgl_pinjam">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status Peminjaman:</label>
                            <div>
                                <input type="radio" name="status_peminjaman" value="Dipinjam"> Dipinjam
                                <input type="radio" name="status_peminjaman" value="Dikembalikan"> Dikembalikan
                            </div>
                        </div>
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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
</body>

</html>
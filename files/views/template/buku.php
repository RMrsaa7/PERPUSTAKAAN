<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data buku</title>

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
         $judul_buku = $_POST['judul_buku'];
         $pengarang = $_POST['pengarang'];
         $penerbit = $_POST['penerbit'];
         $tahun_terbit = $_POST['tahun_terbit'];
         $id_kategori = $_POST['id_kategori'];
         $stok = $_POST['stok'];
 
         $update = mysqli_query($conn, "UPDATE buku SET judul_buku='$judul_buku', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun_terbit', id_kategori='$id_kategori', stok='$stok' WHERE id_buku='$id'");
 
         if ($update) {
             header("Location: " . $_SERVER['PHP_SELF']);
             exit();
         } else {
             echo "Error: " . mysqli_error($conn);
         }
     } else {
         $judul_buku = $_POST['judul_buku'];
         $pengarang = $_POST['pengarang'];
         $penerbit = $_POST['penerbit'];
         $tahun_terbit = $_POST['tahun_terbit'];
         $id_kategori = $_POST['id_kategori'];
         $stok = $_POST['stok'];
 
         $insert = mysqli_query($conn, "INSERT INTO buku (judul_buku, pengarang, penerbit, tahun_terbit, id_kategori, stok) VALUES ('$judul_buku', '$pengarang', '$penerbit', 'tahum_terbit', 'id_kategori', 'stok')");
 
         if ($insert) {
             header("Location: " . $_SERVER['PHP_SELF']);
             exit();
         } else {
             echo "Error: " . mysqli_error($conn);
         }
     }
 }
 
 $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku ASC");
 if (!$query) {
     die("Query gagal: " . mysqli_error($conn));
 }
 
 if (isset($_GET['hapus'])) {
     $id = $_GET['hapus'];
     $hapus = $conn->query("DELETE FROM buku WHERE id_buku='$id'");
     echo "<script>window.location.href='buku.php';</script>";
 }
 
 $editData = null;
 if (isset($_GET['edit'])) {
     $id = $_GET['edit'];
     $editQuery = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id'");
     $editData = mysqli_fetch_assoc($editQuery);
 }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 page-heading">Tables</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Data buku</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id_buku</th>
                                            <th>judul_buku</th>
                                            <th>pengarang</th>
                                            <th>penerbit</th>
                                            <th>tahun_terbit</th>
                                            <th>id_kategori</th>
                                            <th>stok</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id_buku = 1;
                                        while ($data = $query->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?= $id_buku; ?></td>
                                                <td><?= $data->judul_buku; ?></td>
                                                <td><?= $data->pengarang; ?></td>
                                                <td><?= $data->penerbit; ?></td>
                                                <td><?= $data->tahun_terbit; ?></td>
                                                <td><?= $data->id_kategori; ?></td>
                                                <td><?= $data->stok; ?></td>
                                                <td>
                                                <a href="?edit=<?= $data->$id_buku; ?>" class="btn btn-primary btn-sm" data-target="#editModal"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="?hapus=<?= $data->id_buku; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data ini?');">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>


                                                </td>
                                            </tr>
                                        <?php
                                            $id_buku++;
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
                            <h5 class="modal-title" id="exampleModalLabel">FORM INPUT DATA BUKU</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Bagian Form-->
                        <div class="modal-body">
                            <form method="post" action="../../../../PERPUSTAKAAN/files/views/template/buku.php">
                                <div class="form-group">
                                    <label>JUDUL BUKU</label>
                                    <input type="text" name="judul_buku" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>pengarang</label>
                                    <input type="text" name="pengarang" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>penerbit</label>
                                    <input type="text" name="penerbit" class="form-control">
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
                            <h5 class="modal-title" id="exampleModalLabel">FORM EDIT DATA BUKU</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../../../../PERPUSTAKAAN/files/views/template/buku.php" method="post">
                                <input type="hidden" name="edit_id" value="<?= isset($editData['id_buku']) ? $editData['id_buku'] : '' ?>">
                                <div class="form-group">
                                    <label for="judul_buku">judul buku</label>
                                    <input type="text" name="judul_buku" class="form-control" value="<?= isset($editData['judul_buku']) ? $editData['nama_anggota'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="pengarang">pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" value="<?= isset($editData['pengarang']) ? $editData['jurusan'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penerbit">penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" value="<?= isset($editData['penerbit']) ? $editData['no_telp'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tahun_terbit">tahun terbit</label>
                                    <input type="text" name="tahun_terbit" class="form-control" value="<?= isset($editData['tahun_terbit']) ? $editData['no_telp'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="id_kategori">id katagori</label>
                                    <input type="text" name="id_kategori" class="form-control" value="<?= isset($editData['id_kategori']) ? $editData['no_telp'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stok">stok</label>
                                    <input type="text" name="stok" class="form-control" value="<?= isset($editData['stok']) ? $editData['no_telp'] : '' ?>">
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
<?php 
session_start();
include 'koneksi.php';

// CEK APAKAH USER SUDAH LOGIN
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Jika belum login, paksa kembali ke halaman login
    header("Location: login.php?pesan=belumlogin");
    exit();
}

// Proses Tambah Buku
if (isset($_POST['tambah'])) {
    $kode = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO koleksi_buku (kode_buku, judul, pengarang, kategori, stok) 
              VALUES ('$kode', '$judul', '$pengarang', '$kategori', '$stok')";
    mysqli_query($koneksi, $query);
    header("Location: koleksi.php");
    exit();
}

// Proses hapus buku
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM koleksi_buku WHERE id_buku='$id'";
    mysqli_query($koneksi, $query);
    header("Location: koleksi.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM koleksi_buku"); //biar data buku update
?>

<!DOCTYPE html>
<html>
<head>
    <title>koleksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pustaka Digital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="koleksi.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="peminjaman.php">Peminjaman</a>
        </li>
        </ul>

    
        <div class="logout-button ms-auto">
            <a href="logout.php">
             <button type="button" class="btn btn-light logout">Logout</button>
            </a>
        </div>

     </div>
  </div>
</nav>

    <div class="container mt-4">
      <h3 class="text-center mb-4">Koleksi Buku</h3>

    <div class="text-end mb-3">
      <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
          + Tambah Koleksi
      </button>
    </div>

     <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { 
            // Tentukan status otomatis
            if ($row['stok'] == 0) {
                $status = "Habis";
            } else if ($row['stok'] <= 5) {
                $status = "Menipis";
            } else {
                $status = "Tersedia";
            }
        ?>
              <tr>
                <td><?= $row['id_buku'] ?></td>
                <td><?= $row['kode_buku'] ?></td>
                <td><?= $row['judul'] ?></td>
                <td><?= $row['pengarang'] ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['stok'] ?></td>
                <td><?= $status ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_buku'] ?>" class="btn btn-success btn-sm">Edit</a>
                    <a href="koleksi.php?hapus=<?= $row['id_buku'] ?>" class="btn btn-warning btn-sm"
                       onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                </td>
              </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Koleksi Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kode Buku</label>
                            <input type="text" name="kode_buku" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Fiksi">Fiksi</option>
                            <option value="Sains">Sains</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Fiksi Sejarah">Fiksi Sejarah</option>
                            <option value="Magis">Magis</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
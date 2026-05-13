<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$id = $_GET['id']; //mengambil id dari url di page koleksi
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM koleksi_buku WHERE id_buku=$id"));

// simpan perubahan
if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    mysqli_query($koneksi, "UPDATE koleksi_buku SET 
        kode_buku='$kode', judul='$judul', pengarang='$pengarang',
        kategori='$kategori', stok='$stok' WHERE id_buku=$id");
    header("Location: koleksi.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container mt-5 mb-5">
    <div class="card col-md-9 mx-auto p-4 shadow">
        <h4 class="text-center mb-4">Form Edit Buku</h4>
        <form action="" method="POST">
            <div class="mb-3">
                <label>ID Buku</label>
                <input type="text" class="form-control" value="<?= $data['id_buku'] ?>" disabled>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kode Buku</label>
                    <input type="text" name="kode_buku" class="form-control" value="<?= $data['kode_buku'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Judul Buku</label>
                <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="<?= $data['pengarang'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="Fiksi" <?= $data['kategori']=='Fiksi'?'selected':'' ?>>Fiksi</option>
                    <option value="Sains" <?= $data['kategori']=='Sains'?'selected':'' ?>>Sains</option>
                    <option value="Sejarah" <?= $data['kategori']=='Sejarah'?'selected':'' ?>>Sejarah</option>
                    <option value="Teknologi" <?= $data['kategori']=='Teknologi'?'selected':'' ?>>Teknologi</option>
                    <option value="Fiksi Sejarah" <?= $data['kategori']=='Fiksi Sejarah'?'selected':'' ?>>Fiksi Sejarah</option>
                    <option value="Magis" <?= $data['kategori']=='Magis'?'selected':'' ?>>Magis</option>
                </select>
            </div>
            <div class="text-center">
                <a href="koleksi.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
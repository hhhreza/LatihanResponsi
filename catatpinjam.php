<?php
session_start();
include 'koneksi.php';
// CEK APAKAH USER SUDAH LOGIN  
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Jika belum login, paksa kembali ke halaman login
    header("Location: login.php?pesan=belumlogin");
    exit();
}

// Proses Catat Peminjaman
if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_pinjam'];
    $nama = $_POST['nama_peminjam'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $tgl_kembali = $_POST['tanggal_kembali'];

    // Simpan peminjaman
    mysqli_query($koneksi, "INSERT INTO peminjaman (kode_pinjam, nama_peminjam, id_buku, tanggal_pinjam, tanggal_kembali, status)
        VALUES ('$kode', '$nama', '$id_buku', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam')");

    // Kurangi stok buku
    mysqli_query($koneksi, "UPDATE koleksi_buku SET stok = stok - 1 WHERE id_buku = $id_buku");

    header("Location: peminjaman.php");
    exit();
}
$result = mysqli_query($koneksi, "SELECT p.*, k.judul FROM peminjaman p JOIN koleksi_buku k ON p.id_buku = k.id_buku");

// Ambil buku yang masih tersedia untuk dropdown
$buku_tersedia = mysqli_query($koneksi, "SELECT * FROM koleksi_buku WHERE stok > 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman</title>
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
          <a class="nav-link" aria-current="page" href="koleksi.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="peminjaman.php">Peminjaman</a>
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

   <div class=" container card col-md-6 mt-5 shadow p-3 mb-5 bg-body rounded">
        <form action="" method="POST" class="pinjam">  
              <h2 class="card-title text-center">Form Data Peminjaman</h2>
                    <div class="row">
                        <div class="mb-3">
                            <label>Kode Peminjaman</label>
                            <input type="text" name="kode_pinjam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Peminjam</label>
                            <input type="text" name="nama_peminjam" class="form-control" required>
                        </div>
                    </div>
                <div class="mb-3">
                    <label>Pilih Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku Tersedia --</option>
                        <?php while ($buku = mysqli_fetch_assoc($buku_tersedia)) { ?>
                            <option value="<?= $buku['id_buku'] ?>">
                                <?= $buku['judul'] ?> - Stok: <?= $buku['stok'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>
                </div>
                <div class="text-center">
                    <a href="peminjaman.php">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
                
        </form>
      
    </div>

</body>
</html>
<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

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

// Proses Kembalikan
if (isset($_GET['kembali'])) {
    $id_pinjam = $_GET['kembali'];
    $data_pinjam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pinjam=$id_pinjam"));

    // Update status
    mysqli_query($koneksi, "UPDATE peminjaman SET status='Dikembalikan' WHERE id_pinjam=$id_pinjam");

    // Tambah stok buku
    mysqli_query($koneksi, "UPDATE koleksi_buku SET stok = stok + 1 WHERE id_buku = {$data_pinjam['id_buku']}");

    header("Location: peminjaman.php");
    exit();
}

// Ambil data peminjaman
$result = mysqli_query($koneksi, "SELECT p.*, k.judul FROM peminjaman p JOIN koleksi_buku k ON p.id_buku = k.id_buku");

// Ambil buku yang masih tersedia untuk dropdown
$buku_tersedia = mysqli_query($koneksi, "SELECT * FROM koleksi_buku WHERE stok > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman</title>
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

<div class="container mt-4">
    <h3 class="text-center mb-4">Database Peminjaman</h3>

    <div class="text-end mb-3">
        <a href="catatpinjam.php">
            <button class="btn btn-secondary btn-sm">
                + Catat Peminjaman
            </button>
        </a>
    </div>

    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Kode Peminjaman</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { 
    // Cek otomatis apakah terlambat
    if ($row['status'] == 'Dipinjam' && $row['tanggal_kembali'] < date('Y-m-d')) {
        $row['status'] = 'Terlambat';

        mysqli_query($koneksi, "UPDATE peminjaman SET status='Terlambat' WHERE id_pinjam={$row['id_pinjam']}");
    }
?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['kode_pinjam'] ?></td>
        <td><?= $row['nama_peminjam'] ?></td>
        <td><?= $row['judul'] ?></td>
        <td><?= $row['tanggal_pinjam'] ?></td>
        <td><?= $row['tanggal_kembali'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <?php if ($row['status'] == 'Dipinjam' || $row['status'] == 'Terlambat') { ?>
                <a href="peminjaman.php?kembali=<?= $row['id_pinjam'] ?>" 
                   class="btn btn-info btn-sm text-white"
                   onclick="return confirm('Konfirmasi pengembalian buku ini?')">Kembalikan</a>
            <?php } else { ?>
                <button class="btn btn-success btn-sm text-white" disabled>Selesai</button>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
        </tbody>
    </table>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
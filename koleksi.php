<?php 
session_start();

// CEK APAKAH USER SUDAH LOGIN
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    // Jika belum login, paksa kembali ke halaman login
    header("Location: login.php?pesan=belumlogin");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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

    <h1>Halo, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Selamat datang di halaman dashboard Pustaka Digital.</p>

</body>
</html>
<?php
session_start();
include 'koneksi.php';

$pesan = ""; //variabel

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $pesan = "kosong"; //jika kosong
    } else {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";
            header("Location: koleksi.php");
            exit();
        } else {
            $pesan = "gagal"; //gagal login
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

<div class=" container card col-md-4 mt-5 shadow p-3 mb-5 bg-body rounded">
            <form action="" method="POST" class="login">  
              <h2 class="card-title text-center">Pustaka Digital</h2>
              <h6 class="card-subtitle mb-3 text-center text-muted">Sistem Perpustakaan Nasional</h6>

              <?php if ($pesan == "kosong") { ?>
                <div class="alert alert-danger text-center">Username dan password tidak boleh kosong!</div>
              <?php } else if ($pesan == "gagal") { ?>
                    <div class="alert alert-danger text-center">Username atau password salah!</div>
              <?php } ?>

            <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>

          </form>
            </form>
        </div>


</body>
</html>
<?php 
session_start();

// Menghapus semua session
session_destroy();

// Mengalihkan halaman kembali ke login
header("Location: login.php?pesan=logout");
?>
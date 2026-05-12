<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "pustaka_digital";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die ("Koneksi gagal: " . mysqli_connect_error());
}
?>
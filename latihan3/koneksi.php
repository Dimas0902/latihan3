<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "foto";

// Create a connection using `mysqli`
$koneksi = @mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$koneksi) {
    die("Gagal koneksi: " . mysqli_connect_error());
}

echo "Koneksi berhasil!";
?>

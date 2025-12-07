<?php
// Settingan kredensial database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kopi_tether";

// Coba sambungin ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Kalau gagal konek, kasih tau errornya terus matiin proses
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>
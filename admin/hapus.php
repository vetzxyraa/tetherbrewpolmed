<?php
include '../koneksi.php';
// Tangkap ID yang mau dihapus
$id = $_GET['id'];
// Hapus dari database
mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
// Balikin ke dashboard
header("location:dashboard.php");
?>
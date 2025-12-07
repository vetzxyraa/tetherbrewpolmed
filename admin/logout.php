<?php
session_start();
// Hapus semua data sesi biar bersih
session_destroy();
// Balikin ke halaman login
header("location:login.php");
?>
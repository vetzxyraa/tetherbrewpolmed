<?php
session_start();
include '../koneksi.php';
// user balik ke login kalo belum masuk
if($_SESSION['status'] != "login"){ header("location:login.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    
    <link rel="icon" href="../assets/favicon.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f4f4; color: #333; padding: 20px; font-family: 'Poppins', sans-serif; }
        .admin-container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .header-admin { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; }
        .header-admin h2 { margin: 0; font-size: 1.5rem; text-align: left; color: #333; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; margin-top: 10px; }
        th { background: #2c3e50; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; vertical-align: middle; }
        td img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .action-group { display: flex; gap: 5px; }
    </style>
</head>
<body>
    <div class="admin-container">
        
        <div class="header-admin">
            <h2><i class="fa-solid fa-gauge-high" style="color:var(--primary);"></i> Dashboard</h2>
            <div style="display: flex; gap: 10px;">
                <a href="pengaturan.php" class="btn-action btn-dark btn-sm">
                    <i class="fa-solid fa-gear"></i> Pengaturan Web
                </a>
                <a href="logout.php" class="btn-action btn-red btn-sm">
                    <i class="fa-solid fa-power-off"></i> Logout
                </a>
            </div>
        </div>

        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="../index.php" target="_blank" class="btn-action btn-blue">
                <i class="fa-solid fa-eye"></i> Lihat Website
            </a>
            <a href="tambah.php" class="btn-action btn-green">
                <i class="fa-solid fa-plus-circle"></i> Tambah Kopi Baru
            </a>
        </div>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Ambil semua data produk dari yang paling baru
                    $data = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><img src="../<?php echo $d['image']; ?>" onerror="this.src='../assets/img/menu/2.jpg';"></td>
                        <td><strong><?php echo $d['name']; ?></strong></td>
                        <td style="color:var(--success);">Rp <?php echo number_format($d['price']); ?></td>
                        <td>
                            <div class="action-group">
                                <a href="edit.php?id=<?php echo $d['id']; ?>" class="btn-action btn-sm btn-blue">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?php echo $d['id']; ?>" class="btn-action btn-sm btn-red" onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
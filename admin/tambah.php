<?php include '../koneksi.php'; session_start(); 
// Cek sesi login dulu
if($_SESSION['status'] != "login"){ header("location:login.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f4f4; padding: 40px 20px; color: #333; display: flex; justify-content: center; }
        .admin-container { width: 100%; max-width: 500px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        h3 { color: #333; margin-bottom: 20px; text-align: center; font-size: 1.5rem; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h3><i class="fa-solid fa-circle-plus" style="color:var(--success);"></i> Tambah Menu</h3>
        
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Menu</label>
            <input type="text" name="name" required placeholder="Contoh: Kopi Susu Aren">
            
            <label>Harga (Tanpa titik/koma)</label>
            <input type="number" name="price" required placeholder="Contoh: 15000">
            
            <label>Gambar Produk (Opsional)</label>
            <input type="file" name="image" style="background: #fff; padding: 10px 0;">
            <small style="color: #666; font-size: 0.8rem;">*Jika dikosongkan, akan menggunakan gambar default.</small>
            
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="dashboard.php" class="btn-action btn-dark" style="flex: 1;">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" name="submit" class="btn-green" style="flex: 2;">
                    <i class="fa-solid fa-save"></i> Simpan Menu
                </button>
            </div>
        </form>

        <?php
        // Proses pas tombol simpan dipencet
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            
            // Gambar default kalo user gak upload
            $final_path = "assets/img/menu/2.jpg"; 

            // Cek ada file gambar yang diupload gak
            if(!empty($_FILES['image']['name'])) {
                $rand = rand();
                $filename = $_FILES['image']['name'];
                $target_path = "assets/img/menu/".$rand."_".$filename;
                
                // Pindahin file ke folder tujuan
                if(move_uploaded_file($_FILES['image']['tmp_name'], "../".$target_path)){
                    $final_path = $target_path;
                }
            }

            // Masukin data ke database
            $query = mysqli_query($conn, "INSERT INTO products VALUES(NULL, '$name', '$price', '$final_path')");
            
            if($query) {
                echo "<script>alert('Menu Berhasil Ditambahkan!'); window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Gagal Menambah Data');</script>";
            }
        }
        ?>
    </div>
</body>
</html>
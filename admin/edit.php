<?php 
include '../koneksi.php'; 
session_start();
if($_SESSION['status'] != "login"){ header("location:login.php"); }
$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$id'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
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
        <h3><i class="fa-solid fa-pen-to-square" style="color:var(--info);"></i> Edit Menu</h3>
        
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Menu</label>
            <input type="text" name="name" value="<?php echo $d['name']; ?>" required>
            
            <label>Harga</label>
            <input type="number" name="price" value="<?php echo $d['price']; ?>" required>
            
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="image" style="background: #fff; padding: 10px 0;">
            <div style="margin: 10px 0; text-align: center;">
                <p style="font-size: 0.8rem; color: #666;">Gambar Saat Ini:</p>
                <img src="../<?php echo $d['image']; ?>" style="height: 80px; border-radius: 8px;">
            </div>
            
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="dashboard.php" class="btn-action btn-dark" style="flex: 1;">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" name="update" class="btn-blue" style="flex: 2;">
                    <i class="fa-solid fa-check"></i> Update Data
                </button>
            </div>
        </form>

        <?php
        if(isset($_POST['update'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $img_name = $_FILES['image']['name'];
            
            if($img_name != "") {
                $rand = rand();
                $path = "assets/img/menu/".$rand."_".$img_name;
                move_uploaded_file($_FILES['image']['tmp_name'], "../".$path);
                mysqli_query($conn, "UPDATE products SET name='$name', price='$price', image='$path' WHERE id='$id'");
            } else {
                mysqli_query($conn, "UPDATE products SET name='$name', price='$price' WHERE id='$id'");
            }
            echo "<script>alert('Data Berhasil Diupdate!'); window.location='dashboard.php';</script>";
        }
        ?>
    </div>
</body>
</html>
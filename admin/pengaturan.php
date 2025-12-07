<?php
session_start();
include '../koneksi.php';
// Cek login
if($_SESSION['status'] != "login"){ header("location:login.php"); }
// Ambil data settingan yang udah ada
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM page_settings WHERE id=1"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Konten</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: #f4f4f4; padding: 20px; color: #333; }
        .admin-container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .form-section { margin-bottom: 30px; border: 1px solid #eee; padding: 20px; border-radius: 8px; }
        .form-section h4 { color: var(--primary); margin-bottom: 15px; font-size: 1.1rem; text-transform: uppercase; border-bottom: 2px solid var(--primary); display: inline-block; padding-bottom: 5px;}
        .preview-box { display: flex; align-items: center; gap: 10px; margin-top: 10px; background: #f9f9f9; padding: 10px; border-radius: 8px; }
        .preview-box img { width: 100px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2><i class="fa-solid fa-sliders"></i> Pengaturan Website</h2>
            <a href="dashboard.php" class="btn-action btn-dark btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-section">
                <h4><i class="fa-solid fa-image"></i> Hero Section</h4>
                <label>Judul Utama</label>
                <input type="text" name="hero_title" value="<?php echo $data['hero_title']; ?>">
                
                <label>Deskripsi Sub-Judul</label>
                <textarea name="hero_desc" rows="3"><?php echo $data['hero_desc']; ?></textarea>
                
                <label>Background Hero</label>
                <input type="file" name="hero_bg" style="background:#fff; padding:5px;">
                <div class="preview-box">
                    <span>Saat ini:</span>
                    <img src="../<?php echo $data['hero_bg']; ?>">
                </div>
            </div>

            <div class="form-section">
                <h4><i class="fa-solid fa-info-circle"></i> About Section</h4>
                <label>Judul About</label>
                <input type="text" name="about_title" value="<?php echo $data['about_title']; ?>">
                
                <label>Cerita Kami</label>
                <textarea name="about_desc" rows="5"><?php echo $data['about_desc']; ?></textarea>
                
                <label>Gambar About</label>
                <input type="file" name="about_img" style="background:#fff; padding:5px;">
                <div class="preview-box">
                    <span>Saat ini:</span>
                    <img src="../<?php echo $data['about_img']; ?>">
                </div>
            </div>

            <div class="form-section">
                <h4><i class="fa-solid fa-address-book"></i> Kontak Utama</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label>Email</label>
                        <input type="text" name="contact_email" value="<?php echo $data['contact_email']; ?>">
                    </div>
                    <div>
                        <label>No WhatsApp</label>
                        <input type="text" name="contact_phone" value="<?php echo $data['contact_phone']; ?>">
                    </div>
                </div>
                <label>Alamat Lengkap</label>
                <input type="text" name="contact_address" value="<?php echo $data['contact_address']; ?>">
            </div>

            <div class="form-section">
                <h4><i class="fa-solid fa-share-nodes"></i> Link Sosial Media</h4>
                <label><i class="fa-brands fa-instagram"></i> Link Instagram</label>
                <input type="text" name="link_ig" value="<?php echo isset($data['link_ig']) ? $data['link_ig'] : '#'; ?>">
                <label><i class="fa-brands fa-twitter"></i> Link Twitter / X</label>
                <input type="text" name="link_twitter" value="<?php echo isset($data['link_twitter']) ? $data['link_twitter'] : '#'; ?>">
                <label><i class="fa-brands fa-facebook"></i> Link Facebook</label>
                <input type="text" name="link_fb" value="<?php echo isset($data['link_fb']) ? $data['link_fb'] : '#'; ?>">
            </div>

            <button type="submit" name="simpan" class="btn-green btn-block" style="padding: 15px; font-size: 1.1rem;">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Perubahan
            </button>
        </form>

        <?php
        // Proses simpan semua perubahan
        if(isset($_POST['simpan'])){
            // Tangkap semua inputan
            $hero_title = $_POST['hero_title'];
            $hero_desc  = $_POST['hero_desc'];
            $about_title = $_POST['about_title'];
            $about_desc  = $_POST['about_desc'];
            $contact_address = $_POST['contact_address'];
            $contact_phone   = $_POST['contact_phone'];
            $contact_email   = $_POST['contact_email'];
            $link_ig = $_POST['link_ig'];
            $link_twitter = $_POST['link_twitter'];
            $link_fb = $_POST['link_fb'];

            // Logika upload background hero baru
            $update_hero_img = "";
            if($_FILES['hero_bg']['name'] != ""){
                $path = "assets/img/".rand()."_".$_FILES['hero_bg']['name'];
                move_uploaded_file($_FILES['hero_bg']['tmp_name'], "../".$path);
                $update_hero_img = ", hero_bg='$path'";
            }

            // Logika upload gambar about baru
            $update_about_img = "";
            if($_FILES['about_img']['name'] != ""){
                $path = "assets/img/".rand()."_".$_FILES['about_img']['name'];
                move_uploaded_file($_FILES['about_img']['tmp_name'], "../".$path);
                $update_about_img = ", about_img='$path'";
            }

            // Query update panjang banget
            $sql = "UPDATE page_settings SET 
                    hero_title='$hero_title', hero_desc='$hero_desc', 
                    about_title='$about_title', about_desc='$about_desc',
                    contact_address='$contact_address', contact_phone='$contact_phone', contact_email='$contact_email',
                    link_ig='$link_ig', link_twitter='$link_twitter', link_fb='$link_fb'
                    $update_hero_img $update_about_img 
                    WHERE id=1";
            
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Perubahan Tersimpan!'); window.location='pengaturan.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan');</script>";
            }
        }
        ?>
    </div>
</body>
</html>
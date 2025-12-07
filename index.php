<?php 
include 'koneksi.php'; 
$settings_query = mysqli_query($conn, "SELECT * FROM page_settings WHERE id=1");
$site = mysqli_fetch_assoc($settings_query);

$nomor_db = $site['contact_phone'];
$nomor_wa = preg_replace('/[^0-9]/', '', $nomor_db);
if(substr($nomor_wa, 0, 1) == '0'){
    $nomor_wa = '62' . substr($nomor_wa, 1);
}

if(isset($_POST['kirim_kontak'])){
    $nama  = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $hp    = htmlspecialchars($_POST['hp']);
    $pesan = htmlspecialchars($_POST['pesan']);

    $text_wa = "Halo Admin Kopi Tether, ada pesan baru dari website:%0a%0a";
    $text_wa .= "*Nama:* $nama%0a";
    $text_wa .= "*Email:* $email%0a";
    $text_wa .= "*No HP:* $hp%0a";
    $text_wa .= "*Pesan:*%0a$pesan";

    $link_redirect = "https://wa.me/$nomor_wa?text=$text_wa";
    header("Location: $link_redirect");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopi Tether BREW</title>
  
  <link rel="icon" href="assets/favicon.png" type="image/png">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
      .hero { background-image: url('<?php echo $site['hero_bg']; ?>'); }
  </style>
</head>
<body>

  <nav class="navbar">
    <a href="#" class="navbar-logo">Tether<span>BREW</span>.</a>
    <input type="checkbox" id="search-toggle-input">
    <div class="navbar-nav">
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#menu">Menu</a>
      <a href="#contact">Kontak</a>
    </div>
    <div class="navbar-extra">
      <label for="search-toggle-input"><i class="fa-solid fa-magnifying-glass"></i></label>
      <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
    <form action="index.php#menu" method="GET" class="search-form">
      <input type="search" name="keyword" placeholder="Cari menu kopi...">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </nav>

  <section class="hero" id="home">
    <div class="content">
      <h1><?php echo $site['hero_title']; ?></h1>
      <p><?php echo $site['hero_desc']; ?></p>
      <a href="#menu" class="btn-pesan btn-gold" style="margin-top: 20px; border-radius: 50px; padding: 12px 30px;">
          Beli Sekarang
      </a>
    </div>
  </section>

  <section id="about" class="about">
    <h2><?php echo $site['about_title']; ?></h2>
    <div style="display: flex; gap: 3rem; flex-wrap: wrap; justify-content: center; align-items: center;">
      <div style="flex: 1 1 300px;">
        <?php 
           $aboutImg = $site['about_img'];
           if(empty($aboutImg) || !file_exists($aboutImg)){
               $aboutImg = 'https://placehold.co/400x300/333/d4af37?text=About+Image';
           }
        ?>
        <img src="<?php echo $aboutImg; ?>" alt="About" style="width:100%; border-radius:15px; box-shadow: 0 5px 15px rgba(0,0,0,0.5);">
      </div>
      <div style="flex: 1 1 400px;">
        <h3 style="color:var(--primary); margin-bottom:1rem; font-size:1.8rem;">Cerita Kami</h3>
        <p style="line-height:1.8; text-align: justify;"><?php echo nl2br($site['about_desc']); ?></p>
      </div>
    </div>
  </section>

  <section id="menu" class="menu">
    <h2><span>Menu</span> Kami</h2>
    <?php if(isset($_GET['keyword'])): ?>
      <div style="text-align:center; margin-bottom:30px;">
        <span style="background:var(--primary); color:#000; padding:5px 15px; border-radius:20px; font-weight:bold;">
          Hasil: "<?php echo htmlspecialchars($_GET['keyword']); ?>"
        </span>
        <a href="index.php#menu" style="color:#fff; margin-left:10px; text-decoration:underline; font-size:0.9rem;">Reset</a>
      </div>
    <?php endif; ?>

    <div class="row">
      <?php
      $query = isset($_GET['keyword']) ? 
               "SELECT * FROM products WHERE name LIKE '%".$_GET['keyword']."%' ORDER BY id DESC" : 
               "SELECT * FROM products ORDER BY id DESC";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $harga = number_format($row['price'], 0, ',', '.');
          $gambarDB = $row['image'];
          if(!empty($gambarDB) && file_exists($gambarDB)){
              $gambarFinal = $gambarDB;
          } else {
              $gambarFinal = "https://placehold.co/300x250/222/d4af37?text=" . urlencode($row['name']);
          }
          $pesan = "Halo, saya ingin memesan *" . $row['name'] . "* (Rp " . $harga . ")";
          $link_beli = "https://wa.me/" . $nomor_wa . "?text=" . urlencode($pesan);
      ?>
          <div class="menu-card">
            <img src="<?php echo $gambarFinal; ?>" alt="<?php echo $row['name']; ?>" loading="lazy">
            <div>
              <h3><?php echo $row['name']; ?></h3>
              <p class="menu-card-price">Rp <?php echo $harga; ?></p>
            </div>
            <a href="<?php echo $link_beli; ?>" target="_blank" class="btn-pesan btn-gold btn-block" style="border-radius: 50px;">
              <i class="fa-brands fa-whatsapp"></i> Pesan Sekarang
            </a>
          </div>
      <?php
        }
      } else {
        echo "<p style='width:100%; text-align:center; padding:20px; background:#333; border-radius:10px;'>Menu tidak ditemukan.</p>";
      }
      ?>
    </div>
  </section>

  <section id="contact" class="contact">
    <h2><span>Kontak</span> Kami</h2>
    <div class="row">
      <form action="" method="POST">
        <div class="input-group">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="input-group">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" placeholder="Email Aktif" required>
        </div>
        <div class="input-group">
          <i class="fa-solid fa-phone"></i>
          <input type="text" name="hp" placeholder="No WhatsApp" required>
        </div>
        <div class="input-group">
          <i class="fa-solid fa-comment"></i>
          <textarea name="pesan" placeholder="Tulis pesan Anda disini..." rows="3" required style="border:none; background:transparent; color:#fff; padding:15px 10px; width:100%; font-family:inherit;"></textarea>
        </div>
        <button type="submit" name="kirim_kontak" class="btn-pesan btn-gold btn-block" style="margin-top: 1rem;">
            <i class="fa-solid fa-paper-plane"></i> Kirim ke WhatsApp
        </button>
      </form>
    </div>
  </section>

  <footer>
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:2rem; text-align:left; max-width:1200px; margin:0 auto;">
        <div>
            <h3 style="color:var(--primary); margin-bottom:15px;">Alamat</h3>
            <p><i class="fa-solid fa-location-dot"></i> <?php echo $site['contact_address']; ?></p>
        </div>
        <div>
            <h3 style="color:var(--primary); margin-bottom:15px;">Kontak</h3>
            <p><i class="fa-solid fa-phone"></i> <?php echo $site['contact_phone']; ?></p>
            <p><i class="fa-solid fa-envelope"></i> <?php echo $site['contact_email']; ?></p>
        </div>
        <div>
            <h3 style="color:var(--primary); margin-bottom:15px;">Sosial</h3>
            <div class="socials" style="text-align:left; margin:0;">
                <a href="<?php echo isset($site['link_ig']) ? $site['link_ig'] : '#'; ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="<?php echo isset($site['link_twitter']) ? $site['link_twitter'] : '#'; ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                <a href="<?php echo isset($site['link_fb']) ? $site['link_fb'] : '#'; ?>" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            </div>
            <br>
            <a href="admin/login.php" class="btn-sm btn-gold" style="text-decoration:none; color: white;">
                <i class="fa-solid fa-lock"></i> Admin Login
            </a>
        </div>
    </div>
    <div class="credit">
      <p>&copy; 2025 PaRa Brew. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
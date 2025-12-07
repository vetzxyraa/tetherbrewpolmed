-- Bersihin database lama kalo ada, biar fresh
DROP DATABASE IF EXISTS db_kopi_tether;

-- Bikin database baru
CREATE DATABASE db_kopi_tether;
USE db_kopi_tether;

-- Login
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Masukin satu akun admin default
INSERT INTO admins (username, password) VALUES ('admin', 'admin123');


-- Produk
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Isi data dummy biar gak kosong pas pertama kali jalan
INSERT INTO products (name, price, image) VALUES 
('Espresso Nendang', 15000, 'assets/img/menu/dummy_espresso.jpg'),
('Cappuccino Creamy', 22000, 'assets/img/menu/dummy_cappuccino.jpg'),
('Latte Art Hati', 25000, 'assets/img/menu/dummy_latte.jpg'),
('Americano Dingin', 18000, 'assets/img/menu/dummy_americano.jpg'),
('Mochaccino Coklat', 24000, 'assets/img/menu/dummy_mocha.jpg'),
('Vietnam Drip Kuat', 20000, 'assets/img/menu/dummy_vietnam.jpg'),
('V60 Manual Brew', 28000, 'assets/img/menu/dummy_v60.jpg'),
('Kopi Gula Aren', 18000, 'assets/img/menu/dummy_aren.jpg');

-- Tabel 
CREATE TABLE page_settings (
    id INT PRIMARY KEY,
    
    -- Bagian Banner Atas
    hero_title VARCHAR(255),
    hero_desc TEXT,
    hero_bg VARCHAR(255),
    
    -- Bagian Tentang Kami
    about_title VARCHAR(255),
    about_desc TEXT,
    about_img VARCHAR(255),
    
    -- Kontak & Footer
    contact_address TEXT,
    contact_email VARCHAR(100),
    contact_phone VARCHAR(50),
    
    -- Link Sosmed
    link_ig VARCHAR(255) DEFAULT '#',
    link_twitter VARCHAR(255) DEFAULT '#',
    link_fb VARCHAR(255) DEFAULT '#'
);

-- Masukin data default buat settingan halaman
INSERT INTO page_settings (
    id, 
    hero_title, hero_desc, hero_bg, 
    about_title, about_desc, about_img, 
    contact_address, contact_email, contact_phone,
    link_ig, link_twitter, link_fb
) 
VALUES (
    1, 
    -- Banner
    'Brew Your Mood', 
    'Dari biji terbaik hingga ke cangkirmu, kami meracik rasa untuk menemani harimu.', 
    'assets/img/header-bg.jpeg', 
    
    -- Tentang Kami
    'Kenapa memilih kami?', 
    'Tether Brew hadir dari kecintaan kami pada kopi. Kami berkomitmen menyajikan rasa terbaik dengan suasana yang nyaman dan pelayanan ramah. Setiap biji kopi kami dipilih dari petani lokal terbaik.', 
    'assets/img/tentangkami2.jpeg',
    
    -- Kontak
    'Jl. Kopi Nikmat No. 123, Surabaya, Jawa Timur',
    'info@parabrew.com',
    '082380202322', 
    
    -- Sosmed
    'https://instagram.com/kopi_tether',
    '#',
    '#'
);
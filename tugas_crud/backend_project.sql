CREATE DATABASE IF NOT EXISTS backend_project;
USE backend_project;
CREATE TABLE products (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255),
    status ENUM('Tersedia','Kosong') DEFAULT 'Tersedia'
);
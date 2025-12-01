<form action="create.php" method="post" enctype="multipart/form-data">
    Nama Produk: <input type="text" name="nama_barang" required><br>
    Kategori: <input type="text" name="kategori" required><br>
    Harga: <input type="number" step="0.01" name="harga" required><br>
    Stok: <input type="number" name="stok" required><br>
    Status: 
    <select name="status">
        <option value="Tersedia">Tersedia</option>
        <option value="Kosong">Kosong</option>
    </select><br>
    Gambar: <input type="file" name="gambar" accept="image/*"><br>
    <button type="submit">Simpan</button>
</form>

<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori    = $_POST['kategori'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $status      = $_POST['status'];

    // Validasi file upload
    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (in_array($_FILES['gambar']['type'], $allowedTypes) && $_FILES['gambar']['size'] <= $maxSize) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES['gambar']['name']);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $targetFile;
            }
        } else {
            echo "File tidak valid!";
        }
    }

    // Insert ke database
    $sql = "INSERT INTO products (nama_barang, kategori, harga, stok, gambar, status) 
            VALUES (:nama_barang, :kategori, :harga, :stok, :gambar, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_barang' => $nama_barang,
        ':kategori'    => $kategori,
        ':harga'       => $harga,
        ':stok'        => $stok,
        ':gambar'      => $gambar,
        ':status'      => $status
    ]);

    echo "Data sudah ditambahkan! <a href='read.php'>Lihat Data</a>";
}
?>
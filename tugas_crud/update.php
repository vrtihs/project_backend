<?php
require 'config.php';

$id = $_GET['id_barang'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id_barang = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori    = $_POST['kategori'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $status      = $_POST['status'];
    $gambar      = $product['gambar']; // default gambar lama

    // Jika upload file baru
    if (!empty($_FILES['gambar']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024;

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
        }
    }

    $sql = "UPDATE products 
            SET nama_barang=:nama_barang, kategori=:kategori, harga=:harga, stok=:stok, 
                gambar=:gambar, status=:status 
            WHERE id_barang=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_barang' => $nama_barang,
        ':kategori'    => $kategori,
        ':harga'       => $harga,
        ':stok'        => $stok,
        ':gambar'      => $gambar,
        ':status'      => $status,
        ':id'          => $id
    ]);

    echo "Data berhasil diupdate! <a href='read.php'>Kembali</a>";
}
?>

<form action="update.php?id_barang=<?= $id ?>" method="post" enctype="multipart/form-data">
    Nama Produk: <input type="text" name="nama_barang" value="<?= htmlspecialchars($product['nama_barang']) ?>" required><br>
    Kategori: <input type="text" name="kategori" value="<?= htmlspecialchars($product['kategori']) ?>" required><br>
    Harga: <input type="number" step="0.01" name="harga" value="<?= $product['harga'] ?>" required><br>
    Stok: <input type="number" name="stok" value="<?= $product['stok'] ?>" required><br>
    Status: 
    <select name="status">
        <option value="Tersedia" <?= $product['status']=='Tersedia'?'selected':'' ?>>Tersedia</option>
        <option value="Kosong" <?= $product['status']=='Kosong'?'selected':'' ?>>Kosong</option>
    </select><br>
    Gambar: <input type="file" name="gambar" accept="image/*"><br>
    <?php if ($product['gambar']): ?>
        <img src="<?= htmlspecialchars($product['gambar']) ?>" width="50"><br>
    <?php endif; ?>
    <button type="submit">Update</button>
</form>

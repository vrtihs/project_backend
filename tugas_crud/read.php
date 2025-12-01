<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<h2>Daftar Produk</h2>
<a href="create.php">Tambah Produk</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Status</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= $p['id_barang'] ?></td>
        <td><?= htmlspecialchars($p['nama_barang']) ?></td>
        <td><?= htmlspecialchars($p['kategori']) ?></td>
        <td><?= number_format($p['harga'], 2, ',', '.') ?></td>
        <td><?= $p['stok'] ?></td>
        <td><?= $p['status'] ?></td>
        <td>
            <?php if ($p['gambar']): ?>
                <img src="<?= htmlspecialchars($p['gambar']) ?>" width="50">
            <?php endif; ?>
        </td>
        <td>
            <a href="update.php?id_barang=<?= $p['id_barang'] ?>">Edit</a> | 
            <a href="delete.php?id_barang=<?= $p['id_barang'] ?>" onclick="return confirm('Apakah anda yakin untuk menghapus?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

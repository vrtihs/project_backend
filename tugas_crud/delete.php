<?php 
require 'config.php';

if (isset($_GET['id_barang'])) {
    $id = $_GET['id_barang'];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id_barang = :id");
    $stmt->execute([':id' => $id]);

    echo "Data berhasil dihapus! <a href='read.php'>Kembali</a>";
} else {
    echo "ID tidak ditemukan!";
}
?>

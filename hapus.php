<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;

if ($id) {
    // Jalankan perintah hapus data berdasarkan ID
    $query = "DELETE FROM data_omti WHERE id = '$id'";
    mysqli_query($conn, $query);
}

// Kembalikan ke halaman utama setelah data dihapus
header("Location: index.php");
exit();
?>
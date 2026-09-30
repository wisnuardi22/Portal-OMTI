<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? 'User';
$divisi = $_SESSION['nama_divisi'] ?? '-';
$departemen = $_SESSION['nama_departemen'] ?? '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard OMTI</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include "includes/sidebar.php"; ?>
    <?php include "includes/header.php"; ?>

    <div class="content">
        <div class="card-sap">
            <h2>Selamat Datang, <?= $nama ?></h2>
            <p>Portal Manajemen Kinerja Terintegrasi OMTI</p>
        </div>
        
        <br>
        
        <div class="card-sap">
            <h3>Unit Kerja Aktif</h3>
            <br>
            <table>
                <tr>
                    <td width="150">Divisi</td>
                    <td>: <?= $divisi ?></td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>: <?= $departemen ?></td>
                </tr>
            </table>
        </div>
        
        <br>
        
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
            <div class="card-sap">
                <h3>KPI OMTI</h3>
                <p>Monitoring target dan realisasi KPI</p>
                <br>
                <a href="index.php">Masuk KPI</a>
            </div>
            
            <div class="card-sap">
                <h3>Initiative</h3>
                <p>Program strategis dan inisiatif</p>
            </div>
            
            <div class="card-sap">
                <h3>Laporan</h3>
                <p>Reporting performance</p>
            </div>
        </div>
    </div>

</body>
</html>
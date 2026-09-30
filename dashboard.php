<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? 'User';
$divisi = $_SESSION['nama_divisi'] ?? '-';
$departemen = $_SESSION['nama_departemen'] ?? '-';
$unitLabel = trim(($divisi !== '-' ? $divisi : '') . ($departemen !== '-' ? ' / ' . $departemen : ''), ' /');
if ($unitLabel === '') $unitLabel = 'Unit kerja belum dipilih';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard OMTI</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include "includes/sidebar.php"; ?>
    <?php include "includes/header.php"; ?>

    <main class="content">
        <div class="breadcrumb"><strong>Dashboard</strong> &nbsp;›&nbsp; OMTI</div>
        <section class="page-heading">
            <div>
                <h1 class="page-title">Dashboard <strong>OMTI</strong></h1>
                <div class="page-subtitle">Objectives, Measurements, Targets, and Initiatives</div>
            </div>
            <span class="omti-pill">Portal Manajemen Kinerja</span>
        </section>

        <section class="card-sap">
            <div class="omti-toolbar">
                <div>
                    <h2 class="omti-section-title">Selamat datang, <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></h2>
                    <p>Kelola dan pantau indikator kinerja unit kerja melalui Portal OMTI.</p>
                </div>
                <div class="omti-filters">
                    <div class="omti-field">
                        <label for="dashboard-year">Tahun</label>
                        <select id="dashboard-year" name="tahun">
                            <?php $yearNow = (int)date('Y'); for ($year = $yearNow + 1; $year >= $yearNow - 3; $year--): ?>
                                <option value="<?= $year ?>" <?= $year === $yearNow ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="omti-kpi-grid">
                <div class="omti-kpi"><div class="omti-kpi-label">Unit Kerja Aktif</div><div class="omti-kpi-value" style="font-size:14px"><?= htmlspecialchars($unitLabel, ENT_QUOTES, 'UTF-8') ?></div><div class="omti-kpi-note">Unit sesuai sesi pengguna</div></div>
                <div class="omti-kpi"><div class="omti-kpi-label">Modul OMTI</div><div class="omti-kpi-value">01</div><div class="omti-kpi-note">Pengelolaan indikator kinerja</div></div>
                <div class="omti-kpi"><div class="omti-kpi-label">Periode Penilaian</div><div class="omti-kpi-value" id="period-value"><?= date('Y') ?></div><div class="omti-kpi-note">Tahun yang dipilih</div></div>
                <div class="omti-kpi"><div class="omti-kpi-label">Status Sistem</div><div class="omti-kpi-value" style="font-size:16px;color:#57952c">Aktif</div><div class="omti-kpi-note">Sesi pengguna terautentikasi</div></div>
            </div>
        </section>

        <section class="card-sap">
            <div class="omti-toolbar">
                <h2 class="omti-section-title">Akses Modul</h2>
                <span class="omti-muted">Pilih menu untuk melanjutkan</span>
            </div>
            <div class="omti-kpi-grid">
                <article class="omti-kpi">
                    <div class="omti-kpi-label">PENGELOLAAN KPI</div>
                    <div class="omti-kpi-value" style="font-size:15px">Mapping OMTI</div>
                    <p>Input dan kelola perspective, objective, measurement, bobot, formula, serta target kuartalan.</p>
                    <a class="omti-btn" href="index.php">Buka Mapping</a>
                </article>
                <article class="omti-kpi">
                    <div class="omti-kpi-label">MONITORING</div>
                    <div class="omti-kpi-value" style="font-size:15px">Summary Pencapaian</div>
                    <p>Lihat ringkasan pencapaian dan rekapitulasi indikator kinerja yang tersedia.</p>
                    <a class="omti-btn omti-btn-outline" href="summary.php">Lihat Summary</a>
                </article>
                <article class="omti-kpi">
                    <div class="omti-kpi-label">PROGRAM STRATEGIS</div>
                    <div class="omti-kpi-value" style="font-size:15px">Initiative</div>
                    <p>Area untuk pengelolaan inisiatif pendukung pencapaian KPI.</p>
                    <span class="omti-pill">Pengembangan bertahap</span>
                </article>
                <article class="omti-kpi">
                    <div class="omti-kpi-label">PELAPORAN</div>
                    <div class="omti-kpi-value" style="font-size:15px">Laporan OMTI</div>
                    <p>Akses rekap data kinerja dan keluaran laporan dari modul yang tersedia.</p>
                    <a class="omti-btn omti-btn-outline" href="summary.php">Buka Laporan</a>
                </article>
            </div>
        </section>

        <section class="card-sap">
            <h2 class="omti-section-title">Informasi Unit Kerja</h2>
            <div class="omti-table-wrap">
                <table class="omti-table">
                    <thead><tr><th style="width:35%">Informasi</th><th>Nilai</th></tr></thead>
                    <tbody>
                        <tr><td>Nama Pengguna</td><td><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></td></tr>
                        <tr><td>Divisi</td><td><?= htmlspecialchars($divisi, ENT_QUOTES, 'UTF-8') ?></td></tr>
                        <tr><td>Departemen</td><td><?= htmlspecialchars($departemen, ENT_QUOTES, 'UTF-8') ?></td></tr>
                    </tbody>
                </table>
            </div>
        </section>
        <footer class="omti-footer">OMTI · Portal Manajemen Kinerja Terpadu</footer>
    </main>
    <script>
    document.getElementById('dashboard-year')?.addEventListener('change', function () {
        document.getElementById('period-value').textContent = this.value;
    });
    </script>
</body>
</html>

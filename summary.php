<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

// FILTER
$tahun = $_GET['tahun'] ?? date('Y');
$direktorat = $_GET['direktorat'] ?? '';
$divisi = $_GET['divisi'] ?? '';
$departemen = $_GET['departemen'] ?? '';
$kuartal = $_GET['kuartal'] ?? '';

// QUERY SUMMARY
$sql = "
SELECT 
    d.nama_divisi,
    dp.nama_departemen,
    SUM(k.target) as target,
    SUM(k.realisasi) as realisasi,
    ROUND((SUM(k.realisasi) / SUM(k.target)) * 100, 2) as persen
FROM data_omti k
LEFT JOIN master_divisi d ON k.divisi = d.id
LEFT JOIN master_departemen dp ON k.departemen = dp.id
WHERE k.tahun = '$tahun'
";

// FILTER DINAMIS
if ($divisi != '') {
    $sql .= " AND k.divisi = '$divisi'";
}

if ($departemen != '') {
    $sql .= " AND k.departemen = '$departemen'";
}

$sql .= " GROUP BY d.id, dp.id";
$data = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Summary Pencapaian OMTI</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
.filter-box {
    background: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}
th {
    background: #075eaf;
    color: white;
    padding: 12px;
}
td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.btn-download {
    background: #198754;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
}
</style>
</head>
<body>

<?php include "includes/sidebar.php"; ?>
<?php include "includes/header.php"; ?>

<div class="content">
    <h2>Summary Pencapaian</h2>
    
    <div class="filter-box">
        <form method="GET">
            Tahun :
            <select name="tahun">
                <option>2026</option>
                <option>2025</option>
            </select>

            Divisi :
            <select name="divisi" id="divisi">
                <option value="">Semua Divisi</option>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM master_divisi ORDER BY nama_divisi");
                while ($r = mysqli_fetch_assoc($q)) {
                    echo "<option value='" . $r['id'] . "'>" . $r['nama_divisi'] . "</option>";
                }
                ?>
            </select>

            Departemen :
            <select name="departemen" id="departemen">
                <option value="">Semua Departemen</option>
            </select>

            Kuartal :
            <select name="kuartal">
                <option value="">Semua</option>
                <option>Q1</option>
                <option>Q2</option>
                <option>Q3</option>
                <option>Q4</option>
            </select>

            <button>Filter</button>
            <a class="btn-download" href="summary_download.php?tahun=<?=$tahun?>">Download</a>
        </form>
    </div>

        <table class="table-summary">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2" class="unit">DIREKTORAT/DIVISI/DEPARTEMEN</th>
                <th colspan="3">Q1</th>
                <th colspan="3">Q2</th>
                <th colspan="3">Q3</th>
                <th colspan="3">Q4</th>
            </tr>
            <tr>
                <th>TARGET<br>NILAI</th>
                <th>PENCAPAIAN</th>
                <th>%</th>
                <th>TARGET<br>NILAI</th>
                <th>PENCAPAIAN</th>
                <th>%</th>
                <th>TARGET<br>NILAI</th>
                <th>PENCAPAIAN</th>
                <th>%</th>
                <th>TARGET<br>NILAI</th>
                <th>PENCAPAIAN</th>
                <th>%</th>
            </tr>
        </thead>
    </table>
</div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#divisi').change(function(){
            let divisi = $(this).val();

            $.ajax({
                url: 'ambil_departemen.php',
                method: 'POST',
                data: {
                    divisi: divisi
                },
                success: function(data){
                    $('#departemen').html(data);
                }
            });
        });
    });
    </script>
</body>
</html>
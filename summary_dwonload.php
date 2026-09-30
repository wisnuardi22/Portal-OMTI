<?php
include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Summary_Pencapaian.xls");

$tahun = $_GET['tahun'] ?? date('Y');

echo "<table border='1'>
<tr>
    <th>Divisi</th>
    <th>Departemen</th>
    <th>Target</th>
    <th>Realisasi</th>
    <th>%</th>
</tr>";

$sql = "
SELECT 
    d.nama_divisi,
    dp.nama_departemen,
    SUM(k.target) as target,
    SUM(k.realisasi) as realisasi
FROM data_omti k
LEFT JOIN master_divisi d ON k.divisi = d.id
LEFT JOIN master_departemen dp ON k.departemen = dp.id
WHERE k.tahun = '$tahun'
GROUP BY d.id, dp.id
";

$q = mysqli_query($conn, $sql);

while ($r = mysqli_fetch_assoc($q)) {
    $persen = 0;
    if ($r['target'] > 0) {
        $persen = ($r['realisasi'] / $r['target']) * 100;
    }
    
    echo "<tr>
        <td>" . $r['nama_divisi'] . "</td>
        <td>" . $r['nama_departemen'] . "</td>
        <td>" . $r['target'] . "</td>
        <td>" . $r['realisasi'] . "</td>
        <td>" . round($persen, 2) . "%</td>
    </tr>";
}

echo "</table>";
?>
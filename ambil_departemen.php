<?php
include 'koneksi.php';

$divisi = $_POST['divisi'];

$query = mysqli_query($conn, "
    SELECT * 
    FROM master_departemen 
    WHERE divisi_id = '$divisi' 
    ORDER BY nama_departemen ASC
");

echo '<option value="">Semua Departemen</option>';

while ($row = mysqli_fetch_assoc($query)) {
    echo "<option value='" . $row['id'] . "'>" . $row['nama_departemen'] . "</option>";
}
?>
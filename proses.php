<?php
include 'koneksi.php';

$tahun = $_POST['tahun'];
$divisi = $_POST['divisi'];
$dept   = $_POST['departemen'];
$pers   = $_POST['perspective'];
$obj    = $_POST['objective'];
$meas   = $_POST['measurement'];
$defn   = $_POST['definition'];
$sat    = $_POST['satuan'];
$bobot  = $_POST['bobot'];
$form   = $_POST['formula'];

// Menampung kuartal Q1 sampai Q4
$data_kuartal = [
    "Q1" => ["target" => $_POST['target_q1'], "realisasi" => $_POST['realisasi_q1']],
    "Q2" => ["target" => $_POST['target_q2'], "realisasi" => $_POST['realisasi_q2']],
    "Q3" => ["target" => $_POST['target_q3'], "realisasi" => $_POST['realisasi_q3']],
    "Q4" => ["target" => $_POST['target_q4'], "realisasi" => $_POST['realisasi_q4']]
];

$sukses = true;

// Melakukan perulangan otomatis (Unpivot) untuk Q1, Q2, Q3, Q4
foreach($data_kuartal as $q => $nilai) {
    $tgt  = ($nilai["target"] !== "") ? $nilai["target"] : "0";
    $real = ($nilai["realisasi"] !== "") ? "'" . $nilai["realisasi"] . "'" : "NULL";

    $sql = "INSERT INTO data_omti (tahun, divisi, departemen, perspective, objective, measurement, definition, satuan, bobot, formula, kuartal, target, realisasi) 
            VALUES ($tahun, '$divisi', '$dept', '$pers', '$obj', '$meas', '$defn', '$sat', $bobot, '$form', '$q', $tgt, $real)";
    
    if (!mysqli_query($conn, $sql)) {
        $sukses = false;
        echo "Gagal menyimpan $q: " . mysqli_error($conn) . "<br>";
    }
}

if ($sukses) {
    header("Location: index.php"); 
    exit;
}
?>
<?php 
include 'koneksi.php'; 

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

// 1. Ambil data sampel utama berdasarkan ID yang diklik
$query = mysqli_query($conn, "SELECT * FROM data_omti WHERE id='$id' LIMIT 1");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit();
}

$tahun = $data['tahun'];
$divisi = $data['divisi'];
$measurement = $data['measurement'];

// 2. Proses jika tombol Update ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_tahun = $_POST['tahun'];
    $new_divisi = $_POST['divisi'];
    $new_departemen = $_POST['departemen'];
    $new_perspective = $_POST['perspective'];
    $new_objective = $_POST['objective'];
    $new_measurement = $_POST['measurement'];
    $new_bobot = $_POST['bobot'];
    $new_satuan = $_POST['satuan'];
    $new_definition = $_POST['definition'];
    $new_formula = $_POST['formula'];

    // Update informasi umum untuk semua baris yang memiliki indikator & divisi sama
    $update_umum = "UPDATE data_omti SET 
                    tahun='$new_tahun', 
                    divisi='$new_divisi', 
                    departemen='$new_departemen', 
                    perspective='$new_perspective', 
                    objective='$new_objective', 
                    measurement='$new_measurement', 
                    bobot='$new_bobot', 
                    satuan='$new_satuan', 
                    definition='$new_definition', 
                    formula='$new_formula' 
                  WHERE tahun='$tahun' AND divisi='$divisi' AND measurement='$measurement'";
    mysqli_query($conn, $update_umum);

    // Update target & realisasi per kuartal (Q1 - Q4)
    $kuartals = ['Q1', 'Q2', 'Q3', 'Q4'];
    foreach ($kuartals as $q) {
        $t = $_POST['target_' . strtolower($q)] ?? 0;
        $r = $_POST['realisasi_' . strtolower($q)] ?? 0;

        // Cek apakah data kuartal ini sudah ada di database
        $cek_q = mysqli_query($conn, "SELECT id FROM data_omti WHERE tahun='$new_tahun' AND divisi='$new_divisi' AND measurement='$new_measurement' AND kuartal='$q'");
        
        if (mysqli_num_rows($cek_q) > 0) {
            // Jika ada, update nilainya
            mysqli_query($conn, "UPDATE data_omti SET target='$t', realisasi='$r' WHERE tahun='$new_tahun' AND divisi='$new_divisi' AND measurement='$new_measurement' AND kuartal='$q'");
        } else {
            // Jika belum ada baris kuartal tersebut, buat baris baru
            mysqli_query($conn, "INSERT INTO data_omti (tahun, divisi, departemen, perspective, objective, measurement, bobot, satuan, definition, formula, kuartal, target, realisasi) VALUES ('$new_tahun', '$new_divisi', '$new_departemen', '$new_perspective', '$new_objective', '$new_measurement', '$new_bobot', '$new_satuan', '$new_definition', '$new_formula', '$q', '$t', '$r')");
        }
    }

    header("Location: index.php");
    exit();
}

// 3. Ambil data Q1 - Q4 secara lengkap berdasarkan kelompok indikator yang sama
$q_data = [];
$res_q = mysqli_query($conn, "SELECT kuartal, target, realisasi FROM data_omti WHERE tahun='$tahun' AND divisi='$divisi' AND measurement='$measurement'");
if ($res_q && mysqli_num_rows($res_q) > 0) {
    while($row_q = mysqli_fetch_assoc($res_q)) {
        $q_data[$row_q['kuartal']] = [
            'target' => $row_q['target'] ?? '',
            'realisasi' => $row_q['realisasi'] ?? ''
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Indikator OMTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F3F4F7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #32363A; }
        .sap-header { background-color: #0A6ED1; color: white; padding: 15px 25px; font-weight: 600; }
        .sap-card { background: #FFFFFF; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #E4E5E7; margin: 30px auto; padding: 25px; max-width: 900px; }
        .sap-title { font-size: 1.1rem; font-weight: 600; color: #1D2D3E; margin-bottom: 20px; border-bottom: 2px solid #0A6ED1; padding-bottom: 10px; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #515456; }
        .btn-sap { background-color: #0A6ED1; color: white; font-weight: 600; border-radius: 0.25rem; padding: 10px 20px; border: none; }
        .btn-sap:hover { background-color: #0854A0; color: white; }
    </style>
</head>
<body>

<div class="sap-header mb-4">
    <div class="container-fluid">Sistem Manajemen Kinerja OMTI Terpadu - Edit Data</div>
</div>

<div class="container">
    <div class="sap-card">
        <div class="sap-title">Form Edit Indikator OMTI</div>
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?= $data['tahun'] ?? '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Divisi</label>
                    <input type="text" name="divisi" class="form-control" value="<?= $data['divisi'] ?? '' ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Departemen</label>
                    <input type="text" name="departemen" class="form-control" value="<?= $data['departemen'] ?? '' ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Perspective</label>
                    <input type="text" name="perspective" class="form-control" value="<?= $data['perspective'] ?? '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Objective</label>
                    <input type="text" name="objective" class="form-control" value="<?= $data['objective'] ?? '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Measurement</label>
                    <input type="text" name="measurement" class="form-control" value="<?= $data['measurement'] ?? '' ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Definition</label>
                    <textarea name="definition" class="form-control" rows="2"><?= $data['definition'] ?? '' ?></textarea>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="<?= $data['satuan'] ?? '' ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control" value="<?= $data['bobot'] ?? '' ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Formula</label>
                    <input type="text" name="formula" class="form-control" value="<?= $data['formula'] ?? '' ?>" required>
                </div>
            </div>

            <div class="section-label bg-light p-2 mb-3 fw-bold text-primary">Nilai Target & Realisasi Q1 - Q4</div>
            <?php foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $q): ?>
                <div class="row mb-2">
                    <div class="col-md-2 fw-bold align-self-center"><?= $q ?></div>
                    <div class="col-md-5">
                        <input type="number" step="0.01" name="target_<?= strtolower($q) ?>" class="form-control" placeholder="Target <?= $q ?>" value="<?= isset($q_data[$q]['target']) ? $q_data[$q]['target'] : '' ?>">
                    </div>
                    <div class="col-md-5">
                        <input type="number" step="0.01" name="realisasi_<?= strtolower($q) ?>" class="form-control border-success" placeholder="Realisasi <?= $q ?>" value="<?= isset($q_data[$q]['realisasi']) ? $q_data[$q]['realisasi'] : '' ?>">
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-secondary px-4">Kembali</a>
                <button type="submit" class="btn-sap px-5">UPDATE DATA</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
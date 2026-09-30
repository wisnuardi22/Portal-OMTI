<?php 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kinerja OMTI Terpadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F3F4F7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #32363A; overflow-x: hidden; }
        
        /* Layout Sidebar & Main Content (Dengan Transisi Buka/Tutup) */
        #wrapper { display: flex; width: 100%; align-items: stretch; }
        #sidebar { min-width: 260px; max-width: 260px; background: #1D2D3E; color: #fff; min-height: 100vh; transition: all 0.3s; margin-left: 0; }
        #sidebar.active { margin-left: -260px; } /* Kondisi saat sidebar tertutup */
        
        #sidebar .sidebar-header { padding: 20px; background: #15202b; font-weight: bold; font-size: 1.1rem; border-bottom: 1px solid #2c3e50; }
        #sidebar ul.components { padding: 20px 0; }
        #sidebar ul li a { padding: 12px 20px; font-size: 0.9rem; display: block; color: #cfd8dc; text-decoration: none; transition: 0.2s; border-left: 4px solid transparent; }
        #sidebar ul li a:hover, #sidebar ul li.active a { color: #fff; background: #2c3e50; border-left: 4px solid #0A6ED1; }
        
        #content { width: 100%; padding: 20px; min-height: 100vh; transition: all 0.3s; }

        .sap-header { background-color: #0A6ED1; color: white; padding: 15px 25px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 0.35rem; }
        .sap-card { background: #FFFFFF; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #E4E5E7; margin-bottom: 25px; padding: 25px; }
        .sap-title { font-size: 1.1rem; font-weight: 600; color: #1D2D3E; margin-bottom: 20px; border-bottom: 2px solid #0A6ED1; padding-bottom: 10px; display: inline-block;}
        .form-label { font-size: 0.85rem; font-weight: 600; color: #515456; margin-bottom: 4px; }
        .form-control, .form-select { border: 1px solid #89919A; border-radius: 0.25rem; font-size: 0.9rem; padding: 8px 12px; background-color: #FAFAFA;}
        .form-control:focus { border-color: #0A6ED1; box-shadow: inset 0 0 0 1px #0A6ED1; background-color: #FFF;}
        .section-label { background-color: #EBF3FA; color: #0A6ED1; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.9rem; margin-bottom: 15px; border-left: 4px solid #0A6ED1;}
        .btn-sap { background-color: #0A6ED1; color: white; font-weight: 600; border-radius: 0.25rem; padding: 10px 20px; border: none; letter-spacing: 0.5px;}
        .btn-sap:hover { background-color: #0854A0; color: white; }
        
        /* Desain Tabel & Pengaturan Lebar Kolom Fix */
        .sap-table { font-size: 0.8rem; table-layout: fixed; width: 100%; transition: transform 0.2s ease; transform-origin: top left; }
        .sap-table th { background-color: #F8F9FA; color: #495057; font-weight: 600; border-bottom: 2px solid #CED4DA; text-align: center; vertical-align: middle; }
        
        .col-def { width: 950px !important; min-width: 950px !important; white-space: normal; word-wrap: break-word; }
        .c-action { width: 140px !important; min-width: 140px !important; }

        .column-toggler { background: #F8F9FA; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #E4E5E7; display: block; }
        .column-toggler label { font-size: 0.82rem; margin-right: 15px; margin-bottom: 6px; font-weight: 600; cursor: pointer; color: #495057; display: inline-block;}
        .toggle-header { cursor: pointer; user-select: none; color: #0A6ED1; font-weight: 600; }
        .toggle-header:hover { color: #0854A0; }
        
        /* Tombol Toggle Sidebar */
        .btn-toggle-sidebar { background: #0854A0; border: none; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.9rem; }
        .btn-toggle-sidebar:hover { background: #063d75; color: white; }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- ================= SIDEBAR MENU ================= -->
    <nav id="sidebar">
        <div class="sidebar-header">
            OMTI Portal
        </div>
        <ul class="list-unstyled components">
            <li class="active">
                <a href="index.php">Dashboard Kinerja</a>
            </li>
            <li>
                <a href="#entrySection" onclick="document.getElementById('entrySection').scrollIntoView({behavior: 'smooth'});">Entry Data Baru</a>
            </li>
            <li>
                <a href="#tableSection" onclick="document.getElementById('tableSection').scrollIntoView({behavior: 'smooth'});">Rekapitulasi Tabel</a>
            </li>
        </ul>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <div id="content">
        <div class="sap-header mb-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Tombol Buka/Tutup Sidebar -->
                <button type="button" id="sidebarCollapse" class="btn-toggle-sidebar me-3" onclick="toggleSidebar()">
                    ☰ Menu
                </button>
                <span>Sistem Manajemen Kinerja OMTI Terpadu</span>
            </div>
        </div>

        <div class="container-fluid px-0">
            
            <!-- ================= FORM INPUT ================= -->
            <div class="sap-card" id="entrySection">
                <div class="sap-title">Entry Data Indikator OMTI</div>
                <form action="proses.php" method="POST">
                    
                    <div class="section-label">1. Informasi Umum & Divisi</div>
                    <div class="row mb-3">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="2026" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Divisi</label>
                            <select name="divisi" class="form-select" required>
                                <option value="">-- Pilih Divisi --</option>
                                <option value="Risbang">Risbang (Riset & Pengembangan)</option>
                                <option value="Keuangan">Keuangan & Akuntansi</option>
                                <option value="Operasional">Operasional</option>
                                <option value="Pemasaran">Pemasaran & Penjualan</option>
                                <option value="IT">Teknologi Informasi (IT)</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Departemen</label>
                            <input type="text" name="departemen" class="form-control" placeholder="Cth: Dept Pengembangan Produk" required>
                        </div>
                    </div>

                    <div class="section-label">2. Definisi Indikator</div>
                    <div class="row mb-3">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Perspective</label>
                            <select name="perspective" class="form-select" required>
                                <option value="Financial">Financial</option>
                                <option value="Customer">Customer</option>
                                <option value="Internal Business Process">Internal Process</option>
                                <option value="Learning & Growth">Learning & Growth</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3"><label class="form-label">Objective</label><input type="text" name="objective" class="form-control" required></div>
                        <div class="col-md-5 mb-3"><label class="form-label">Measurement (Indikator)</label><input type="text" name="measurement" class="form-control" required></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Definition (Penjelasan Indikator)</label>
                            <textarea name="definition" class="form-control" rows="2" placeholder="Indikator yang menunjukkan..."></textarea>
                        </div>
                        <div class="col-md-2 mb-3"><label class="form-label">Satuan</label><input type="text" name="satuan" class="form-control" placeholder="Jumlah / %" required></div>
                        <div class="col-md-2 mb-3"><label class="form-label">Bobot</label><input type="number" step="0.01" name="bobot" class="form-control" placeholder="10" required></div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Formula</label>
                            <select name="formula" class="form-select" required>
                                <option value="F1">F1</option>
                                <option value="F2">F2</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-label">3. Target Q1 - Q4</div>
                    <div class="row mb-4">
                        <div class="col-md-3"><label class="form-label">Target Q1</label><input type="number" step="0.01" name="target_q1" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Target Q2</label><input type="number" step="0.01" name="target_q2" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Target Q3</label><input type="number" step="0.01" name="target_q3" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Target Q4</label><input type="number" step="0.01" name="target_q4" class="form-control" required></div>
                    </div>

                    <div class="section-label">4. Realisasi Q1 - Q4 (Kosongkan jika belum berjalan)</div>
                    <div class="row mb-4">
                        <div class="col-md-3"><label class="form-label text-success">Realisasi Q1</label><input type="number" step="0.01" name="realisasi_q1" class="form-control border-success"></div>
                        <div class="col-md-3"><label class="form-label text-success">Realisasi Q2</label><input type="number" step="0.01" name="realisasi_q2" class="form-control border-success"></div>
                        <div class="col-md-3"><label class="form-label text-success">Realisasi Q3</label><input type="number" step="0.01" name="realisasi_q3" class="form-control border-success"></div>
                        <div class="col-md-3"><label class="form-label text-success">Realisasi Q4</label><input type="number" step="0.01" name="realisasi_q4" class="form-control border-success"></div>
                    </div>

                    <div class="text-end"><button type="submit" class="btn-sap px-5">SIMPAN DATA</button></div>
                </form>
            </div>

            <!-- ================= DISPLAY TABEL (FORMAT KORPORAT) ================= -->
            <div class="sap-card" id="tableSection">
                <div class="sap-title mb-3">Display Data Tersimpan (Format Excel Korporat)</div>
                
                <!-- Panel Kontrol Kolom & Tombol Zoom In / Zoom Out -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="toggle-header" onclick="toggleFilterPanel()">
                        <span id="icon-arrow">▼</span> Kontrol Tampilan Kolom
                    </span>
                    
                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary fw-bold" onclick="zoomTable('out')" title="Zoom Out (-)">🔍- Perkecil</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="zoomTable('reset')" title="Reset Zoom">Reset</button>
                        <button type="button" class="btn btn-outline-secondary fw-bold" onclick="zoomTable('in')" title="Zoom In (+)">🔍+ Perbesar</button>
                    </div>
                </div>
                
                <div id="filter-panel" class="column-toggler">
                    <label><input type="checkbox" id="chk-c-thn" checked onchange="toggleView('c-thn')"> Tahun</label>
                    <label><input type="checkbox" id="chk-c-div" checked onchange="toggleView('c-div')"> Divisi</label>
                    <label><input type="checkbox" id="chk-c-dept" checked onchange="toggleView('c-dept')"> Departemen</label>
                    <label><input type="checkbox" id="chk-c-pers" checked onchange="toggleView('c-pers')"> Perspective</label>
                    <label><input type="checkbox" id="chk-c-obj" checked onchange="toggleView('c-obj')"> Objective</label>
                    <label><input type="checkbox" id="chk-c-meas" checked onchange="toggleView('c-meas')"> Measurement</label>
                    <label><input type="checkbox" id="chk-c-bobot" checked onchange="toggleView('c-bobot')"> Bobot</label>
                    <label><input type="checkbox" id="chk-c-satuan" checked onchange="toggleView('c-satuan')"> Satuan</label>

                    <span class="text-muted mx-2">|</span>
                    <label class="text-primary"><input type="checkbox" id="chk-tq1" checked onchange="toggleView('tq1')"> Target Q1</label>
                    <label class="text-primary"><input type="checkbox" id="chk-tq2" checked onchange="toggleView('tq2')"> Target Q2</label>
                    <label class="text-primary"><input type="checkbox" id="chk-tq3" checked onchange="toggleView('tq3')"> Target Q3</label>
                    <label class="text-primary"><input type="checkbox" id="chk-tq4" checked onchange="toggleView('tq4')"> Target Q4</label>
                    <span class="text-muted mx-2">|</span>
                    <label class="text-success"><input type="checkbox" id="chk-rq1" checked onchange="toggleView('rq1')"> Realisasi Q1</label>
                    <label class="text-success"><input type="checkbox" id="chk-rq2" checked onchange="toggleView('rq2')"> Realisasi Q2</label>
                    <label class="text-success"><input type="checkbox" id="chk-rq3" checked onchange="toggleView('rq3')"> Realisasi Q3</label>
                    <label class="text-success"><input type="checkbox" id="chk-rq4" checked onchange="toggleView('rq4')"> Realisasi Q4</label>
                    
                    <span class="text-muted mx-2">|</span>
                    <label><input type="checkbox" id="chk-c-def" checked onchange="toggleView('c-def')"> Definition</label>
                    <label><input type="checkbox" id="chk-c-form" checked onchange="toggleView('c-form')"> Formula</label>
                </div>

                <div class="table-responsive">
                    <table id="mainTable" class="table sap-table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th rowspan="2" class="c-thn">Tahun</th>
                                <th rowspan="2" class="c-div">Divisi</th>
                                <th rowspan="2" class="c-dept">Departemen</th>
                                <th rowspan="2" class="c-pers">Perspective</th>
                                <th rowspan="2" class="c-obj">Objective</th>
                                <th rowspan="2" class="c-meas">Measurement</th>
                                <th rowspan="2" class="c-bobot">Bobot</th>
                                <th rowspan="2" class="c-satuan">Satuan</th>
                                
                                <!-- TARGET & REALISASI DI TENGAH -->
                                <th id="th-target" colspan="4" class="bg-light text-primary fw-bold">TARGET</th>
                                <th id="th-realisasi" colspan="4" class="bg-light text-success fw-bold">REALISASI</th>
                                
                                <th rowspan="2" class="c-def">Definition</th>
                                <th rowspan="2" class="c-form">Formula</th>
                                <th rowspan="2" class="c-action text-center">Aksi</th>
                            </tr>
                            <tr>
                                <th class="tq1 bg-light">Q1</th>
                                <th class="tq2 bg-light">Q2</th>
                                <th class="tq3 bg-light">Q3</th>
                                <th class="tq4 bg-light">Q4</th>
                                <th class="rq1 bg-light">Q1</th>
                                <th class="rq2 bg-light">Q2</th>
                                <th class="rq3 bg-light">Q3</th>
                                <th class="rq4 bg-light">Q4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, tahun, divisi, departemen, perspective, objective, measurement, bobot, satuan, definition, formula,
                                    MAX(CASE WHEN kuartal = 'Q1' THEN target END) as t_q1,
                                    MAX(CASE WHEN kuartal = 'Q2' THEN target END) as t_q2,
                                    MAX(CASE WHEN kuartal = 'Q3' THEN target END) as t_q3,
                                    MAX(CASE WHEN kuartal = 'Q4' THEN target END) as t_q4,
                                    MAX(CASE WHEN kuartal = 'Q1' THEN realisasi END) as r_q1,
                                    MAX(CASE WHEN kuartal = 'Q2' THEN realisasi END) as r_q2,
                                    MAX(CASE WHEN kuartal = 'Q3' THEN realisasi END) as r_q3,
                                    MAX(CASE WHEN kuartal = 'Q4' THEN realisasi END) as r_q4
                                    FROM data_omti 
                                    GROUP BY tahun, divisi, departemen, perspective, objective, measurement, bobot, satuan, definition, formula
                                    ORDER BY id DESC LIMIT 15";
                            
                            $result = mysqli_query($conn, $sql);
                            
                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='c-thn text-center'>" . ($row['tahun'] ?? '-') . "</td>";
                                    echo "<td class='c-div fw-bold'>" . ($row['divisi'] ?? '-') . "</td>";
                                    echo "<td class='c-dept'>" . ($row['departemen'] ?? '-') . "</td>";
                                    echo "<td class='c-pers'>" . ($row['perspective'] ?? '-') . "</td>";
                                    echo "<td class='c-obj'>" . ($row['objective'] ?? '-') . "</td>";
                                    echo "<td class='c-meas'>" . ($row['measurement'] ?? '-') . "</td>";
                                    echo "<td class='c-bobot text-center'>" . ($row['bobot'] ?? '-') . "</td>";
                                    echo "<td class='c-satuan text-center'>" . ($row['satuan'] ?? '-') . "</td>";
                                    
                                    // TARGET Q1 - Q4
                                    echo "<td class='tq1 text-end'>" . ($row['t_q1'] ?? '-') . "</td>";
                                    echo "<td class='tq2 text-end'>" . ($row['t_q2'] ?? '-') . "</td>";
                                    echo "<td class='tq3 text-end'>" . ($row['t_q3'] ?? '-') . "</td>";
                                    echo "<td class='tq4 text-end'>" . ($row['t_q4'] ?? '-') . "</td>";

                                    // REALISASI Q1 - Q4
                                    echo "<td class='rq1 text-end text-success fw-bold'>" . ($row['r_q1'] ?? '-') . "</td>";
                                    echo "<td class='rq2 text-end text-success fw-bold'>" . ($row['r_q2'] ?? '-') . "</td>";
                                    echo "<td class='rq3 text-end text-success fw-bold'>" . ($row['r_q3'] ?? '-') . "</td>";
                                    echo "<td class='rq4 text-end text-success fw-bold'>" . ($row['r_q4'] ?? '-') . "</td>";
                                    
                                    // DEFINITION
                                    echo "<td class='c-def col-def'>" . ($row['definition'] ?? '-') . "</td>";
                                    
                                    // FORMULA & AKSI
                                    echo "<td class='c-form text-center'><span class='badge bg-secondary'>" . ($row['formula'] ?? '-') . "</span></td>";

                                    echo "<td class='c-action text-center text-nowrap'>";
                                    echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning py-0 px-2 me-1'>Edit</a>";
                                    echo "<a href='hapus.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger py-0 px-2' onclick='return confirm(\"Apakah Anda yakin ingin menghapus indikator ini?\")'>Hapus</a>";
                                    echo "</td>";
                                    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='17' class='text-center text-muted py-3'>Belum ada data indikator tersimpan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk Buka / Tutup Sidebar
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

    var currentScale = 1.0;

    function zoomTable(action) {
        var table = document.getElementById('mainTable');
        if (action === 'in') {
            currentScale += 0.1;
        } else if (action === 'out') {
            if (currentScale > 0.6) currentScale -= 0.1;
        } else {
            currentScale = 1.0;
        }
        table.style.transform = "scale(" + currentScale + ")";
    }

    function toggleView(clsName) {
        var checkbox = document.getElementById('chk-' + clsName);
        var elements = document.getElementsByClassName(clsName);
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.display = checkbox.checked ? "" : "none";
        }
        updateColspan();
    }

    function updateColspan() {
        var targetCount = 0;
        ['tq1', 'tq2', 'tq3', 'tq4'].forEach(function(q) {
            var chk = document.getElementById('chk-' + q);
            if (chk && chk.checked) targetCount++;
        });

        var realisasiCount = 0;
        ['rq1', 'rq2', 'rq3', 'rq4'].forEach(function(q) {
            var chk = document.getElementById('chk-' + q);
            if (chk && chk.checked) realisasiCount++;
        });

        var thTarget = document.getElementById('th-target');
        var thRealisasi = document.getElementById('th-realisasi');

        if (thTarget) {
            thTarget.setAttribute('colspan', targetCount > 0 ? targetCount : 1);
            thTarget.style.display = targetCount > 0 ? "" : "none";
        }
        if (thRealisasi) {
            thRealisasi.setAttribute('colspan', realisasiCount > 0 ? realisasiCount : 1);
            thRealisasi.style.display = realisasiCount > 0 ? "" : "none";
        }
    }

    function toggleFilterPanel() {
        var panel = document.getElementById('filter-panel');
        var arrow = document.getElementById('icon-arrow');
        if (panel.style.display === "none") {
            panel.style.display = "block";
            arrow.innerHTML = "▼";
        } else {
            panel.style.display = "none";
            arrow.innerHTML = "▶";
        }
    }
</script>
</body>
</html>
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

if (isset($_POST['lanjut'])) {
    $_SESSION['divisi'] = $_POST['divisi'];
    $_SESSION['departemen'] = $_POST['departemen'];
    header("location:dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pilih Unit OMTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #3038D8, #B74CF5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI";
        }
        .card-unit {
            width: 420px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
        }
        .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo img {
            width: 130px;
        }
        .title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #1B2A78;
            margin-bottom: 25px;
        }
        .btn-login {
            background: #3038D8;
            color: white;
            height: 45px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="card-unit">
        <div class="logo">
            <img src="assets/logo-peruri.png">
        </div>
        <div class="title">Pilih Unit Kerja</div>

        <form method="POST">
            <label>Divisi</label>
            <select class="form-select mb-3" name="divisi" id="divisi" required>
                <option value="">-- Pilih Divisi --</option>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM master_divisi ORDER BY id");
                while ($d = mysqli_fetch_assoc($q)) {
                    echo "<option value='".$d['id']."'>".$d['nama_divisi']."</option>";
                }
                ?>
            </select>

            <label>Departemen</label>
            <select class="form-select mb-4" name="departemen" id="departemen" required>
                <option>-- Pilih Departemen --</option>
            </select>

            <button class="btn btn-login w-100" name="lanjut">Masuk Dashboard &rarr;</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $('#divisi').change(function() {
            let id = $(this).val();
            
            $.ajax({
                url: 'ambil_departemen.php',
                method: 'POST',
                data: { divisi: id },
                success: function(data) {
                    $('#departemen').html(data);
                }
            });
        });
    </script>
</body>
</html>
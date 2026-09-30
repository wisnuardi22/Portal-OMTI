<?php
session_start();
include 'koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        header("location:pilih_unit.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login OMTI PERURI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #3038D8, #B74CF5, #F4F5FF);
            font-family: "Segoe UI", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* background kotak SAP */
        body::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            left: -120px;
            top: -100px;
            background: rgba(255,255,255,.15);
            transform: rotate(25deg);
        }

        /* CARD LOGIN */
        .login-card {
            position: relative;
            width: 390px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }

        /* LOGO */
        .logo {
            position: absolute;
            top: 20px;
            left: 25px;
        }

        .logo img {
            width: 120px;
        }

        /* isi */
        .login-content {
            margin-top: 80px;
        }

        .title {
            text-align: center;
            color: #1B2A78;
            font-size: 28px;
            font-weight: 700;
        }

        .subtitle {
            text-align: center;
            color: #68748A;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #D5D9E2;
        }

        .form-control:focus {
            border-color: #343FE0;
            box-shadow: 0 0 0 3px rgba(52,63,224,.15);
        }

        /* BUTTON */
        .btn-login {
            height: 48px;
            width: 100%;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #3038D8, #8C35F4);
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-login:hover {
            opacity: .9;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #7A8599;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 25px;
            color: #999;
            font-size: 13px;
        }

        .divider div {
            height: 1px;
            background: #ddd;
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <img src="assets/logo-peruri.png">
        </div>
        <div class="login-content">
            <div class="title">Selamat Datang</div>
            <div class="subtitle">Sistem Manajemen Kinerja Terpadu OMTI</div>

            <?php if($error){ ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn-login" name="login">Login &rarr;</button>
            </form>

            <div class="footer">
                Lorem ipsum<br>
                Lorem ipsum
            </div>
        </div>
    </div>
</body>
</html>
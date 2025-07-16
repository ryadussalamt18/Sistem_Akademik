<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="global.css/dashboard_adminn.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin!</p>

        <div class="menu">
            <a href="daftar_dosen.php">Daftar Dosen</a>
            <a href="input_matkul.php">Input Mata Kuliah</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>
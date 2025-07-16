<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

$sql_jadwal = "SELECT * FROM krs WHERE nim = ?";
$stmt_jadwal = $conn->prepare($sql_jadwal);
$stmt_jadwal->bind_param("s", $nim);
$stmt_jadwal->execute();
$result_jadwal = $stmt_jadwal->get_result();

$jadwal = [];

while ($row = $result_jadwal->fetch_assoc()) {
    $jadwal[] = $row;
}

$stmt_jadwal->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
    <link rel="stylesheet" href="global_css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffa500;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #333;
        }

        .menu {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #ffa500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #ff8c00;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #ffa500;
            color: #fff;
        }

        .content {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Jadwal Kuliah</h1>
        <div class="content">
            <?php if (!empty($jadwal)) : ?>
                <table>
                    <tr>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Dosen Pengampu</th>
                    </tr>
                    <?php foreach ($jadwal as $jadwal_item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($jadwal_item['kode_matakuliah']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal_item['nama_matakuliah']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal_item['hari']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal_item['jam']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal_item['ruangan']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal_item['dosen_pengampu']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>Anda belum memiliki jadwal kuliah.</p>
            <?php endif; ?>
            <div class="menu">
                <a href="dashboard.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>
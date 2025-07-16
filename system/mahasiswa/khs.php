<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['nim'])) {
    header("Location: login_mahasiswa.php");
    exit();
}

$nim = $_SESSION['nim'];

$sql = "SELECT p.id, krs.nama_matakuliah, p.nilai
        FROM penilaian p
        INNER JOIN krs ON p.id_mahasiswa = (SELECT id FROM data_mahasiswa WHERE nim = krs.nim)
        WHERE krs.nim = '$nim'";

$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHS - Kartu Hasil Studi</title>
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
        <h1>Kartu Hasil Studi</h1>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Matakuliah</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_matakuliah']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nilai']) . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>Tidak ada data KHS yang tersedia.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="menu">
                <a href="dashboard.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
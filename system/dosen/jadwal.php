<?php
session_start();

require 'koneksi.php';

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

$nid_dosen = $_SESSION['nid'];

$sql = "SELECT * FROM matakuliah WHERE nid_dosen = '$nid_dosen'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Matakuliah</title>
    <link rel="stylesheet" href="global_css/jadwal.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .header-text {
            text-align: center;
            color: black;
            background-color: #ffa500;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 1.5em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #ffa500;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td,
        th {
            border-bottom: 1px solid #ddd;
        }

        .menu {
            text-align: center;
            margin-top: 20px;
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

        .btn-absen {
            display: inline-block;
            padding: 5px 10px;
            background-color: #ffa500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-absen:hover {
            background-color: #ff8c00;
        }
    </style>
</head>

<body>
    <div class="header-text">
        Jadwal Matakuliah untuk Dosen dengan NID: <?php echo htmlspecialchars($nid_dosen); ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Matakuliah</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nama_matakuliah']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hari']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jam']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ruangan']) . "</td>";
                    echo "<td><a class='btn-absen' href='absensi_mahasiswa.php?id=" . urlencode($row['id']) . "'>Absen Mahasiswa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada jadwal matakuliah yang tersedia untuk dosen dengan NID: " . htmlspecialchars($nid_dosen) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="menu">
        <a href="dashboard_dosen.php">Kembali ke Dashboard</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>
<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

$nid_dosen = $_SESSION['nid'];
$id_matakuliah = $_GET['id'];

$sql = "SELECT m.id, m.nama 
        FROM krs k 
        JOIN data_mahasiswa m ON k.nim = m.nim 
        WHERE k.kode_matakuliah = (SELECT kode_matakuliah FROM matakuliah WHERE id = '$id_matakuliah')";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['kehadiran']) && is_array($_POST['kehadiran'])) {

        $errors = [];

        foreach ($_POST['kehadiran'] as $id_mahasiswa => $kehadiran) {
            if (!empty($kehadiran)) {
                $sql = "INSERT INTO absensi (id_mahasiswa, id_matakuliah, kehadiran) 
                        VALUES ('$id_mahasiswa', '$id_matakuliah', '$kehadiran')
                        ON DUPLICATE KEY UPDATE kehadiran = '$kehadiran'";
                if (!$conn->query($sql)) {
                    die("Error: " . $conn->error);
                }
            } else {
                $errors[] = "Kehadiran untuk mahasiswa dengan ID $id_mahasiswa tidak boleh kosong.";
            }
        }

        if (empty($errors)) {
            echo "<div style='background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; padding: 15px; margin-bottom: 20px;'>Kehadiran berhasil disimpan.</div>";
        } else {
            foreach ($errors as $error) {
                echo "<div style='background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; padding: 15px; margin-bottom: 10px;'>$error</div>";
            }
        }
    } else {
        echo "<div style='background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; padding: 15px; margin-bottom: 10px;'>Form kehadiran tidak valid atau kosong.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="global_css/jadwal.css">
    <title>Absensi Mahasiswa</title>
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
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
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
            padding: 8px 15px;
            background-color: #ffa500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-absen:hover {
            background-color: #ff8c00;
        }

        .status-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #ffa500;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #ff8c00;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header-text">
        Absensi Mahasiswa untuk Matakuliah ID: <?php echo htmlspecialchars($id_matakuliah); ?>
    </div>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td><input type='text' name='kehadiran[" . htmlspecialchars($row['id']) . "]' class='status-input'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Tidak ada mahasiswa yang terdaftar dalam matakuliah ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <input type="submit" value="Simpan Absensi" class="submit-btn">
        <div class="menu">
            <a href="dashboard_dosen.php">Kembali ke Dashboard</a>
        </div>
    </form>
</body>

</html>

<?php
$conn->close();
?>
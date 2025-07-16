<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

$sql = "SELECT * FROM data_mahasiswa WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $prodi = $user['prodi'];
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

$stmt->close();

if (!isset($_SESSION['krs_temp'])) {
    $_SESSION['krs_temp'] = [];
}

if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    unset($_SESSION['krs_temp'][$index]);
    $_SESSION['krs_temp'] = array_values($_SESSION['krs_temp']);
}

$sql_krs = "SELECT * FROM krs WHERE nim = ?";
$stmt_krs = $conn->prepare($sql_krs);
$stmt_krs->bind_param("s", $nim);
$stmt_krs->execute();
$result_krs = $stmt_krs->get_result();

$krs_exists = false;
$krs_data = [];

if ($result_krs->num_rows > 0) {
    $krs_exists = true;
    while ($row = $result_krs->fetch_assoc()) {
        $krs_data[] = $row;
    }
}

$stmt_krs->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi (KRS)</title>
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group select,
        .form-group button {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #ffa500;
            color: #fff;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #ff8c00;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Kartu Rencana Studi (KRS)</h1>
        <div class="content">
            <?php if ($krs_exists) : ?>
                <p>Anda telah mengambil KRS dengan detail sebagai berikut:</p>
                <table>
                    <tr>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Dosen Pengampu</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                    </tr>
                    <?php foreach ($krs_data as $krs) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($krs['kode_matakuliah']); ?></td>
                            <td><?php echo htmlspecialchars($krs['nama_matakuliah']); ?></td>
                            <td><?php echo htmlspecialchars($krs['sks']); ?></td>
                            <td><?php echo htmlspecialchars($krs['dosen_pengampu']); ?></td>
                            <td><?php echo htmlspecialchars($krs['hari']); ?></td>
                            <td><?php echo htmlspecialchars($krs['jam']); ?></td>
                            <td><?php echo htmlspecialchars($krs['ruangan']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="menu">
                    <a href="dashboard.php">Kembali ke Dashboard</a>
                </div>
            <?php else : ?>
                <p>Anda belum mengambil KRS.</p>
                <form action="krs.php" method="POST">
                    <div class="form-group">
                        <label for="semester">Pilih Semester</label>
                        <select id="semester" name="semester" required>
                            <option value="1">Semester 1</option>
                            <option value="3">Semester 3</option>
                            <option value="5">Semester 5</option>
                            <option value="7">Semester 7</option>
                        </select>
                        <button type="submit">Lihat Mata Kuliah</button>
                    </div>
                </form>

                <?php if (isset($_POST['semester'])) : ?>
                    <?php
                    require 'koneksi.php';

                    $semester = $_POST['semester'];

                    $sql_courses = "SELECT * FROM matakuliah WHERE semester = ? AND prodi = ?";
                    $stmt_courses = $conn->prepare($sql_courses);
                    $stmt_courses->bind_param("is", $semester, $prodi);
                    $stmt_courses->execute();
                    $result_courses = $stmt_courses->get_result();
                    $courses = [];

                    while ($row = $result_courses->fetch_assoc()) {
                        $courses[] = $row;
                    }

                    $stmt_courses->close();
                    $conn->close();
                    ?>
                    <?php if (!empty($courses)) : ?>
                        <form action="add_temp_krs.php" method="POST">
                            <table>
                                <tr>
                                    <th>Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php foreach ($courses as $course) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($course['kode_matakuliah']); ?></td>
                                        <td><?php echo htmlspecialchars($course['nama_matakuliah']); ?></td>
                                        <td><?php echo htmlspecialchars($course['sks']); ?></td>
                                        <td><?php echo htmlspecialchars($course['hari']); ?></td>
                                        <td><?php echo htmlspecialchars($course['jam']); ?></td>
                                        <td>
                                            <button type="submit" name="add" value="<?php echo $course['id']; ?>">Tambah</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <input type="hidden" name="semester" value="<?php echo htmlspecialchars($semester); ?>">
                        </form>
                    <?php else : ?>
                        <p>Tidak ada mata kuliah untuk semester ini.</p>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['krs_temp'])) : ?>
                    <h3>Mata Kuliah yang Dipilih:</h3>
                    <table>
                        <tr>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Dosen Pengampu</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $total_sks = 0;
                        foreach ($_SESSION['krs_temp'] as $index => $course) :
                            $total_sks += $course['sks'];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['kode_matakuliah']); ?></td>
                                <td><?php echo htmlspecialchars($course['nama_matakuliah']); ?></td>
                                <td><?php echo htmlspecialchars($course['sks']); ?></td>
                                <td><?php echo htmlspecialchars($course['hari']); ?></td>
                                <td><?php echo htmlspecialchars($course['jam']); ?></td>
                                <td><?php echo htmlspecialchars($course['dosen_pengampu']); ?></td>
                                <td><?php echo isset($course['ruangan']) ? htmlspecialchars($course['ruangan']) : 'Belum ditentukan'; ?></td>
                                <td>
                                    <form action="krs.php" method="POST">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <button type="submit" name="delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <p>Total SKS: <?php echo $total_sks; ?></p>
                    <form action="save_krs.php" method="POST">
                        <button type="submit">Simpan KRS</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
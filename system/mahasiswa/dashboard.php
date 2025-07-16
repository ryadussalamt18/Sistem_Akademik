<?php
// Mulai sesi
session_start();

// Periksa jika session nim belum diset, redirect ke halaman login
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// Panggil file koneksi ke database
require 'koneksi.php'; // Pastikan jalur file koneksi benar

// Ambil nim dari sesi
$nim = $_SESSION['nim'];

// Query SQL untuk mendapatkan informasi pengguna berdasarkan NIM
$sql = "SELECT * FROM data_mahasiswa WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

// Periksa jika data pengguna ditemukan
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // Jika tidak ditemukan, logika penanganan error
    echo "Data pengguna tidak ditemukan.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Akademik</title>
    <link rel="stylesheet" href="global_css/dashboard.css"> <!-- Hubungkan file CSS -->
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

        .content-section {
            display: none;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 10px 20px;
            background-color: #ffa500;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #ff8c00;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Dashboard Sistem Akademik</h1>
        <div class="menu">
            <a href="#" onclick="showSection('profile')">Profil</a>
            <a href="jadwal.php" onclick="showSection('jadwal')">Jadwal</a>
            <a href="absensi.php" onclick="showSection('absensi')">Absen</a>
            <a href="krs.php">KRS</a>
            <a href="khs.php" onclick="showSection('khs')">KHS</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="content">
            <div id="profile" class="content-section">
                <h2>Informasi Profil Anda</h2>
                <table>
                    <tr>
                        <th>Nama</th>
                        <td><?php echo htmlspecialchars($user['nama']); ?></td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td><?php echo htmlspecialchars($user['nim']); ?></td>
                    </tr>
                    <tr>
                        <th>Fakultas</th>
                        <td><?php echo htmlspecialchars($user['fakultas']); ?></td>
                    </tr>
                    <tr>
                        <th>Prodi</th>
                        <td><?php echo htmlspecialchars($user['prodi']); ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?php echo htmlspecialchars($user['jenis_kelamin']); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?php echo htmlspecialchars($user['tanggal_lahir']); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo htmlspecialchars($user['alamat']); ?></td>
                    </tr>
                </table>
                <br>
                <button onclick="showEditForm()">Edit Profil</button>
            </div>
            <div id="editProfileForm" class="content-section" style="display: none;">
                <h2>Edit Profil</h2>
                <form id="editForm" action="edit_profile.php" method="post">
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required><br>
                    <input type="text" name="nim" value="<?php echo htmlspecialchars($user['nim']); ?>" required readonly><br>
                    <input type="text" name="fakultas" value="<?php echo htmlspecialchars($user['fakultas']); ?>" required><br>
                    <input type="text" name="prodi" value="<?php echo htmlspecialchars($user['prodi']); ?>" required><br>
                    <select name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?php if ($user['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                        <option value="P" <?php if ($user['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
                    </select><br>
                    <input type="date" name="tanggal_lahir" value="<?php echo $user['tanggal_lahir']; ?>" required><br>
                    <textarea name="alamat" rows="4" required><?php echo htmlspecialchars($user['alamat']); ?></textarea><br>
                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
            <div id="jadwal" class="content-section">
                <h2>Jadwal</h2>
                <p>Jadwal perkuliahan Anda akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('content-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }

        function showEditForm() {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
        }

        showSection('profile');
    </script>
</body>

</html>
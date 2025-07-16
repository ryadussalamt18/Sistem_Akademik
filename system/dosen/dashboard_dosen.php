<?php
session_start();
if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}
require 'koneksi.php';
$nid = $_SESSION['nid'];
$sql = "SELECT * FROM dosen WHERE nid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
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
            background-color: #ffa500;
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
            background-color: #ffa500;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Dashboard Sistem Akademik</h1>
        <div class="menu">
            <a href="#" onclick="showSection('profile')">Profil</a>
            <a href="jadwal.php" onclick="showSection('jadwal')">Jadwal</a>
            <a href="daftar_matakuliah.php" onclick="showSection('nilai')">Nilai</a>
            <a href="logout.php">Logout</a>
        </div>

        <div id="profile" class="content-section">
            <h2>Informasi Profil Anda</h2>
            <table>
                <tr>
                    <th>Nama</th>
                    <td><?php echo htmlspecialchars($user['nama']); ?></td>
                </tr>
                <tr>
                    <th>NID</th>
                    <td><?php echo htmlspecialchars($user['nid']); ?></td>
                </tr>
                <tr>
                    <th>Fakultas</th>
                    <td><?php echo htmlspecialchars($user['fakultas']); ?></td>
                </tr>
                <tr>
                    <th>Dosen Prodi</th>
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
            <form action="edit_dosen_profile.php" method="post">
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required><br>
                <input type="text" name="nid" value="<?php echo htmlspecialchars($user['nid']); ?>" readonly><br>
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
            <p>Jadwal Mengajar Anda akan ditampilkan di sini.</p>
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

        showSection('profile');

        function showEditForm() {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
        }
    </script>
</body>

</html>
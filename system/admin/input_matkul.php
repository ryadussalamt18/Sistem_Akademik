<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

$success_message = isset($_GET['success_message']) ? $_GET['success_message'] : '';
$error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Mata Kuliah</title>
    <link rel="stylesheet" href="global.css/dashboard_admin.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Input Mata Kuliah</h1>
        <?php if (!empty($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="process_input.php" method="POST">
            <div class="form-group">
                <label for="kode_mata_kuliah">Kode Mata Kuliah:</label>
                <input type="text" id="kode_matakuliah" name="kode_matakuliah" required>
            </div>
            <div class="form-group">
                <label for="nama_mata_kuliah">Nama Mata Kuliah:</label>
                <input type="text" id="nama_matakuliah" name="nama_matakuliah" required>
            </div>
            <div class="form-group">
                <label for="sks">SKS:</label>
                <input type="number" id="sks" name="sks" min="2" max="4" required>
            </div>
            <div class="form-group">
                <label for="fakultas">Fakultas:</label>
                <select id="fakultas" name="fakultas" onchange="getProdi(this.value)" required>
                    <option value="">Pilih Fakultas</option>
                    <option value="FAKULTAS HUKUM">FAKULTAS HUKUM</option>
                    <option value="FAKULTAS TEKNOLOGI INFORMASI">FAKULTAS TEKNOLOGI INFORMASI</option>
                    <option value="FAKULTAS TEKNIK">FAKULTAS TEKNIK</option>
                </select>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi:</label>
                <select id="prodi" name="prodi" required>
                    <option value="">Pilih Program Studi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ruangan">Ruangan:</label>
                <input type="text" id="ruangan" name="ruangan" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <input type="number" id="semester" name="semester" min="1" max="8" required>
            </div>
            <div class="form-group">
                <label for="nid_dosen">NID Dosen:</label>
                <input type="text" id="nid_dosen" name="nid_dosen" required>
            </div>
            <div class="form-group">
                <label for="dosen_pengampu">Dosen Pengampu:</label>
                <input type="text" id="dosen_pengampu" name="dosen_pengampu" required>
            </div>
            <div class="form-group">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" required>
            </div>
            <div class="form-group">
                <label for="jam">Jam:</label>
                <input type="text" id="jam" name="jam" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        function getProdi(fakultas) {
            let prodiSelect = document.getElementById("prodi");
            prodiSelect.innerHTML = "";

            if (fakultas === "") {
                let optionElem = document.createElement("option");
                optionElem.textContent = "Pilih Program Studi";
                optionElem.value = "";
                prodiSelect.appendChild(optionElem);
            } else if (fakultas === "FAKULTAS HUKUM") {
                let options = ["Pilih Program Studi", "Hukum"];
                options.forEach(option => {
                    let optionElem = document.createElement("option");
                    optionElem.textContent = option;
                    optionElem.value = option;
                    prodiSelect.appendChild(optionElem);
                });
            } else if (fakultas === "FAKULTAS TEKNOLOGI INFORMASI") {
                let options = ["Pilih Program Studi", "Informatika", "Sistem Informasi", "Sistem Komputer"];
                options.forEach(option => {
                    let optionElem = document.createElement("option");
                    optionElem.textContent = option;
                    optionElem.value = option;
                    prodiSelect.appendChild(optionElem);
                });
            } else if (fakultas === "FAKULTAS TEKNIK") {
                let options = ["Pilih Program Studi", "Sipil", "Industri", "Kimia"];
                options.forEach(option => {
                    let optionElem = document.createElement("option");
                    optionElem.textContent = option;
                    optionElem.value = option;
                    prodiSelect.appendChild(optionElem);
                });
            }
        }
    </script>
    <form action="dashboard_admin.php" method="post">
        <button type="submit">Kembali ke Dashboard</button>
    </form>
</body>

</html>
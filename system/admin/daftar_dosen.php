<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

require 'koneksi.php';

$sql_hukum = "SELECT * FROM dosen WHERE fakultas = 'FAKULTAS HUKUM'";
$result_hukum = $conn->query($sql_hukum);

$sql_informatika = "SELECT * FROM dosen WHERE fakultas = 'FAKULTAS TEKNOLOGI INFORMASI'";
$result_informatika = $conn->query($sql_informatika);

$sql_teknik = "SELECT * FROM dosen WHERE fakultas = 'FAKULTAS TEKNIK'";
$result_teknik = $conn->query($sql_teknik);

if (!$result_hukum || !$result_informatika || !$result_teknik) {
    echo "Error: " . $conn->error;
    exit();
}

$dosen_hukum = $result_hukum->fetch_all(MYSQLI_ASSOC);
$dosen_informatika = $result_informatika->fetch_all(MYSQLI_ASSOC);
$dosen_teknik = $result_teknik->fetch_all(MYSQLI_ASSOC);

function displayProfessors($professors)
{
    echo '<table border="1">';
    echo '<tr><th>NID</th><th>Nama</th><th>Program Studi</th></tr>';
    foreach ($professors as $professor) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($professor['nid']) . '</td>';
        echo '<td>' . htmlspecialchars($professor['nama']) . '</td>';
        echo '<td>' . htmlspecialchars($professor['prodi']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css/dashboard_admin.css">
    <title>Daftar Dosen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Daftar Dosen</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#select_fakultas" method="POST">
        <label for="select_fakultas">Pilih Fakultas:</label>
        <select id="select_fakultas" name="select_fakultas">
            <option value="">Piliih Fakultas</option>
            <option value="FAKULTAS HUKUM">FAKULTAS HUKUM</option>
            <option value="FAKULTAS TEKNOLOGI INFORMASI">FAKULTAS TEKNOLOGI INFORMASI</option>
            <option value="FAKULTAS TEKNIK">FAKULTAS TEKNIK</option>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selected_fakultas = $_POST['select_fakultas'];

        switch ($selected_fakultas) {
            case 'FAKULTAS HUKUM':
                echo '<h3 id="hukum">Fakultas Hukum</h3>';
                if (!empty($dosen_hukum)) {
                    displayProfessors($dosen_hukum);
                } else {
                    echo '<p>Tidak ada dosen terdaftar untuk fakultas Hukum.</p>';
                }
                break;

            case 'FAKULTAS TEKNOLOGI INFORMASI':
                echo '<h3 id="informatika">Fakultas Teknologi Informasi</h3>';
                if (!empty($dosen_informatika)) {
                    displayProfessors($dosen_informatika);
                } else {
                    echo '<p>Tidak ada dosen terdaftar untuk fakultas Teknologi Informasi.</p>';
                }
                break;

            case 'FAKULTAS TEKNIK':
                echo '<h3 id="teknik">Fakultas Teknik</h3>';
                if (!empty($dosen_teknik)) {
                    displayProfessors($dosen_teknik);
                } else {
                    echo '<p>Tidak ada dosen terdaftar untuk fakultas Teknik.</p>';
                }
                break;

            default:
                echo '<p>Silakan pilih fakultas untuk menampilkan daftar dosen.</p>';
                break;
        }
    }
    ?>

    <form action="dashboard_admin.php" method="get">
        <button type="submit">Kembali ke Dashboard</button>
    </form>

</body>

</html>
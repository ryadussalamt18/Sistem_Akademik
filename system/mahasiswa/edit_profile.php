<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_SESSION['nim'];
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE data_mahasiswa SET nama=?, fakultas=?, prodi=?, jenis_kelamin=?, tanggal_lahir=?, alamat=? WHERE nim=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nama, $fakultas, $prodi, $jenis_kelamin, $tanggal_lahir, $alamat, $nim);

    if ($stmt->execute()) {
        echo "Profil berhasil diubah.";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Gagal mengubah profil: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

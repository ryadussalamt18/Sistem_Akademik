<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['add'])) {
    die("Tidak ada data yang dikirimkan.");
}

$course_id = $_POST['add'];

$nim = $_SESSION['nim'];

require 'koneksi.php';
$sql_course = "SELECT * FROM matakuliah WHERE id = ?";
$stmt_course = $conn->prepare($sql_course);

$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();

$result_course = $stmt_course->get_result();

if ($result_course->num_rows == 1) {
    $course = $result_course->fetch_assoc();

    $exists_in_krs_temp = false;
    foreach ($_SESSION['krs_temp'] as $krs_course) {
        if ($krs_course['id'] == $course_id) {
            $exists_in_krs_temp = true;
            break;
        }
    }

    if (!$exists_in_krs_temp) {
        $_SESSION['krs_temp'][] = [
            'id' => $course['id'],
            'kode_matakuliah' => $course['kode_matakuliah'],
            'nama_matakuliah' => $course['nama_matakuliah'],
            'sks' => $course['sks'],
            'dosen_pengampu' => $course['dosen_pengampu'],
            'hari' => $course['hari'],
            'jam' => $course['jam'],
            'ruangan' => $course['ruangan']
        ];
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    die("Mata kuliah tidak ditemukan.");
}

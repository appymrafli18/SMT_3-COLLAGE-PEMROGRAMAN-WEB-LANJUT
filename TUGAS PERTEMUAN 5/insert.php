<?php

require_once __DIR__ . '/koneksi.php';

$table_name = 'mahasiswa';

// Skema tabel mahasiswa
$sql = 'CREATE TABLE IF NOT EXISTS `' . $table_name . '` (
    `NIM` int(5) NOT NULL,
    `Nama` varchar(20) NOT NULL,
    `Tugas` int(5) NOT NULL,
    `UTS` int(5) NOT NULL,
    `UAS` int(5) NOT NULL,
    PRIMARY KEY (`NIM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("ERROR: Tabel `$table_name` gagal dibuat: " . mysqli_error($conn));
}

echo 'Tabel ' . $table_name . ' berhasil dibuat <br/>';

// Insert 5 record data mahasiswa
$sql = "INSERT INTO `$table_name` (`NIM`, `Nama`, `Tugas`, `UTS`, `UAS`) VALUES
(10001, 'Andi Pratama', 85, 80, 88),
(10002, 'Budi Santoso', 78, 75, 82),
(10003, 'Citra Lestari', 90, 88, 92),
(10004, 'Dian Safitri', 80, 82, 79),
(10005, 'Eko Wahyudi', 70, 74, 76)";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("ERROR: Data gagal dimasukkan pada tabel `$table_name`: " . mysqli_error($conn));
}

echo "Data berhasil dimasukkan pada tabel `$table_name`";
?>
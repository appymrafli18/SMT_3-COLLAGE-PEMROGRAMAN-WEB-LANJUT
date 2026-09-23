<?php

// require_once __DIR__ . '/koneksi.php';

include 'koneksi.php';

$nama = $_POST['nama'];
$nim = $_POST['nim'];
$alamat = $_POST['alamat'];

mysqli_query($koneksi, "INSERT INTO mahasiswa (nama, nim, alamat) VALUES ('$nama', '$nim', '$alamat')");

header('location:index.php');
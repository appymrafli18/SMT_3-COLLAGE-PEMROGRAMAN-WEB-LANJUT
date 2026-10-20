<?php
/**
 * Koneksi database Tugas Pertemuan 9.
 *
 * MySQL berjalan di Docker dan dipetakan ke port 3306 pada host.
 */

$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = 'root';
$db_name = 'tugas_pertemuan_9';
$db_port = 3306;

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$koneksi) {
  die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');

/**
 * Struktur tabel users:
 * - id int (primary key, auto increment)
 * - name varchar(70) not null
 * - username varchar(50) not null (unik)
 * - email varchar(50) not null (unik)
 * - password varchar(255) not null
 */
$query_tabel = "CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(70) NOT NULL,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($koneksi, $query_tabel)) {
  die('Gagal menyiapkan tabel users: ' . mysqli_error($koneksi));
}
?>

<?php

$koneksi = mysqli_connect("localhost", "root", "root", "portal");

if (mysqli_connect_errno()) {
  echo "Connection failed: " . mysqli_connect_error();
};

// mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS news (
// id INT(11) AUTO_INCREMENT PRIMARY KEY,
// title VARCHAR(255) NOT NULL,
// images_path VARCHAR(255) NOT NULL,
// content TEXT NOT NULL,
// author VARCHAR(100) NOT NULL,
// created DATE NOT NULL
// )");

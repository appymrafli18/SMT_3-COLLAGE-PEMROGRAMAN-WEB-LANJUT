<?php

$db_host = 'localhost'; // name server
$db_user = 'root'; // user server
$db_pass = 'root'; // password server
$db_name = 'latihan'; // name database

// simpan connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// validation gagal or no
if (!$conn) {
  die("Gagal terhubung MySQL:" . mysqli_connect_error());
} else {
  echo "Connection Sucessfully";
}

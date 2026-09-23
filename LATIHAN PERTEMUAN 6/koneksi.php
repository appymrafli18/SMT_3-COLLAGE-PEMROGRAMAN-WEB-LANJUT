<?php

$koneksi = mysqli_connect("localhost", "root", "root", "akademik");

if (mysqli_connect_errno()) {
  echo "Connection failed: " . mysqli_connect_error();
};
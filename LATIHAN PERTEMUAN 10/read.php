<?php

$file = "anggota.json";
$anggota = file_get_contents($file);
$data = json_decode($anggota, true);

foreach ($data as $d) {
    echo $d['no'] . "<br>";
    echo $d['nama'] . "<br>";
    echo $d['alamat'] . "<br>";
}

<?php

$file = "anggota.json";
$anggota = file_get_contents($file);
$data = json_decode($anggota, true);

$data[] = array(
    'no' => 3,
    'nama' => 'Rafli Ke-3',
    'alamat' => 'Jakarta'
);

$jsonfile = json_encode($data, JSON_PRETTY_PRINT);
$anggota = file_put_contents($file, $jsonfile);

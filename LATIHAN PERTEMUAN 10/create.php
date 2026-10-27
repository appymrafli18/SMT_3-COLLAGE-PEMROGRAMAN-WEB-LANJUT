<?php

$data[] = array(
    'no' => 1,
    'nama' => 'Rafli',
    'alamat' => 'Jakarta'
);

$data[] = array(
    'no' => 2,
    'nama' => 'Rafli Kedua',
    'alamat' => 'Jakarta'
);

$jsonfile = json_encode($data, JSON_PRETTY_PRINT);

file_put_contents('anggota.json', $jsonfile);

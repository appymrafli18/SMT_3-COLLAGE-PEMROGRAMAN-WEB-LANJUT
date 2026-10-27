<?php
$file = 'anggota.json';
$anggota = file_get_contents($file);
$data = json_decode($anggota, true);

foreach ($data as $key => $d) {
    if ($d['no'] == 2) {
        $data[$key]['alamat'] = 'Jakarta Updated';
    }
}

$jsonfile = json_encode($data, JSON_PRETTY_PRINT);

$anggota = file_put_contents($file, $jsonfile);
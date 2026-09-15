<?php

require_once __DIR__ . '/koneksi.php';

$sql = 'SELECT NIM, Nama, Tugas, UTS, UAS, (Tugas + UTS + UAS)/3 AS Nilai_Akhir FROM mahasiswa';
$query = mysqli_query($conn, $sql);

if (!$query) {
    die("SQL ERROR: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menampilkan Data Mahasiswa dengan mysqli_fetch_array</title>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 600px;
    }

    th,
    td {
      font-size: 13px;
      border: 1px solid #DEDEDE;
      padding: 6px 8px;
      color: #303030;
    }

    th {
      background-color: #CCCCCC;
      font-size: 12px;
      border-color: #B0B0B0;
      text-align: left;
    }

    .center {
      text-align: center;
    }

    .right {
      text-align: right;
    }
  </style>
</head>

<body>

  <table>
    <thead>
      <tr>
        <th class="center">NIM</th>
        <th>Nama</th>
        <th class="right">Tugas</th>
        <th class="right">UTS</th>
        <th class="right">UAS</th>
        <th class="right">Nilai Akhir</th>
      </tr>
    </thead>

    <tbody>
      <?php while ($row = mysqli_fetch_array($query)): ?>
        <tr>
          <td class="center"><?= htmlspecialchars($row['NIM']) ?></td>
          <td><?= htmlspecialchars($row['Nama']) ?></td>
          <td class="right"><?= $row['Tugas'] ?></td>
          <td class="right"><?= $row['UTS'] ?></td>
          <td class="right"><?= $row['UAS'] ?></td>
          <td class="right"><?= number_format($row['Nilai_Akhir'], 2) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>

</html>

<?php

mysqli_free_result($query);
mysqli_close($conn);

?>
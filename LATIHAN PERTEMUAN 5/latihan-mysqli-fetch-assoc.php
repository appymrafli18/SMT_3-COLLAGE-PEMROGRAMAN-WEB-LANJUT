<?php

require_once __DIR__ . '/latihan-fungsi-mysqli-connect.php';

$sql = 'SELECT id_produk, tgl_transaksi, harga, kuantitas FROM sales';
$query = mysqli_query($conn, $sql);

if (!$query) {
  die("SQL ERROR:" . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menampilkan Data Tabel MySQL dengan mysqli_fetch_array</title>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    table {
      border-collapse: collapse;
    }

    th,
    td {
      font-size: 13px;
      border: 1px solid #DEDEDE;
      padding: 3px 5px;
      color: #303030;
    }

    th {
      background-color: #CCCCCC;
      font-size: 12px;
      border-color: #B0B0B0;
    }

    .subtotal td {
      background: #F8F8F8;
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
        <th>Id Produk</th>
        <th>Tanggal Transaksi</th>
        <th>Harga</th>
        <th>Kuantitas</th>
      </tr>
    </thead>

    <tbody>
      <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= $row['id_produk'] ?></td>
          <td><?= $row['tgl_transaksi'] ?></td>
          <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
          <td class="right"><?= $row['kuantitas'] ?></td>
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
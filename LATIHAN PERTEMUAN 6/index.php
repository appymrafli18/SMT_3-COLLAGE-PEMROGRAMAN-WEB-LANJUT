<?php
    include 'koneksi.php';
    $no = 1;

    $data = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PEMROGRAMAN WEB 3</title>
</head>

<body>

  <h2>BELAJAR PEMROGRAMAN WEB 3</h2>
  <br />
  <a href="tambah.php">Tambah Mahasiswa</a>

  <br />
  <br />

  <table border='1'>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Nim</th>
      <th>Alamat</th>
      <th>Opsi</th>
    </tr>



    <?php while ($d = mysqli_fetch_array($data)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['nama'] ?></td>
        <td><?= $d['nim'] ?></td>
        <td><?= $d['alamat'] ?></td>
        <td>
          <a href="edit.php?id=<?= $d['id'] ?>">Edit</a>
          <a href="hapus.php?id=<?= $d['id'] ?>">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>

</html>
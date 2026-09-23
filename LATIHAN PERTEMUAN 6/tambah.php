<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PEMROGRAMAN WEB 3</title>
</head>

<body>

  <h2>Belajar Pemrograman Web 3</h2>
  <br />

  <a href="index.php">Kembali</a>
  <br />
  <br />

  <h3>Tambah Data Mahasiswa</h3>

  <form action="tambah_aksi.php" method="post">
    <table>
      <tr>
        <td>Nama</td>
        <td>
          <input type="text" name="nama" required>
        </td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>
          <input type="number" name="nim" required>
        </td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>
          <input type="text" name="alamat" required>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="SIMPAN" required>
        </td>
      </tr>
    </table>

  </form>


</body>

</html>
<?php

include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id='$id'");

while ($d = mysqli_fetch_array($data)) {
  // $nama = $d['nama'];
  // $nim = $d['nim'];
  // $alamat = $d['alamat'];


?>
  <form action="update.php" method="post">
    <table>
      <tr>
        <td>Nama</td>
        <td>
          <input type="hidden" name="id" value="<?= $d['id'] ?>">
          <input type=" text" name="nama" required value="<?= $d['nama'] ?>">
        </td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>
          <input type="number" name="nim" required value="<?= $d['nim'] ?>">
        </td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>
          <input type="text" name="alamat" required value="<?= $d['alamat'] ?>">
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="SIMPAN" required>
        </td>
      </tr>
  </form>

<?php
}
?>
<?php

include 'koneksi.php';

if (isset($_POST['submit'])) {

  $judul = $_POST['judul'];
  $gambar = $_FILES['gambar']['name'];
  $isi = $_POST['isi'];
  $penulis = $_POST['penulis'];
  $tanggal = $_POST['tanggal'];

  // Upload gambar
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($gambar);

  if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
    mysqli_query($koneksi, "INSERT INTO news (title, images_path, content, author, created) VALUES ('$judul', '$gambar','$isi', '$penulis', '$tanggal')");

    header('Location:index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Berita</title>

  <style>
    /* Reset & Base Typography */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background-color: #ffffff;
      color: #212529;
      line-height: 1.5;
    }

    /* Top Navigation Header */
    header {
      width: 100%;
      background-color: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      padding: 12px 0;
    }

    .navbar-container {
      max-width: 960px;
      margin: 0 auto;
      padding: 0 24px;
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .brand {
      font-size: 1.25rem;
      font-weight: 500;
      color: #333333;
      text-decoration: none;
    }

    .nav-links {
      display: flex;
      gap: 18px;
    }

    .nav-links a {
      font-size: 0.95rem;
      color: #6c757d;
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .nav-links a:hover {
      color: #343a40;
    }

    /* Main Container & Layout */
    main {
      max-width: 960px;
      margin: 0 auto;
      padding: 28px 24px 60px 24px;
    }

    h1.page-title {
      font-size: 2rem;
      font-weight: 500;
      color: #212529;
      margin-bottom: 20px;
      letter-spacing: -0.5px;
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 18px;
    }

    .form-label {
      display: block;
      margin-bottom: 6px;
      font-size: 0.95rem;
      color: #212529;
      font-weight: 400;
    }

    .form-control {
      display: block;
      width: 100%;
      padding: 6px 12px;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      border: 1px solid #ced4da;
      border-radius: 4px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      outline: none;
      font-family: inherit;
    }

    .form-control:focus {
      border-color: #86b7fe;
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Textarea specifics */
    textarea.form-control {
      min-height: 170px;
      resize: vertical;
    }

    /* File Input Styling */
    input[type="file"].file-input {
      display: block;
      font-size: 0.95rem;
      color: #333333;
      cursor: pointer;
      border: none;
      padding: 0;
      background: none;
    }

    input[type="file"].file-input::-webkit-file-upload-button {
      padding: 3px 8px;
      margin-right: 8px;
      background-color: #efefef;
      border: 1px solid #767676;
      border-radius: 3px;
      font-size: 0.85rem;
      cursor: pointer;
      font-family: inherit;
    }

    input[type="file"].file-input::-webkit-file-upload-button:hover {
      background-color: #e5e5e5;
    }

    /* Submit Button */
    .btn-submit {
      display: inline-block;
      font-weight: 400;
      line-height: 1.5;
      color: #ffffff;
      text-align: center;
      vertical-align: middle;
      cursor: pointer;
      user-select: none;
      background-color: #0d6efd;
      border: 1px solid #0d6efd;
      padding: 6px 16px;
      font-size: 0.95rem;
      border-radius: 4px;
      transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
      margin-top: 4px;
    }

    .btn-submit:hover {
      background-color: #0b5ed7;
      border-color: #0a58ca;
    }

    .btn-submit:active {
      background-color: #0a58ca;
      border-color: #0a53be;
    }

    /* Notification banner */
    .notification {
      display: none;
      margin-top: 16px;
      padding: 10px 16px;
      border-radius: 4px;
      font-size: 0.9rem;
      background-color: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
    }
  </style>
</head>

<body>
  <header>
    <div class="navbar-container">
      <a href="#" class="brand">Portal Berita</a>
      <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="input-berita.php">Input Berita</a>
      </nav>
    </div>
  </header>

  <main>
    <h1 class="page-title">Input Berita</h1>

    <form action="" method="POST" enctype="multipart/form-data">
      <!-- 1. Judul Berita -->
      <div class="form-group">
        <label for="judul" class="form-label">Judul Berita:</label>
        <input type="text" id="judul" name="judul" class="form-control" required>
      </div>

      <!-- 2. Gambar -->
      <div class="form-group">
        <label for="gambar" class="form-label">Gambar:</label>
        <input type="file" id="gambar" name="gambar" accept="image/*" class="file-input">
      </div>

      <!-- 3. Isi Berita -->
      <div class="form-group">
        <label for="isi" class="form-label">Isi Berita:</label>
        <textarea id="isi" name="isi" class="form-control" required></textarea>
      </div>

      <!-- 4. Penulis -->
      <div class="form-group">
        <label for="penulis" class="form-label">Penulis:</label>
        <input type="text" id="penulis" name="penulis" class="form-control" required>
      </div>

      <!-- 5. Tanggal -->
      <div class="form-group">
        <label for="tanggal" class="form-label">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
      </div>

      <!-- 6. Tombol Submit -->
      <div class="form-group">
        <button type="submit" name="submit" class="btn-submit">Submit</button>
      </div>

      <!-- Notifikasi hasil kirim -->
      <div id="statusAlert" class="notification">
        Berita berhasil disimpan!
      </div>
    </form>
  </main>
</body>

</html>
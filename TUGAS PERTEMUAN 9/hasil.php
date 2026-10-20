<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$nama = $_SESSION['user_name'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Hasil | Tugas Pertemuan 9</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="result-page">
  <main class="result-card">
    <span class="app-label">Tugas Pertemuan 9</span>
    <span class="success-icon">&#10003;</span>
    <h1>Login berhasil</h1>
    <p>Selamat datang,</p>
    <span class="result-name"><?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></span>

    <div class="result-info">
      Anda sedang berada di halaman hasil. Halaman ini hanya dapat dibuka
      selama session login masih aktif.
    </div>

    <div class="result-actions">
      <a href="logout.php" class="btn-primary">Logout</a>
    </div>
  </main>
</body>

</html>

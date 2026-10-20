<?php
session_start();
include 'database.php';

if (isset($_SESSION['user_id'])) {
  header('Location: hasil.php');
  exit;
}

$name = '';
$username = '';
$email = '';
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($name === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
  } elseif (strlen($name) > 70) {
    $errors[] = 'Nama lengkap maksimal 70 karakter.';
  }

  if ($username === '') {
    $errors[] = 'Username wajib diisi.';
  } elseif (strlen($username) < 3 || strlen($username) > 50) {
    $errors[] = 'Username harus terdiri dari 3 sampai 50 karakter.';
  } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = 'Username hanya boleh berisi huruf, angka, dan garis bawah.';
  }

  if ($email === '') {
    $errors[] = 'Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
  } elseif (strlen($email) > 50) {
    $errors[] = 'Email maksimal 50 karakter.';
  }

  if ($password === '') {
    $errors[] = 'Password wajib diisi.';
  } elseif (strlen($password) < 8) {
    $errors[] = 'Password minimal 8 karakter.';
  }

  $captcha = trim($_POST['captcha'] ?? '');
  $captcha_session = isset($_SESSION['code']) ? $_SESSION['code'] : '';
  // $captcha = strtoupper(trim($_POST['captcha'] ?? ''));
  // $captcha_session = isset($_SESSION['code']) ? strtoupper($_SESSION['code']) : '';

  unset($_SESSION['code']);

  if ($captcha === '') {
    $errors[] = 'Kode CAPTCHA wajib diisi.';
  } elseif ($captcha_session === '' || $captcha !== $captcha_session) {
    $errors[] = 'Kode CAPTCHA tidak sesuai. Silakan coba lagi.';
  }

  if (empty($errors)) {
    $cek_username = mysqli_prepare($koneksi, 'SELECT id FROM users WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_param($cek_username, 's', $username);
    mysqli_stmt_execute($cek_username);
    mysqli_stmt_store_result($cek_username);

    if (mysqli_stmt_num_rows($cek_username) > 0) {
      $errors[] = 'Username sudah digunakan.';
    }

    mysqli_stmt_close($cek_username);

    $cek_email = mysqli_prepare($koneksi, 'SELECT id FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($cek_email, 's', $email);
    mysqli_stmt_execute($cek_email);
    mysqli_stmt_store_result($cek_email);

    if (mysqli_stmt_num_rows($cek_email) > 0) {
      $errors[] = 'Email sudah terdaftar.';
    }

    mysqli_stmt_close($cek_email);
  }

  if (empty($errors)) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $simpan = mysqli_prepare(
      $koneksi,
      'INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)'
    );
    mysqli_stmt_bind_param($simpan, 'ssss', $name, $username, $email, $password_hash);
    $berhasil = mysqli_stmt_execute($simpan);
    mysqli_stmt_close($simpan);

    if ($berhasil) {
      header('Location: login.php?registered=1');
      exit;
    }

    $errors[] = 'Registrasi gagal disimpan. Silakan coba lagi.';
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi | Tugas Pertemuan 9</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">
  <main class="auth-card lebar">
    <div class="auth-head">
      <span class="app-label">Tugas Pertemuan 9</span>
      <h1>Registrasi</h1>
      <p>Buat akun baru untuk dapat mengakses halaman hasil.</p>
    </div>

    <div class="auth-body">
      <?php if (!empty($errors)): ?>
        <div class="alert alert-error" role="alert">
          <strong>Periksa kembali data Anda.</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="register.php">
        <div class="field">
          <label for="name">Nama lengkap</label>
          <input
            type="text"
            id="name"
            name="name"
            value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="Nama lengkap Anda"
            maxlength="70"
            autocomplete="name"
            required>
        </div>

        <div class="field">
          <label for="username">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="contoh_user"
            minlength="3"
            maxlength="50"
            pattern="[A-Za-z0-9_]+"
            autocomplete="username"
            required>
          <span class="catatan">Hanya huruf, angka, dan garis bawah.</span>
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="nama@email.com"
            maxlength="50"
            autocomplete="email"
            required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Minimal 8 karakter"
            minlength="8"
            autocomplete="new-password"
            required>
          <span class="catatan">Password minimal 8 karakter.</span>
        </div>

        <div class="field">
          <label for="captcha">Kode CAPTCHA</label>
          <div class="captcha-row">
            <div class="captcha-box">
              <img
                id="captcha-image"
                src="captcha.php?t=<?php echo time(); ?>"
                alt="Gambar CAPTCHA berisi lima karakter"
                width="173"
                height="50">
            </div>
            <button type="button" class="btn-refresh" id="captcha-refresh">Ganti</button>
          </div>
          <input
            type="text"
            id="captcha"
            name="captcha"
            placeholder="Ketik 5 karakter"
            maxlength="5"
            autocomplete="off"
            spellcheck="false"
            required>
          <span class="catatan">Ketik lima karakter pada gambar. Huruf besar dan kecil dianggap sama.</span>
        </div>

        <button type="submit" class="btn-primary">Daftar</button>
      </form>

      <p class="switch">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>
  </main>

  <footer class="auth-footer">Pemrograman Web Lanjut &middot; PHP Native</footer>

  <script>
    const captchaImage = document.getElementById('captcha-image');
    const captchaRefresh = document.getElementById('captcha-refresh');

    captchaRefresh.addEventListener('click', function() {
      captchaImage.src = 'captcha.php?t=' + Date.now();
    });
  </script>
</body>

</html>
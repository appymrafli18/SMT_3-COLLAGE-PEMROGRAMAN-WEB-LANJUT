<?php
session_start();
include 'database.php';

if (isset($_SESSION['user_id'])) {
  header('Location: hasil.php');
  exit;
}

$email = '';
$errors = array();
$notice = '';

if (isset($_GET['registered'])) {
  $notice = 'Akun berhasil dibuat. Silakan masuk dengan email dan password Anda.';
} elseif (isset($_GET['logged_out'])) {
  $notice = 'Anda telah keluar dari akun.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $captcha = trim($_POST['captcha'] ?? '');
  $captcha_session = isset($_SESSION['code']) ? $_SESSION['code'] : '';
  // $captcha = strtoupper(trim($_POST['captcha'] ?? ''));
  // $captcha_session = isset($_SESSION['code']) ? strtoupper($_SESSION['code']) : '';

  unset($_SESSION['code']);

  if ($email === '') {
    $errors[] = 'Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
  } elseif (strlen($email) > 50) {
    $errors[] = 'Email maksimal 50 karakter.';
  }

  if ($password === '') {
    $errors[] = 'Password wajib diisi.';
  }

  if ($captcha === '') {
    $errors[] = 'Kode CAPTCHA wajib diisi.';
  } elseif ($captcha_session === '' || $captcha !== $captcha_session) {
    $errors[] = 'Kode CAPTCHA tidak sesuai. Silakan coba lagi.';
  }

  if (empty($errors)) {
    $cari = mysqli_prepare(
      $koneksi,
      'SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1'
    );
    mysqli_stmt_bind_param($cari, 's', $email);
    mysqli_stmt_execute($cari);
    mysqli_stmt_store_result($cari);

    if (mysqli_stmt_num_rows($cari) === 1) {
      mysqli_stmt_bind_result($cari, $user_id, $user_name, $user_email, $user_password);
      mysqli_stmt_fetch($cari);

      if (password_verify($password, $user_password)) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;

        mysqli_stmt_close($cari);
        header('Location: hasil.php');
        exit;
      }
    }

    mysqli_stmt_close($cari);
    $errors[] = 'Email atau password salah.';
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Tugas Pertemuan 9</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">
  <main class="auth-card">
    <div class="auth-head">
      <span class="app-label">Tugas Pertemuan 9</span>
      <h1>Login</h1>
      <p>Masuk menggunakan email, password, dan kode CAPTCHA.</p>
    </div>

    <div class="auth-body">
      <?php if ($notice !== ''): ?>
        <div class="alert alert-success" role="status">
          <?php echo htmlspecialchars($notice, ENT_QUOTES, 'UTF-8'); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error" role="alert">
          <strong>Login belum berhasil.</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="login.php">
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
            placeholder="Password Anda"
            autocomplete="current-password"
            required>
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

        <button type="submit" class="btn-primary">Masuk</button>
      </form>

      <p class="switch">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
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
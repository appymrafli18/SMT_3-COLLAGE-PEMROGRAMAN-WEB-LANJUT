<?php

include 'koneksi.php';

$descnew = mysqli_query($koneksi, "SELECT * FROM news ORDER BY created DESC LIMIT 1");
$first = mysqli_fetch_assoc($descnew);
$data = mysqli_query($koneksi, "SELECT * FROM news");
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Berita - Berita Terkini & Terpercaya</title>
  <style>
    /* CSS Reset & System Typography */
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
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      width: 100%;
      background-color: #ffffff;
      border-bottom: 1px solid #e9ecef;
    }

    .navbar-container {
      max-width: 1120px;
      margin: 0 auto;
      padding: 16px 24px;
      display: flex;
      align-items: center;
      gap: 32px;
    }

    .brand {
      font-size: 1.25rem;
      font-weight: 700;
      color: #212529;
      text-decoration: none;
      letter-spacing: -0.2px;
    }

    .nav-links {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .nav-link {
      font-size: 0.95rem;
      color: #6c757d;
      text-decoration: none;
      font-weight: 500;
      padding: 4px 0;
      border-bottom: 2px solid transparent;
      transition: color 0.15s ease, border-color 0.15s ease;
    }

    .nav-link:hover {
      color: #0d6efd;
    }

    .nav-link.active {
      color: #212529;
      font-weight: 600;
      border-bottom: 2px solid #0d6efd;
    }

    main {
      max-width: 1120px;
      width: 100%;
      margin: 0 auto;
      padding: 36px 24px 60px 24px;
      flex: 1;
    }

    .toolbar-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      margin-bottom: 32px;
      padding-bottom: 18px;
      border-bottom: 1px solid #f1f3f5;
    }

    .category-group {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .category-badge {
      display: inline-block;
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 500;
      color: #495057;
      background-color: #f1f3f5;
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid #dee2e6;
      transition: all 0.15s ease;
    }

    .category-badge:hover {
      background-color: #e9ecef;
      color: #212529;
    }

    .category-badge.active {
      background-color: #0d6efd;
      color: #ffffff;
      border-color: #0d6efd;
    }

    .page-indicator {
      font-size: 0.85rem;
      color: #6c757d;
    }

    .headline-section-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: #212529;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .featured-card {
      display: flex;
      flex-direction: column;
      background-color: #ffffff;
      border: 1px solid #e9ecef;
      border-radius: 6px;
      overflow: hidden;
      margin-bottom: 48px;
      text-decoration: none;
      color: inherit;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
      transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .featured-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
      border-color: #ced4da;
    }

    @media (min-width: 840px) {
      .featured-card {
        flex-direction: row;
      }
    }

    .featured-img-container {
      flex: 1.2;
      background-color: #f8f9fa;
      min-height: 260px;
      overflow: hidden;
    }

    .featured-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .featured-details {
      flex: 1;
      padding: 32px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .featured-title {
      font-size: 1.6rem;
      font-weight: 700;
      line-height: 1.3;
      color: #212529;
      margin-bottom: 12px;
    }

    .meta-text {
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .meta-text span strong {
      color: #495057;
    }

    .featured-excerpt {
      font-size: 0.95rem;
      color: #495057;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .btn-action-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.9rem;
      font-weight: 600;
      color: #0d6efd;
      text-decoration: none;
      align-self: flex-start;
    }

    .btn-action-link:hover {
      text-decoration: underline;
    }

    .news-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 28px;
      margin-bottom: 48px;
    }

    @media (min-width: 640px) {
      .news-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 960px) {
      .news-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    .news-card {
      display: flex;
      flex-direction: column;
      background: #ffffff;
      border: 1px solid #e9ecef;
      border-radius: 6px;
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .news-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .news-card-img-wrap {
      width: 100%;
      height: 180px;
      background-color: #f1f3f5;
      overflow: hidden;
    }

    .news-card-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s ease;
    }

    .news-card:hover .news-card-img-wrap img {
      transform: scale(1.02);
    }

    .news-card-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .news-card-title {
      font-size: 1.15rem;
      font-weight: 600;
      line-height: 1.4;
      color: #212529;
      margin-top: 6px;
      margin-bottom: 10px;
    }

    .news-card-excerpt {
      font-size: 0.88rem;
      color: #6c757d;
      line-height: 1.55;
      margin-bottom: 18px;
      flex: 1;
    }

    .pagination-bar {
      display: flex;
      justify-content: center;
      gap: 6px;
      margin-top: 20px;
    }

    .page-button {
      display: inline-block;
      min-width: 36px;
      height: 36px;
      line-height: 36px;
      text-align: center;
      border-radius: 4px;
      border: 1px solid #dee2e6;
      color: #495057;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      background-color: #ffffff;
      transition: all 0.15s ease;
    }

    .page-button:hover {
      background-color: #e9ecef;
      color: #212529;
    }

    .page-button.active {
      background-color: #0d6efd;
      color: #ffffff;
      border-color: #0d6efd;
    }

    footer {
      background-color: #ffffff;
      border-top: 1px solid #e9ecef;
      padding: 24px;
      text-align: center;
      font-size: 0.85rem;
      color: #6c757d;
      margin-top: auto;
    }
  </style>
</head>

<body>

  <!-- Header Navigation -->
  <header>
    <div class="navbar-container">
      <a href="#" class="brand">Portal Berita</a>
      <nav class="nav-links">
        <a href="index.php" class="nav-link active">Home</a>
        <a href="input-berita.php" class="nav-link">Input Berita</a>
      </nav>
    </div>
  </header>

  <main>
    <!-- Featured News Article -->
    <section>
      <h2 class="headline-section-title">Berita Utama</h2>
      <article class="featured-card">
        <div class="featured-img-container">
          <img class="featured-img" src="./uploads/<?= $first['images_path'] ?>" alt="Pusat Riset AI IKN">
        </div>
        <div class="featured-details">
          <h1 class="featured-title"><?= $first['title'] ?></h1>
          <div class="meta-text">
            <span>Penulis: <strong><?= $first['author'] ?></strong></span>
            <span>•</span>
            <span>Tanggal: <strong><?= $first['created'] ?></strong></span>
          </div>
          <p class="featured-excerpt"><?= $first['content'] ?></p>
          <a href="#" class="btn-action-link">Baca Selengkapnya &rarr;</a>
        </div>
      </article>
    </section>

    <section>
      <h2 class="headline-section-title">Daftar Berita Terkini</h2>
      <div class="news-grid">

        <?php while ($row = mysqli_fetch_array($data)): ?>
          <article class="news-card">
            <div class="news-card-img-wrap">
              <img src="./uploads/<?= $row['images_path'] ?>" alt="Finansial Digital UMKM">
            </div>
            <div class="news-card-body">
              <h3 class="news-card-title"><?= $row['title'] ?></h3>
              <div class="meta-text">
                <span><strong><?= $row['author'] ?></strong></span>
                <span>•</span>
                <span><?= $row['created'] ?></span>
              </div>
              <p class="news-card-excerpt">
                Pemanfaatan sistem transaksi non-tunai dan inklusi pembiayaan digital terbukti mempercepat laju pertumbuhan omzet usaha mikro dan kecil di berbagai daerah.
              </p>
              <a href="#" class="btn-action-link">Baca Selengkapnya &rarr;</a>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; 2026 Portal Berita. Seluruh Hak Cipta Dilindungi.</p>
  </footer>

</body>

</html>
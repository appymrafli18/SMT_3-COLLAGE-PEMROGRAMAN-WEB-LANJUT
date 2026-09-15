# Modul Praktikum PHP & MySQL (Materi Pertemuan 5)

Dokumentasi ini berisi panduan lengkap penggunaan skrip PHP prosedural menggunakan ekstensi `mysqli` untuk menghubungkan aplikasi ke basis data MySQL/MariaDB, mengelola skema tabel, melakukan manipulasi data, serta menampilkan data dalam bentuk tabel HTML.

---

## Daftar Isi

1. [Prasyarat Sistem](#prasyarat-sistem)
2. [Konfigurasi Basis Data](#konfigurasi-basis-data)
3. [Struktur File](#struktur-file)
4. [Penjelasan Modul Latihan](#penjelasan-modul-latihan)
5. [Perbedaan `mysqli_fetch_array` vs `mysqli_fetch_assoc`](#perbedaan-mysqli_fetch_array-vs-mysqli_fetch_assoc)
6. [Urutan Menjalankan Skrip](#urutan-menjalankan-skrip)
7. [Panduan Pemecahan Masalah (Troubleshooting)](#panduan-pemecahan-masalah-troubleshooting)

---

## Prasyarat Sistem

* **Web Server & Database:** Laragon, XAMPP, atau WampServer
* **PHP Engine:** Versi 7.4 atau lebih baru (dengan ekstensi `mysqli` aktif)
* **Database Engine:** MySQL 5.7+ atau MariaDB 10.3+
* **Web Browser:** Google Chrome, Mozilla Firefox, atau browser modern lainnya

---

## Konfigurasi Basis Data

Pastikan basis data telah dibuat di server MySQL sebelum mengeksekusi skrip lain.

```sql
CREATE DATABASE IF NOT EXISTS `latihan`;
```

Parameter koneksi default yang digunakan pada file latihan:
* **Host:** `localhost`
* **Username:** `root`
* **Password:** `root` *(Catatan: Pada instalasi default Laragon/XAMPP, password biasanya kosong `""`)*
* **Database Name:** `latihan`

---

## Struktur File

```text
MATERI PERTEMUAN 5/
├── latihan-fungsi-mysqli-connect.php    # Modul konfigurasi dan inisialisasi koneksi MySQL
├── latihan-fungsi-mysqli-query.php      # Modul pembuatan tabel `sales` & pengisian sampel data
├── latihan-mysqli-fetch-array.php      # Menampilkan data menggunakan mysqli_fetch_array()
├── latihan-mysqli-fetch-assoc.php      # Menampilkan data menggunakan mysqli_fetch_assoc()
└── README.md                           # Dokumentasi teknis materi latihan
```

---

## Penjelasan Modul Latihan

### 1. Koneksi Database (`latihan-fungsi-mysqli-connect.php`)
File ini bertugas menginisialisasi variabel `$conn` menggunakan fungsi `mysqli_connect()`. Skrip ini dilengkapi pengecekan kondisi untuk menghentikan program (`die()`) jika sambungan gagal dibentuk.

### 2. DDL & DML (`latihan-fungsi-mysqli-query.php`)
* **DDL (Data Definition Language):** Mengeksekusi query `CREATE TABLE IF NOT EXISTS sales` dengan kolom:
  * `id_transaksi` (INT, Primary Key, Auto Increment)
  * `id_produk` (INT)
  * `tgl_transaksi` (DATE)
  * `kuantitas` (TINYINT)
  * `harga` (INT)
  * `id_pelanggan` (INT)
* **DML (Data Manipulation Language):** Melakukan `INSERT INTO sales` untuk menambahkan 5 baris data transaksi simulasi penjualan.

### 3. Ekstraksi Data (`latihan-mysqli-fetch-array.php` & `latihan-mysqli-fetch-assoc.php`)
Keduanya melakukan query pembacaan:
```sql
SELECT id_produk, tgl_transaksi, harga, kuantitas FROM sales;
```
Hasil query kemudian diiterasi menggunakan perulangan `while` untuk merender baris-baris tabel HTML secara dinamis, lalu ditutup dengan pembersihan memori `mysqli_free_result()` dan pemutusan koneksi `mysqli_close()`.

---

## Perbedaan `mysqli_fetch_array` vs `mysqli_fetch_assoc`

| Aspek | `mysqli_fetch_assoc()` | `mysqli_fetch_array()` |
| :--- | :--- | :--- |
| **Bentuk Return** | Array asosiatif (nama kolom sebagai *key*) | Array asosiatif **DAN / ATAU** numerik (*index*) |
| **Akses Data** | Hanya `$row['kolom']` | Bisa `$row['kolom']` maupun `$row[0]` |
| **Parameter Mode** | Tetap (implisit asosiatif) | Fleksibel: `MYSQLI_ASSOC`, `MYSQLI_NUM`, `MYSQLI_BOTH` (default) |
| **Penggunaan Memori** | Lebih hemat dan optimal | Cenderung memakan memori 2x lipat jika memakai default `MYSQLI_BOTH` |
| **Rekomendasi** | **Sangat dianjurkan** untuk keterbacaan kode | Digunakan jika butuh pembacaan berbasis urutan indeks kolom |

---

## Urutan Menjalankan Skrip

Agar program berjalan tanpa kendala ketergantungan relasi atau data kosong, jalankan file melalui URL browser sesuai urutan berikut:

1. **Uji Koneksi:**
   ```text
   http://localhost/MATERI%20PERTEMUAN%205/latihan-fungsi-mysqli-connect.php
   ```
   *Pastikan mencetak tulisan "Connection Sucessfully".*

2. **Generate Tabel & Data:**
   ```text
   http://localhost/MATERI%20PERTEMUAN%205/latihan-fungsi-mysqli-query.php
   ```
   *Membuat tabel `sales` dan menyisipkan baris data awal.*

3. **Tampilkan Data:**
   * Alternatif 1:
     ```text
     http://localhost/MATERI%20PERTEMUAN%205/latihan-mysqli-fetch-array.php
     ```
   * Alternatif 2:
     ```text
     http://localhost/MATERI%20PERTEMUAN%205/latihan-mysqli-fetch-assoc.php
     ```

---

## Panduan Pemecahan Masalah (Troubleshooting)

### 1. `Fatal error: Unknown database 'latihan'`
* **Penyebab:** Database bernama `latihan` belum ada di MySQL.
* **Solusi:**
  1. Buka HeidiSQL / phpMyAdmin di Laragon.
  2. Buat database baru dengan nama `latihan`.
  3. Muat ulang (*refresh*) halaman browser Anda.

### 2. `Undefined variable '$conn'`
* **Penyebab:** Variabel koneksi belum terdefinisi pada lingkup (*scope*) kerja file terkait.
* **Solusi:**
  * Pastikan file koneksi diimpor di baris paling awal:
    ```php
    require_once __DIR__ . '/latihan-fungsi-mysqli-connect.php';
    ```
  * Pastikan ejaan variabel konsisten (`$conn`).
  * Jika kode dijalankan di dalam blok fungsi kustom, deklarasikan `global $conn;` terlebih dahulu.

### 3. `Access denied for user 'root'@'localhost'`
* **Penyebab:** Password database salah.
* **Solusi:** Buka `latihan-fungsi-mysqli-connect.php` dan sesuaikan nilainya:
  ```php
  // Untuk Laragon/XAMPP bawaan standar (tanpa password):
  $db_pass = '';

  // Jika Anda memasang konfigurasi password khusus:
  $db_pass = 'root';
  ```
# Aplikasi Manajemen Warnet (WarnetApp)

Selamat datang di WarnetApp, sebuah aplikasi web lengkap yang dibangun menggunakan Laravel 12 untuk mengelola semua aspek operasional sebuah warung internet (warnet). Aplikasi ini mencakup manajemen billing komputer, sistem kasir (Point of Sale) untuk penjualan makanan dan minuman, serta halaman pemesanan untuk pelanggan.

## Fitur Utama

Aplikasi ini dirancang dengan sistem multi-peran (multi-role) untuk memisahkan tanggung jawab dan akses.

### 1. Panel Admin
- **Dashboard Utama:** Menampilkan ringkasan pendapatan total, jumlah transaksi, status komputer, dan jumlah produk.
- **Manajemen Penuh:** Memiliki akses penuh ke semua fitur manajemen warnet dan kasir.
- **Kontrol Akses:** Hanya admin yang dapat menambah, mengedit, dan menghapus data master seperti Komputer dan Sesi.

### 2. Panel Penjaga Warnet
- **Dashboard Operasional:** Fokus pada status komputer secara real-time (tersedia, terpakai, maintenance) dan statistik sesi harian.
- **Manajemen Sesi:** Dapat memulai sesi billing baru untuk pelanggan.
- **Akses Terbatas:** Tidak dapat mengedit atau menghapus data master untuk menjaga keamanan.

### 3. Panel Kasir
- **Point of Sale (POS):** Antarmuka kasir yang intuitif untuk menangani pesanan walk-in.
- **Manajemen Menu:** Menambah, mengedit, dan menghapus produk makanan, minuman, dan snack.
- **Konfirmasi Pesanan:** Melihat dan mengonfirmasi pesanan yang masuk dari pelanggan secara online.
- **Riwayat Transaksi:** Melihat semua riwayat transaksi penjualan yang telah selesai.

### 4. Halaman Pelanggan
- **Menu Online:** Halaman publik di mana pelanggan dapat melihat semua menu yang tersedia.
- **Pemesanan Mandiri:** Pelanggan dapat memesan langsung dari PC atau meja mereka tanpa perlu memanggil staf.
- **Keranjang Belanja Interaktif:** Antarmuka yang mudah digunakan untuk menambah, mengurangi, dan mengelola item pesanan.

## Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Frontend:** Blade, Tailwind CSS, Vite.js
- **Database:** MySQL (dapat disesuaikan)
- **Bahasa:** PHP 8.2+

## Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal.

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd [NAMA_FOLDER_PROYEK]
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Buat File Environment**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate Kunci Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal (termasuk akun default).
    ```bash
    php artisan migrate --seed
    ```

7.  **Install Dependensi JavaScript**
    ```bash
    npm install
    ```

8.  **Jalankan Server**
    Buka dua terminal terpisah:
    - Di terminal pertama, jalankan Vite untuk kompilasi aset:
      ```bash
      npm run dev
      ```
    - Di terminal kedua, jalankan server Laravel:
      ```bash
      php artisan serve
      ```

9.  **Akses Aplikasi**
    - Halaman pemesanan pelanggan dapat diakses di: `http://127.0.0.1:8000/`
    - Halaman login staf dapat diakses di: `http://127.0.0.1:8000/login`

## Akun Default

Setelah menjalankan *seeder*, Anda dapat login menggunakan akun di bawah ini. Password untuk semua akun adalah `password`.

| Peran             | Email                 |
| ----------------- | --------------------- |
| Admin             | `admin@warnet.com`    |
| Penjaga Warnet    | `warnet@warnet.com`   |
| Kasir             | `kasir@warnet.com`    |

## Lisensi

Proyek ini berada di bawah Lisensi MIT.

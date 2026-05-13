# Sistem Informasi Peminjaman Inventaris Kampus

Sistem Manajemen Peminjaman Inventaris adalah aplikasi berbasis web yang dibangun dengan framework Laravel. Aplikasi ini dirancang untuk mengelola dan memfasilitasi peminjaman aset dan barang inventaris kampus untuk mahasiswa dan staf.

## Fitur Utama

- **Manajemen Aset & Inventaris**: Pendataan aset lengkap dengan kategori, stok, SKU, kondisi barang, dan gambar.
- **Kategorisasi Berbasis Program Studi**: Aset dipetakan sesuai Program Studi (Prodi) untuk mencegah konflik peminjaman, dilengkapi dengan opsi "Aset Umum Kampus" yang dapat dipinjam oleh semua mahasiswa.
- **Panel Admin Terpadu**: Antarmuka administratif yang memudahkan pengelolaan data barang, persetujuan peminjaman, dan rekapitulasi data.
- **Sistem Peminjaman Mahasiswa**: Mahasiswa hanya dapat melihat dan meminjam aset yang sesuai dengan prodi mereka atau aset umum kampus.

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM

## Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

1. **Clone repository ini**
   ```bash
   git clone https://github.com/iseiseje/peminjaman.git
   cd peminjaman
   ```

2. **Install dependensi PHP dan Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Siapkan file konfigurasi environment**
   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi Database**
   Buka file `.env` dan sesuaikan konfigurasi database dengan pengaturan server lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Link Folder Storage**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate --seed
   ```

8. **Kompilasi Aset Frontend**
   ```bash
   npm run build
   ```
   *(Atau jalankan `npm run dev` untuk hot-reloading)*

9. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada alamat `http://localhost:8000`.

## Lisensi

Proyek ini bersifat open-source.

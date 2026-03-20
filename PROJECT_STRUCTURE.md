# Struktur Direktori tiket-master

Berikut adalah penjelasan mengenai struktur folder dan file utama dalam proyek `tiket-master` yang berbasis **CodeIgniter 3**.

## Folder Utama

### 1. `application/`
Ini adalah folder terpenting tempat seluruh logika aplikasi berada. Struktur di dalamnya mengikuti pola MVC (Model-View-Controller).
- **`config/`**: Berisi file konfigurasi aplikasi seperti database, route, autoload, dan konstanta.
- **`controllers/`**: Berisi logic controller yang menghubungkan model dan view. Di sinilah alur request ditangani.
- **`models/`**: Berisi class untuk berinteraksi dengan database (query SQL).
- **`views/`**: Berisi file antarmuka pengguna (HTML/PHP) yang akan ditampilkan ke browser.
- **`helpers/`**: Berisi fungsi-fungsi bantuan (helper) yang bisa dipanggil di mana saja (misal: format tanggal, rupiah).
- **`libraries/`**: Berisi class tambahan atau library custom untuk memperluas fungsionalitas CodeIgniter (misal: PDF generator, API wrapper).
- **`language/`**: Menyimpan file bahasa untuk fitur multi-bahasa.
- **`core/`**: Tempat untuk memperluas (extend) core class CodeIgniter jika diperlukan (misal: `MY_Controller`).
- **`logs/`**: File log error aplikasi tersimpan di sini jika logging diaktifkan.
- **`cache/`**: Menyimpan file cache untuk mempercepat aplikasi.

### 2. `system/`
Folder ini berisi inti (**core**) dari framework CodeIgniter. **Jangan mengubah isi folder ini** agar tidak terjadi masalah saat update framework di masa depan. Folder ini memuat library bawaan, helper bawaan, dan file utama framework.

### 3. `assets/`
Folder ini digunakan untuk menyimpan file statis (client-side assets).
- **`css/`**: File Cascading Style Sheets (CSS) untuk styling halaman.
- **`js/`**: File JavaScript (termasuk jQuery atau script custom).
- **`img/` / `images/`**: Menyimpan gambar-gambar statis yang digunakan dalam desain web (logo, icon, background).
- **`vendor/`**: (Di dalam assets) Biasanya berisi library frontend pihak ketiga seperti Bootstrap, FontAwesome, atau plugin jQuery.

### 4. `uploads/`
Folder ini biasanya digunakan untuk menyimpan file yang diunggah oleh pengguna aplikasi, seperti foto profil, lampiran tiket, atau dokumen lainnya. Pastikan folder ini memiliki permission yang sesuai agar aplikasi bisa menulis file ke dalamnya.

### 5. `vendor/` (di root)
Folder ini dibuat otomatis oleh **Composer**. Berisi library PHP pihak ketiga (dependencies) yang dibutuhkan oleh aplikasi (misal: PHPMailer, library export Excel, dll). File ini diatur melalui `composer.json`.

## File Utama di Root

- **`index.php`**: Pintu gerbang utama (entry point) aplikasi. Semua request melewati file ini. File ini juga mengatur environment (development/production) dan path sistem.
- **`composer.json`**: File deklarasi dependensi PHP yang digunakan dalam proyek ini.
- **`.htaccess`**: File konfigurasi Apache web server, biasanya digunakan untuk menghilangkan `index.php` dari URL (URL Rewriting) agar lebih bersih.
- **`readme.md` / `README.md`**: Dokumentasi dasar mengenai proyek ini (biasanya dari repo asli).
- **`*.sql` files** (misal: `tiket_demo.sql`, `migrate_master_data.sql`): File backup atau script migrasi database yang perlu diimpor ke MySQL/MariaDB agar aplikasi bisa berjalan.

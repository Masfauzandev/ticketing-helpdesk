# 🚀 Rencana Upgrade Sistem Ticketing: Legacy ke Modern Stack

Dokumen ini disusun oleh Senior Full Stack Developer sebagai panduan strategis untuk melakukan peremajaan total (upgrade) pada aplikasi Ticketing System yang saat ini berjalan di atas CodeIgniter 3.

## 🎯 Tujuan Upgrade
1.  **Keamanan:** Menggunakan PHP versi terbaru (8.2+) yang memiliki *security patch* aktif.
2.  **Performa:** Memanfaatkan fitur *caching*, *queue*, dan optimasi query dari framework modern.
3.  **Maintainability:** Kode lebih rapi, terstruktur, mudah dibaca, dan mudah dikembangkan oleh tim baru.
4.  **Skalabilitas:** Siap menangani jumlah data dan user yang lebih besar di masa depan.

---

## 🛠️ Technology Stack Baru (Rekomendasi)

Kami merekomendasikan transisi ke ekosistem **Laravel** karena komunitasnya yang besar, fitur lengkap, dan kemudahan penggunaan.

| Komponen | Saat Ini (Legacy) | Baru (Modern Upgrade) | Alasan |
| :--- | :--- | :--- | :--- |
| **Bahasa** | PHP 7.4 (EOL) | **PHP 8.2+** | Fitur typing kuat, lebih cepat, aman. |
| **Framework** | CodeIgniter 3 | **Laravel 10 / 11** | Standar industri saat ini, fitur ORM canggih. |
| **Database** | MySQL (Raw SQL) | **MySQL 8 (Eloquent ORM)** | Menggunakan Migrations & Seeders untuk manajemen DB versi. |
| **Frontend** | Bootstrap 4 + jQuery | **Bootstrap 5 + Alpine.js** | Modern UI, reaktivitas ringan tanpa kompleksitas React/Vue. |
| **Realtime** | AJAX Polling (Lambat) | **Laravel Reverb / Pusher** | Notifikasi instan via WebSocket (tanpa refresh). |
| **Package** | Manual Download | **Composer** | Manajemen library otomatis & standar. |

---

## 🗺️ Roadmap Migrasi (Langkah Demi Langkah)

Proses ini tidak bisa dilakukan instan ("klik update"), melainkan harus dibangun ulang (*Rewrite*) dengan strategi migrasi data.

### Fase 1: Persiapan Infrastruktur (Setup)
1.  **Instalasi Laravel 11:** Membangun *scaffolding* proyek baru.
2.  **Setup Docker/Localhost:** Menggunakan PHP 8.2 dan MySQL 8.
3.  **Git Repository:** Inisialisasi version control modern.

### Fase 2: Migrasi Database (Database First)
Alih-alih menyalin file `.sql`, kita akan membuat **Laravel Migrations**.
1.  Buat file migration untuk tabel `users`, `tickets`, `categories`, dll.
2.  Buat **Seeders** untuk memindahkan data referensi (Master Category, Severity).
3.  Buat script **Data Import** untuk memindahkan *existing data* (Tiket lama & User lama) ke struktur tabel baru.

### Fase 3: Backend Rewrite (Core Logic)
Ini adalah tahap terberat, menulis ulang logika bisnis.
1.  **Authentication:** Implementasi **Laravel Breeze** (Login, Register, Reset Password aman).
2.  **Models & Relationships:** Definisikan relasi antar tabel (contoh: `Ticket` *belongsTo* `User`, `Ticket` *hasMany* `Replies`).
3.  **Controller Logic:**
    *   Ubah logika `create` tiket menggunakan *Form Request Validation*.
    *   Ubah logika `update` tiket dengan *Eloquent*.
    *   Implementasi *Service Pattern* jika logika terlalu rumit.

### Fase 4: Frontend Modernization
1.  **Blade Templating:** Pecah file `header.php`, `footer.php`, `sidebar.php` menjadi **Blade Components** (`<x-app-layout>`, `<x-sidebar>`).
2.  **UI Refresh:** Upgrade class Bootstrap 4 ke Bootstrap 5 (`ml-auto` -> `ms-auto`, `float-right` -> `float-end`).
3.  **Interactivity:** Ganti baris kode jQuery yang rumit dengan **Alpine.js** untuk dropdown, modal, dan tab yang lebih ringan.

### Fase 5: Testing & Deployment
1.  **Unit Testing:** Tulis test otomatis untuk memastikan fitur Create Ticket, Login, dan Report berjalan benar.
2.  **UAT (User Acceptance Test):** Biarkan user mencoba sistem baru.
3.  **Cut-Over:** Matikan sistem lama, sinkronisasi data terakhir, nyalakan sistem baru.

---

## ⚠️ Tantangan Utama

1.  **Perbedaan Syntax:** Logika `$this->input->post('name')` di CI3 berubah menjadi `$request->input('name')` di Laravel.
2.  **Password Hashing:** CI3 mungkin menggunakan MD5/Bcrypt lama. Laravel menggunakan Bcrypt/Argon2. User mungkin perlu reset password saat login pertama kali di sistem baru.
3.  **Waktu & Biaya:** Rewrite membutuhkan waktu development sekitar 2-4 minggu (tergantung kompleksitas fitur tambahan).

## 💡 Rekomendasi Fitur Tambahan (Value Add)
Mumpung sedang membangun ulang, tambahkan fitur ini agar sistem terasa "Baru":
*   **SSO (Single Sign-On):** Login menggunakan Akun Google Perusahaan.
*   **Email Parsing:** Buat tiket otomatis dari email masuk.
*   **SLA Tracking:** Hitung otomatis waktu respon agent vs deadline.
*   **Dark Mode:** Dukungan native untuk tema gelap.

---

**Kesimpulan:**
Upgrade ini adalah investasi jangka panjang. Jika Anda setuju, kita bisa mulai dari **Fase 1** sekarang.

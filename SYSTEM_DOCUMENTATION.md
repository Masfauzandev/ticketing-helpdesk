# 📘 Dokumentasi Sistem Ticketing

Dokumen ini menyediakan gambaran teknis lengkap mengenai aplikasi Sistem Ticketing.

## 🛠️ Teknologi yang Digunakan (Tech Stack)

### 1. Backend
*   **Bahasa:** PHP (Versi 7.4 disarankan)
*   **Framework:** **CodeIgniter 3.1.10**
    *   Arsitektur: MVC (Model-View-Controller)
    *   Ekstensi Inti: Menggunakan `MY_Controller` kustom untuk logika dasar.

### 2. Frontend
*   **Inti:** HTML5, CSS3, JavaScript
*   **Framework CSS:** **Bootstrap 4** (Desain Responsif)
*   **Library JS:** **jQuery**
*   **Templating:** Native PHP Views (Standar CodeIgniter)
*   **Library & Plugin Utama:**
    *   **DataTables:** Tabel canggih dengan fitur pengurutan, pencarian, dan pagination.
    *   **Select2:** Dropdown yang ditingkatkan dengan kemampuan pencarian.
    *   **Quill Editor:** Editor teks kaya (WYSIWYG) untuk deskripsi tiket.
    *   **Chart.js:** Visualisasi data untuk statistik di dashboard.
    *   **Toastr:** Notifikasi non-blocking (popup).
    *   **FontAwesome:** Kumpulan ikon.

### 3. Database
*   **Engine:** MySQL / MariaDB
*   **Driver:** `mysqli`
*   **ORM/Query Builder:** CodeIgniter Query Builder

### 4. API (Internal)
*   **Arsitektur:** REST-like internal API
*   **Komunikasi:** Berbasis AJAX (Asynchronous JavaScript and XML)
*   **Format:** Respon JSON

---

## 📂 Struktur Database Utama

Sistem bergantung pada tabel-tabel utama berikut:

| Nama Tabel | Deskripsi | Kolom Kunci |
| :--- | :--- | :--- |
| **`users`** | Data manajemen pengguna | `id`, `username`, `password`, `name`, `type`, `is_active` |
| **`tickets`** | Data tiket utama | `ticket_no`, `subject`, `status`, `category` (JSON), `owner`, `assign_to`, `created` |
| **`ticket_threads`** | Riwayat percakapan | `ticket_id`, `message`, `sender`, `timestamp` |
| **`attachments`** | File lampiran | `id`, `filename`, `path`, `related_id` |
| **`mst_category`** | Data master kategori | `id`, `category_name`, `is_active` |
| **`mst_severity`** | Data master tingkat keparahan | `id`, `severity_name`, `severity_val` |
| **`ci_sessions`** | Manajemen sesi | `id`, `ip_address`, `timestamp`, `data` |

---

## 👥 Peran Pengguna & Hak Akses

Kontrol akses dikelola melalui kolom `type` pada tabel `users`:

1.  **User (10):** Pengguna akhir standar. Bisa membuat tiket dan melihat riwayat mereka sendiri.
2.  **Agent (60):** Staf pendukung (Support). Bisa menerima penugasan tiket, membalas, dan menyelesaikan masalah.
3.  **Manager (80):** Ketua tim. Bisa melihat kinerja tim dan mengatur penugasan tiket.
4.  **Admin (100):** Superuser. Akses penuh ke pengaturan sistem, manajemen pengguna, dan data master.

---

## 🔄 Alur Kerja Sistem

### 1. Autentikasi
*   Pengguna login melalui `/auth/login`.
*   Data sesi disimpan di database untuk persistensi.

### 2. Pembuatan Tiket
*   **Rute:** `/tickets/create_new`
*   **Fitur:** Pemilihan multi-kategori, tingkat keparahan, deskripsi teks kaya, lampiran file.
*   **Backend:** Menangani validasi data dan konversi array-ke-json sederhana untuk kategori.

### 3. Manajemen Tiket (Tampilan List)
*   **Rute:** `/tickets/my_tickets` (User) atau Dashboard.
*   **Teknologi:** DataTables dengan pemrosesan sisi-server (server-side processing) yang menangani ribuan data secara efisien.

### 4. Proses Penyelesaian
*   **Penugasan:** Manajer menugaskan tiket ke Agent.
*   **Pembaruan:** Agent memperbarui status (*Open → In Progress → On Hold → Closed*).
*   **Kolaborasi:** Komentar berbalas memungkinkan diskusi antara User dan Agent.

### 5. Notifikasi
*   Notifikasi dalam aplikasi melalui Toastr.
*   Notifikasi email (dikonfigurasi di backend).

---

## 🔌 Dokumentasi API

Semua permintaan API ditangani oleh controller di `application/controllers/API/`.

### Endpoint Tiket (`API/Ticket`)
| Metode | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `POST` | `/create` | Membuat data tiket baru. |
| `POST` | `/updateTicket` | Memperbarui detail tiket (status, balasan, penyelesaian). |
| `POST` | `/upload_attachment` | Menangani upload file secara aman. |
| `GET`  | `/getCategories` | Mengambil daftar kategori untuk dropdown (Format: `{id, text}`). |
| `GET`  | `/getStatus` | Mengambil status tiket yang tersedia. |
| `POST` | `/addThreadMessage` | Mengirim komentar baru ke thread tiket. |

### Endpoint User (`API/User`)
| Metode | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/check` | Memvalidasi apakah username/email tersedia. |
| `GET` | `/getAll` | Mengambil daftar pengguna (dapat difilter berdasarkan tipe). |

---

## 📍 Struktur Proyek

```
c:/xampp/htdocs/tiket-master/
├── application/
│   ├── config/          # Konfigurasi Aplikasi (DB, Routes, Constants)
│   ├── controllers/     # Penangan Permintaan (Request Handlers)
│   │   ├── API/         # Endpoint API JSON
│   │   └── ...          # Controller Halaman (Auth, Tickets)
│   ├── models/          # Logika Database (Ticket_model, User_model)
│   └── views/           # Template HTML
│       ├── global/      # Header, Footer, Sidebar
│       └── ticket/      # Tampilan khusus Tiket
├── assets/
│   ├── css/             # Stylesheets (Kustom & Vendor)
│   ├── js/              # Logika JavaScript (library.js, front.js)
│   └── vendor/          # Library pihak ketiga (Bootstrap, FontAwesome)
├── system/              # Core Framework CodeIgniter
└── uploads/             # File yang diupload pengguna
```

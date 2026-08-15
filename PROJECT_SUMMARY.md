# 🌐 Project Summary: BatamPulse — SG ⇄ Batam Cross-Border Tourism Hub

> **Dokumen Review Tim & Technical Overview**  
> *Platform Pariwisata Kesehatan, Rekreasi, dan Layanan Lintas Batas Singapura — Batam*

---

## 📌 1. Latar Belakang & Value Proposition

**BatamPulse** adalah platform web modern yang dirancang khusus untuk menjembatani wisatawan dan pasien asal **Singapura** yang berkunjung ke **Batam, Indonesia** untuk keperluan wisata medis (*medical tourism*), perawatan gigi, *holistic spa*, *championship golf*, dan kuliner seafood.

### 💡 Masalah yang Diselesaikan
1. **Perbedaan Biaya Kesehatan yang Signifikan**: Perawatan medis dan estetik di Batam jauh lebih terjangkau (hemat **60% - 72%** dibanding Singapura) dengan kualitas standar internasional.
2. **Kemudahan Akses Transportasi**: Batam hanya berjarak 45–60 menit perjalanan feri dari Singapura (HarbourFront / Tanah Merah).
3. **Transparansi Mata Uang & Fasilitas**: Wisatawan membutuhkan konversi harga transparan (SGD / IDR) serta kejelasan penjemputan dari pelabuhan feri terdekat.

---

## 🏗️ 2. Arsitektur & Teknologi (Tech Stack)

Aplikasi dibangun menggunakan arsitektur decoupled (Separation of Concerns) antara Frontend UI dan Backend REST API.

| Komponen | Teknologi | Deskripsi / Peran |
| :--- | :--- | :--- |
| **Frontend Framework** | **Vue 3 (Composition API / `<script setup>`)** | Membangun UI yang responsif, terstruktur, dan performa tinggi. |
| **Build Tool & Bundler** | **Vite 5** | Hot Module Replacement (HMR) super cepat untuk pengembangan. |
| **Styling & Design** | **Tailwind CSS 3 + Vanilla CSS Glassmorphism** | Tema *Dark Mode* modern (Slate/Sky/Emerald), kartu efek *glassmorphism*, dan animasi halus. |
| **Peta & Spasial** | **Leaflet.js** | Visualisasi lokasi rumah sakit, resort, dan pelabuhan feri secara real-time. |
| **Icon Set** | **Lucide Vue Next** | Icon SVG clean dan konsisten di seluruh antarmuka. |
| **Backend Framework** | **Laravel 11** | Framework PHP modern untuk penyedia RESTful API. |
| **Database & GIS** | **PostgreSQL + PostGIS** | Penyimpanan data tempat beserta koordinat spasial (*latitude/longitude*) untuk kueri radius terdekat. |

---

## ⭐️ 3. Fitur Utama Aplikasi

### 🩺 1. Medical & Tourism Listings
- Katalog lengkap rumah sakit (contoh: RS Awal Bros), pusat perawatan gigi (Nagoya Dental), tempat *spa resort*, *championship golf course*, dan kuliner seafood.
- **Konverter Mata Uang Instan (SGD ⇄ IDR)** dengan estimasi persentase penghematan (*savings badge*) dibanding tarif Singapura.
- **Filter Berdasarkan Pelabuhan Feri Terdekat**: Batam Centre, Harbour Bay, Sekupang, dan Nongsa Pura.

### 🗺️ 2. Interactive Map Explorer (PostGIS Spatial Visualizer)
- Integrasi peta spasial untuk melihat sebaran lokasi medis & fasilitas wisata.
- Fitur interaktif *Click-to-Focus* dari daftar tempat langsung menyorot marker pada peta.

### 🤖 3. AI Itinerary Planner Modal
- Generator paket perjalanan cerdas (1-Day Checkup & Spa Express vs 2-Day Medical & Golf Experience).
- Rincian estimasi biaya total, jadwal feri berangkat/pulang, dan tombol pemesanan langsung (*Book All*).

### ⛴️ 4. Ferry Schedule & Terminal Guide
- Informasi rute kapal feri utama (Batam Fast, Majestic Ferry, Sindo Ferry).
- Detail durasi perjalanan, pelabuhan keberangkatan (HarbourFront/Tanah Merah), serta tips imigrasi.

### 📅 5. Modal Pemesanan & Penjemputan (*Booking System*)
- Formulir pemesanan layanan kesehatan dengan rincian tanggal, jam kunjungan, dan opsi **Layanan Penjemputan VIP** di pelabuhan feri.
- Kalkulasi total biaya transparan baik dalam SGD maupun IDR.

---

## 📑 4. Struktur Folder & Kode Utama

```
batam-crossborder-tourism/
├── frontend/                     # Application Frontend (Vue 3)
│   ├── index.html                # Entrypoint HTML & CDN imports (Leaflet, Google Fonts)
│   ├── package.json              # Dependensi NPM (Vue, Vite, Tailwind CSS, Lucide)
│   ├── tailwind.config.js        # Konfigurasi Tema Tailwind CSS
│   └── src/
│       ├── App.vue               # Main Root Component & Application State Manager
│       ├── main.js               # Vue Mounting Entrypoint
│       ├── style.css             # Utility CSS Classes & Glassmorphism Styles
│       └── components/           # Modular Vue Components
│           ├── Navbar.vue           # Header Nav & Currency Toggle
│           ├── HeroSection.vue      # Banner Utama & Filter Bar
│           ├── MedicalListings.vue  # Grid Kartu Tempat & Perhitungan Harga
│           ├── MapView.vue          # Peta Interaktif Leaflet.js
│           ├── AiItineraryModal.vue # Modal AI Travel Planner
│           ├── FerryGuideModal.vue  # Modal Panduan Feri SG-Batam
│           └── BookingModal.vue     # Modal Form Pemesanan
│
└── backend/                      # Application Backend API (Laravel 11)
    ├── composer.json             # Dependensi PHP (Laravel 11, Sanctum)
    ├── .env.example              # Template Environment Configuration
    └── routes/
        └── api.php               # REST API Endpoint Routes (/places, /bookings, /exchange-rate)
```

---

## 🔗 5. Kontrak REST API Endpoint (Backend)

| Method | Endpoint | Deskripsi | Status |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/places` | Mengambil daftar tempat wisata medis & rekreasi beserta lokasi spasial. | Ready |
| `GET` | `/api/places/{id}` | Mengambil detail lengkap suatu rumah sakit/tempat. | Ready |
| `POST` | `/api/bookings` | Mengirim data reservasi kunjungan & penjemputan feri. | Ready |
| `GET` | `/api/exchange-rate` | Mengambil nilai tukar mata uang live (SGD ke IDR). | Ready |

---

## ⚙️ 6. Panduan Menjalankan untuk Tim (How to Run)

### **Frontend**:
```bash
cd frontend
npm install
npm run dev
```
Akses di browser: `http://localhost:5173`

### **Backend (Laravel)**:
```bash
cd backend
composer install
copy .env.example .env
php artisan key:generate
php artisan serve
```
API Endpoint: `http://127.0.0.1:8000/api`

---

## 📋 7. Point Diskusi untuk Review Tim (Next Steps)

1. **Integrasi Payment Gateway**: Rencana penambahan Payment Gateway (Stripe / Midtrans) untuk *down payment* tiket/pemesanan.
2. **Kueri Distance PostGIS**: Optimasi kueri lokasi menggunakan rumus Haversine / PostGIS `ST_DistanceSphere` untuk mengurutkan tempat terdekat dari lokasi GPS pengguna.
3. **Multi-language Support (i18n)**: Penambahan opsi Bahasa Inggris (default) dan Bahasa Indonesia.

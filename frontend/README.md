# BatamPulse — Standalone Frontend (Vue 3 + Vite)

Dokumen ini berisi panduan lengkap untuk menjalankan **Frontend saja** dan mengintegrasikannya dengan **Backend terpisah** (beda repository atau beda server hosting).

---

## 🚀 1. Cara Menginstall & Menjalankan Frontend (Lokal)

1. **Masuk ke folder frontend**:
   ```bash
   cd frontend
   ```

2. **Install dependensi**:
   ```bash
   npm install
   ```

3. **Buat file `.env`**:
   Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Isi `.env` dengan URL Backend Anda**:
   ```env
   # Ganti dengan URL backend tempat API Anda berada:
   VITE_API_BASE_URL=http://127.0.0.1:8000
   ```

5. **Jalankan server development**:
   ```bash
   npm run dev
   ```
   Aplikasi akan berjalan di `http://localhost:5173`.

---

## 🔗 2. Cara Menggabungkan Koneksi dengan Backend Terpisah

Frontend ini berkomunikasi dengan backend via **REST API**. Pengaturan URL backend dilakukan sepenuhnya melalui variabel environment `VITE_API_BASE_URL`.

### A. Di Sisi Frontend (Vite)
Semua panggilan API (`fetch` / `axios`) di frontend menggunakan konfigurasi tersentralisasi dari `src/config/api.js`:

```javascript
import { getApiUrl } from './config/api.js'

// Otomatis menggabungkan Base URL + Endpoint
fetch(getApiUrl('/api/reviews'))
fetch(getApiUrl('/api/bookings'), { method: 'POST', body: JSON.stringify(data) })
```

### B. Di Sisi Backend Anda (Penting: Izin CORS ⚠️)
Agar browser tidak memblokir request dari frontend, pastikan backend Anda mengizinkan CORS dari domain frontend ini.

**Jika Backend menggunakan Laravel (`config/cors.php`)**:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => [
    'http://localhost:5173',
    'https://*.vercel.app', // Mengizinkan domain Vercel Frontend
],

'allowed_origins_patterns' => [
    '#^https://.*\.vercel\.app$#',
],
```

**Jika Backend menggunakan Node.js / Express**:
```javascript
const cors = require('cors');
app.use(cors({
  origin: ['http://localhost:5173', /\.vercel\.app$/],
  credentials: true
}));
```

---

## ☁️ 3. Cara Hosting Frontend Saja di Vercel

1. Push folder frontend ini ke GitHub.
2. Buka [Vercel Dashboard](https://vercel.com) $\rightarrow$ **Add New Project**.
3. Import Repository GitHub Anda.
4. Pada menu **Configure Project**:
   - **Root Directory**: Ubah ke **`frontend`** (bukan root `/`).
   - **Environment Variables**:
     - Key: `VITE_API_BASE_URL`
     - Value: `https://url-backend-production-anda.com`
5. Klik **Deploy**.

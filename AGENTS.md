# Panduan & Pedoman Wajib AI Agent (SIMRS Inhealthcare)

Dokumen ini adalah **mandatori SOP dan referensi utama** bagi setiap AI Agent sebelum memulai pengerjaan task, debugging, atau pengembangan fitur di repositori SIMRS `inhealtcare`.

---

## 1. Arsitektur & Spesifikasi Sistem

- **Framework**: Yii Framework 1.1.24 (`yii1_24/framework/yii.php`) dengan arsitektur MVC.
- **Runtime Backend**: PHP 7.4-FPM (didukung ekstensi `pdo_pgsql`, `pgsql`, `gd`, `zip`, `soap`, `bcmath`, `sockets`, `intl`).
- **Web Server**: Nginx Alpine Reverse Proxy.
- **Database**: PostgreSQL 14 (Multi-connection: Primary DB, RIS DB, Remote Server DB).
- **Frontend / Theme**: Bootstrap 3 + Theme Neon 18 (`themes/neon18/`, `themes/neon/`).
- **Container Environment**: Docker & Docker Compose (`http://localhost:9090` / `http://meninjar.dev.rssa.id:9090`).

---

## 2. Pre-Flight Checklist (Wajib Dijalankan Setiap Memulai Task)

Sebelum melakukan modifikasi kode atau mengeksekusi instruksi pengguna:

1. **Cek Status Container**:
   ```bash
   make health
   # atau
   docker compose ps
   ```
   Pastikan container `inhealtcare-php` dan `inhealtcare-nginx` dalam status `Up (healthy)`.

2. **Verifikasi Lingkungan `.env`**:
   Semua kredensial DB diambil melalui `getenv()` dengan fallback default aman di `protected/config/db.php`. Jangan menulis kredensial plaintext langsung di kode modul.

3. **Autentikasi & Akun Super Admin**:
   - **Username**: `sysadmin` (User ID: `1`, role: System Administrator).
   - **Mekanisme Hashing Password**:
     Menggunakan sistem HMAC-SHA256 khusus + `password_hash` bcrypt:
     ```php
     $seckey = sha1('ehealthsys240117');
     $hashHmac = hash_hmac('sha256', $passwordInput . '&' . $username, $seckey, true);
     $isValid = password_verify($hashHmac, base64_decode($user->katakunci_pemakai));
     ```
   - Model method: `LoginpemakaiK::model()->cekPassword3($password)`.

4. **Batasan & Constraint Database PostgreSQL**:
   - `profilrumahsakit_m.namapendek_rumahsakit`: Tipe data `VARCHAR(10)`. Nilai tidak boleh melebihi 10 karakter (contoh valid: `'STIKES-PW'`).
   - Primary Key sequences di PostgreSQL bertipe BIGINT/INTEGER.

---

## 3. Standar Keamanan & Coding Guidelines

### 3.1 Penulisan Kueri SQL (Anti SQL-Injection)
- **DILARANG** melakukan konkatenasi string input langsung ke SQL:
  ```php
  // SALAH / VULNERABLE:
  $sql = "SELECT * FROM pasien_m WHERE pasien_id = " . $_GET['id'];
  ```
- **WAJIB** menggunakan parameterized query melalui `CDbCommand`:
  ```php
  // BENAR:
  $sql = "SELECT * FROM pasien_m WHERE pasien_id = :id";
  $data = Yii::app()->db->createCommand($sql)->bindValue(':id', $id, PDO::PARAM_INT)->queryRow();
  ```
- Untuk kueri ActiveRecord / CDbCriteria:
  ```php
  $criteria = new CDbCriteria();
  $criteria->addCondition('pasien_id = :id');
  $criteria->params[':id'] = (int)$id;
  ```

### 3.2 Penanganan Null & Pengecekan Objek
- Selalu periksa `!empty($model)` sebelum mengakses relasi atau properti untuk mencegah error 500 saat mode development aktif (`YII_DEBUG=true`).
- Periksa keberadaan file fisik dengan `file_exists()` sebelum membuat URL gambar lokal untuk menghindari error `404 Not Found` pada console browser.

---

## 4. Standar Layout & UI (Neon Theme)

File layout utama: [`protected/views/layouts/mainNeonSidebar.php`](file:///home/meninjar/dataproject/inhealtcare/protected/views/layouts/mainNeonSidebar.php)

1. **Top Navbar Header**:
   - Menggunakan flexbox horizontal (`.navbar-inner.navsty`) dengan tinggi presisi **`60px`**.
   - Info Modul & Ruangan di kiri (`.modul-info-brand`) dengan lebar terukur (`max-width: 320px`), teks menggunakan *ellipsis*.
   - Menu Horizontal di tengah (`.navbar-nav.mainmenuatas`).
   - Menu Utilitas & Profil di kanan (`.nav.navbar-right.pull-right`) **wajib** memiliki `margin-left: auto !important;` agar selalu menempel di pojok kanan layar.

2. **Sidebar Shortcut Vertikal Kiri (`.favmenu` / `.sidebar-menu3`)**:
   - Lebar tetap: **`60px`** dengan posisi `position: fixed; top: 60px; bottom: 0;`.
   - Padding atas: `6px 0` agar icon pertama langsung sejajar di bawah header tanpa celah kosong berlebih.
   - **Dilarang** menambahkan border horizontal separator pada `<li>` agar tampilan tidak tampak bergaris kaku seperti tabel.
   - Icon button: Ukuran 40x40 px, rounded 10px, warna tema `#57a595`, hover `#ecfdf5`, active background `#57a595` putih.

3. **Konten Utama (`.page-container .main-content`)**:
   - `margin-left: 60px !important;`
   - `width: calc(100% - 60px) !important;`
   - Padding: `20px 30px` untuk tata letak yang luas dan responsif.

4. **Socket.io**:
   - Objek `window.socket = { emit: function(){}, on: function(){} }` didefinisikan secara global dalam mode aman agar halaman tidak crash saat server nodejs eksternal tidak aktif.

---

## 5. Prosedur Verifikasi Pasca-Edit (Wajib)

Setiap kali melakukan perubahan file:
1. **Linter Sintaks PHP**:
   ```bash
   php -l protected/path/to/ModifiedFile.php
   ```
2. **Uji HTTP Endpoint / Render**:
   ```bash
   curl -s -o /dev/null -w "%{http_code}\n" http://localhost:9090/index.php
   ```
3. **Commit Terstruktur**:
   Gunakan format commit konvensional:
   - `fix(ui): ...` untuk perbaikan tampilan/layout.
   - `fix(security): ...` untuk penambalan SQLi/keamanan.
   - `feat(...): ...` untuk penambahan fitur baru.
   - `docs(...): ...` untuk dokumentasi.

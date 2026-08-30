# DevLog — SIMRS Inhealthcare Development & Maintenance

Log kronologis implementasi, perbaikan bug, audit keamanan, dan peningkatan sistem pada repositori SIMRS `inhealtcare`.

---

## [2026-08-30] Milestone 1: Dockerisasi & Makefile Lingkungan Pengembangan
- **Tujuan**: Membangun lingkungan containerized PHP 7.4-FPM + Nginx Alpine yang terisolasi dan siap pakai.
- **Implementasi**:
  - Membuat `Dockerfile` (PHP 7.4-FPM + ekstensi `pdo_pgsql`, `pgsql`, `gd`, `zip`, `soap`, `bcmath`, `sockets`, `intl`).
  - Membuat `docker-compose.yml` dengan port mapping `9090:80`.
  - Menyiapkan `nginx.conf`, `php-fpm.conf`, dan `docker-entrypoint.sh` untuk auto-chown permission `assets/` dan `protected/runtime/`.
  - Menyusun `Makefile` dengan target: `build`, `up`, `down`, `restart`, `logs`, `shell`, `db-shell`, `health`, `lint`, `backup-db`, `restore-db`, `clean-assets`.
  - Mengonfigurasi `protected/config/db.php`, `db_ris.php`, dan `db_remoteserver.php` untuk membaca variabel environment dari `.env` dengan fallback default aman.
- **Hasil Verifikasi**:
  - `make up` dan `make health` lolos verifikasi HTTP 200/302 pada `localhost:9090`.

---

## [2026-08-30] Milestone 2: Audit & Penambalan Keamanan SQL Injection (Batch 1-5)
- **Tujuan**: Memperbaiki kerentanan SQL Injection pada modul-modul inti SIMRS.
- **Implementasi**:
  - **Batch 1 (Autocomplete)**: Memperbaiki 4 method di `protected/controllers/ActionAutoCompleteController.php` (daftar diagnosa, tindakan, obat, pegawai) menggunakan `CDbCommand::bindValue()`.
  - **Batch 2 (Ekios Module)**: Mengamankan kueri pencarian pasien di `protected/modules/ekios/controllers/DefaultController.php`.
  - **Batch 3 (Pengadaan Module)**: Mengamankan kueri di `SuratPerjanjianKerjaController.php`, `EvaluasiPenawaranController.php`, dll.
  - **Batch 4 (Radiologi & Laboratorium)**: Mengamankan filter tanggal dan parameter pasien ID.
  - **Batch 5 (Rawat Darurat & Rawat Jalan)**: Memperbaiki query criteria di controller admission dan registrasi.
- **Hasil Verifikasi**:
  - Seluruh file lolos linter sintaks `php -l`.

---

## [2026-08-30] Milestone 3: Autentikasi & Reset Password Super Admin
- **Tujuan**: Menemukan akun super admin dan mereset password sesuai permintaan pengguna.
- **Temuan**:
  - Akun super admin utama: `sysadmin` (User ID: `1`, Pegawai ID: `137136187311`).
  - Sistem enkripsi password SIMRS menggunakan HMAC-SHA256 khusus (`seckey = sha1('ehealthsys240117')`) + bcrypt (`PASSWORD_DEFAULT` cost 12).
- **Aksi**:
  - Password `sysadmin` berhasil di-reset menjadi `@Dmin1234`.
  - Login berhasil diverifikasi melalui `LoginpemakaiK::model()->cekPassword3()`.

---

## [2026-08-30] Milestone 4: Rebranding & Penggantian Logo Institusi
- **Tujuan**: Mengganti branding sistem menjadi **STIKes Panti Waluya Malang**.
- **Implementasi**:
  - Mengunduh dan mengganti seluruh asset logo sistem (`images/`, `themes/neon/assets/images/`, `favicon.ico`, kop surat, login logo) dengan logo resmi STIKes Panti Waluya Malang.
  - Memperbarui tabel `profilrumahsakit_m` di database PostgreSQL:
    - `nama_rumahsakit` = `'STIKes Panti Waluya Malang'`
    - `namapendek_rumahsakit` = `'STIKES-PW'` (memenuhi batas `VARCHAR(10)`)
    - `logo_rumahsakit` = `'logo_stikes_panti_waluya.png'`
  - Membersihkan background logo yang berulang di navbar atas dan footer, serta menampilkan icon logo tunggal di dalam kotak putih footer.

---

## [2026-08-30] Milestone 5: Modernisasi & Refactor UI Layout (Navbar & Sidebar)
- **Tujuan**: Memperbaiki tata letak navbar dan sidebar yang menumpuk, tidak responsif, dan bergaris-garis kaku.
- **Problem Diagnosed & Fixed**:
  1. **Navbar Brand / Info Modul**: Menghapus container kosong yang mematahkan float navbar; mengganti tabel sempit dengan layout flexbox modern dengan teks *ellipsis* (`max-width: 320px`).
  2. **Navbar Right**: Menambahkan `margin-left: auto !important;` pada flex child menu kanan sehingga search, notifikasi, jam digital, dan profil `sysadmin` selalu menempel di pojok kanan layar.
  3. **Sidebar Shortcut Vertikal Kiri (`.favmenu` / `.sidebar-menu3`)**:
     - Menghilangkan scrollbar vertikal hitam kaku (`scrollbar-width: none`).
     - Menghapus efek kusam `filter: grayscale(100%)`.
     - Menghapus semua garis separator horizontal (`border: none !important;`) pada `<li>` yang sebelumnya membuat sidebar tampak seperti tabel kaku.
     - Menerapkan flexbox vertikal dengan jarak seragam (`gap: 8px`).
     - Mengompakkan tinggi navbar ke **`60px`** dan menyetel `top: 60px; padding: 6px 0;` sehingga icon menu pertama tidak berjarak terlalu jauh dari header atas.
  4. **Fallback Gambar Profil 404**: Menambahkan pemeriksaan `file_exists()` di PHP dan menyediakan asset avatar default `images/avatar-default.png`.
  5. **Socket.io Polling Error**: Menyediakan objek `window.socket` dalam mode aman dan menonaktifkan polling sementara untuk mencegah error console.
- **Commit Terkait**:
  - `675d169` `fix(ui): perbaiki layout sidebar vertikal dan navbar-brand agar tidak menumpuk`
  - `214740c` `fix(layout): perbaiki undefined variable idUser dan kembalikan script closure di mainNeonSidebar`
  - `caae27c` `fix(ui): posisikan navbar-right di pojok kanan, hilangkan scrollbar hitam sidebar kiri, tambahkan default avatar`
  - `56cd787` `fix(ui): rapikan sidebar shortcut, hilangkan grayscale, amankan socket.io dan perbaiki avatar 404`
  - `da3da59` `fix(ui): rapikan spacing sidebar tanpa border separator, matikan polling socket.io`
  - `ba00ae1` `fix(ui): rapatkan jarak tombol menu pertama sidebar ke header atas`

## [2026-08-30] Milestone 6: Penggantian Background Login & UI Styling STIKes Panti Waluya
- **Tujuan**: Mengganti latar belakang login dan menyelaraskan tema kartu form login agar menyatu secara harmonis dengan ilustrasi watercolor gedung STIKes Panti Waluya Malang.
- **Implementasi**:
  - Menyimpan asset gambar ke `images/bg_login_stikes.jpg`.
  - Mengatur layout card box form login dengan efek *glassmorphism watercolor* (`background: rgba(255, 255, 255, 0.82); backdrop-filter: blur(14px) saturate(160%); border-radius: 20px; box-shadow: 0 20px 45px rgba(23, 62, 53, 0.22)`).
  - Memposisikan form login di sisi kanan tanpa menutupi gedung utama di tengah.
  - Memperbarui styling input field dengan border sage green (`#c9ded7`), focus glow `#3d8b7a`, dan eye toggle password terpadu.
  - Tombol masuk menggunakan gradient hijau STIKes (`#2d6a4f` ke `#1b4332`) dengan hover transition yang mewah.
- **Hasil Verifikasi**:
  - Seluruh file lolos linter `php -l`.
  - Halaman login merespon status `200 OK` di `http://localhost:9090/index.php?r=site/login`.

---

## Outstanding Tasks / Backlog
1. **SQL Injection Batch Lanjutan**: Melanjutkan penambalan ~270 kueri numeric context dan pattern `find()` pada modul farmasi, rawat inap, dan laboratorium.
2. **Issue `$pasienAdmisi`**: Menunggu konfirmasi alur bisnis apakah pasien rawat darurat yang masuk rawat inap menampilkan DPJP admisi atau dokter pemeriksa awal.
3. **RBAC MyAuthController**: Evaluasi restriksi akses setelah audit role pengguna.

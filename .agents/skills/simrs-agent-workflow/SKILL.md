---
name: simrs-agent-workflow
description: Workflow dan SOP standar pengerjaan task, debugging, audit keamanan, dan pengembangan fitur pada SIMRS Inhealthcare.
---

# SIMRS Inhealthcare Agent Workflow & Best Practices

Gunakan skill ini sebagai pedoman wajib dalam setiap pengerjaan task di SIMRS Inhealthcare.

## 1. Siklus Pengerjaan Task (Mandatory Workflow)

Setiap pengerjaan task WAJIB mengikuti 4 tahapan berikut:

```
[1. Pre-Flight Check] ──> [2. Analisis & Kode Aman] ──> [3. Verifikasi Runtime] ──> [4. Dokumentasi DevLog]
```

### Tahap 1: Pre-Flight Check
1. Cek kesehatan container Docker:
   ```bash
   make health
   ```
2. Pastikan file `.env` aktif dan variabel database terhubung ke PostgreSQL.
3. Kredensial super admin tersimpan di DB sebagai `sysadmin` (ID 1) dengan password `@Dmin1234`.

### Tahap 2: Aturan Penulisan Kode (Security & UI)
1. **Keamanan SQL (Anti-SQLi)**:
   - Wajib gunakan parameter binding `:param` via `CDbCommand::bindValue()`.
   - Dilarang keras menggabungkan variabel `$_GET`/`$_POST` langsung ke string SQL.
2. **Layout & UI**:
   - Layout utama ada di `protected/views/layouts/mainNeonSidebar.php`.
   - Header navbar: Flexbox tinggi 60px, `.nav.navbar-right.pull-right` wajib `margin-left: auto !important`.
   - Sidebar shortcut: Lebar 60px, posisi `top: 60px; padding: 6px 0;`, bebas border horizontal separator.
   - Konten `.main-content`: `margin-left: 60px !important; width: calc(100% - 60px) !important;`.
   - Foto profil pegawai: Wajib gunakan `file_exists()` sebelum merender URL untuk mencegah error 404 pada browser.

### Tahap 3: Verifikasi Pasca Perubahan
1. Uji sintaks PHP pada setiap file yang dimodifikasi:
   ```bash
   php -l protected/path/to/ModifiedFile.php
   ```
2. Uji HTTP status code:
   ```bash
   curl -s -o /dev/null -w "%{http_code}\n" http://localhost:9090/index.php
   ```

### Tahap 4: Update DevLog & Git Commit
1. Catat ringkasan pekerjaan ke `DEVLOG.md`.
2. Lakukan commit dengan pesan konvensional (`fix(ui): ...`, `fix(security): ...`, `feat(...): ...`).

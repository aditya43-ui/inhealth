# Aturan & Standar Proyek SIMRS Inhealthcare

Pedoman mandatori ini otomatis dimuat oleh AI Agent setiap sesi kerja:

1. **Pre-flight Check**: Pastikan `make health` berjalan normal di port 9090.
2. **Kredensial & Autentikasi**: Super admin `sysadmin` (ID 1). Hashing menggunakan HMAC-SHA256 khusus (`seckey = sha1('ehealthsys240117')`) + bcrypt.
3. **Database Constraints**: `profilrumahsakit_m.namapendek_rumahsakit` bertipe `VARCHAR(10)`. Nilai maksimal 10 karakter.
4. **Keamanan SQL**: Wajib gunakan `CDbCommand::bindValue()` atau parameterized queries. Hindari konkatenasi variabel langsung ke dalam SQL.
5. **UI & Theme Rules (`mainNeonSidebar.php`)**:
   - Header flexbox tinggi 60px.
   - `.nav.navbar-right.pull-right` wajib `margin-left: auto !important`.
   - Sidebar shortcut `.favmenu` fixed `width: 60px; top: 60px; padding: 6px 0;`.
   - `<li>` sidebar shortcut tidak boleh memiliki border separator horizontal.
   - Konten utama `.main-content` memiliki `margin-left: 60px !important; width: calc(100% - 60px) !important;`.
   - Fallback avatar pegawai di PHP menggunakan `file_exists()` ke `images/avatar-default.png`.
   - Objek `window.socket` safe no-op tanpa polling aktif.
6. **Verifikasi**: Jalankan `php -l <file>` setelah setiap pengeditan file PHP.

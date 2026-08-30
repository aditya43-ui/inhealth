# Inisialisasi Database PostgreSQL

Letakkan file backup database (`.sql` atau `.sql.gz`) di dalam folder ini (`docker/db-init/`).

Saat container PostgreSQL (`inhealtcare-db`) pertama kali dibuat dari keadaan kosong, file script SQL di direktori ini akan dieksekusi secara otomatis oleh PostgreSQL untuk membentuk skema dan data awal.

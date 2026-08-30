#!/bin/bash
set -e

# Script otomatis restore database inhealth saat container db pertama kali dibuat
DUMP_FILE="/docker-entrypoint-initdb.d/01_inhealth.dump.gz"

if [ -f "$DUMP_FILE" ]; then
    echo "========================================================="
    echo " [SIMRS INIT] Memulai proses restore $DUMP_FILE..."
    echo "========================================================="
    gunzip -c "$DUMP_FILE" | pg_restore -U "$POSTGRES_USER" -d "$POSTGRES_DB" --no-owner --role="$POSTGRES_USER" --clean --if-exists || true
    echo "========================================================="
    echo " [SIMRS INIT] Selesai! Database $POSTGRES_DB siap digunakan."
    echo "========================================================="
fi

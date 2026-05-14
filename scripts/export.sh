#!/usr/bin/env bash
# Export the database + uploads for backup / migration.
# Output: backups/wp-YYYYMMDD-HHMMSS.sql.gz and backups/uploads-YYYYMMDD-HHMMSS.tar.gz

set -euo pipefail

mkdir -p backups
STAMP=$(date +%Y%m%d-%H%M%S)

echo "==> Dumping database..."
docker compose run --rm wpcli db export - | gzip > "backups/wp-$STAMP.sql.gz"

echo "==> Archiving uploads..."
docker compose run --rm wpcli tar -czf - -C /var/www/html/wp-content uploads > "backups/uploads-$STAMP.tar.gz" || true

echo "Backups written to backups/"
ls -lh "backups/" | tail -n 5

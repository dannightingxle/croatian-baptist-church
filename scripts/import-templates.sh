#!/usr/bin/env bash
# Import Elementor templates from templates/*.json into the WP install.
# Run after pages exist.

set -euo pipefail

wp() { docker compose run --rm wpcli "$@"; }

if ! ls templates/*.json >/dev/null 2>&1; then
  echo "No Elementor template JSON files found in templates/. Skipping."
  exit 0
fi

for f in templates/*.json; do
  name=$(basename "$f")
  echo "==> Importing $name..."
  wp elementor library import "/templates/$name" || echo "  (skipped — Elementor CLI may need 'elementor library import' available)"
done

echo "Templates imported. Open Elementor > Templates > Saved Templates to apply them to pages."

#!/usr/bin/env bash
# Provision a fresh WordPress install for the church site.
# Usage: ./scripts/provision.sh
# Assumes docker compose stack is running.

set -euo pipefail

# Load env
if [ -f .env ]; then
  set -a; source .env; set +a
fi

: "${WP_SITE_URL:?must set WP_SITE_URL in .env}"
: "${WP_SITE_TITLE:?must set WP_SITE_TITLE in .env}"
: "${WP_ADMIN_USER:?must set WP_ADMIN_USER in .env}"
: "${WP_ADMIN_PASSWORD:?must set WP_ADMIN_PASSWORD in .env}"
: "${WP_ADMIN_EMAIL:?must set WP_ADMIN_EMAIL in .env}"

wp() {
  docker compose run --rm wpcli "$@"
}

echo "==> Waiting for WordPress files to be ready..."
until wp core is-installed 2>/dev/null || wp core version 2>/dev/null; do
  sleep 2
done

echo "==> Installing WordPress core (if not already installed)..."
if ! wp core is-installed 2>/dev/null; then
  wp core install \
    --url="$WP_SITE_URL" \
    --title="$WP_SITE_TITLE" \
    --admin_user="$WP_ADMIN_USER" \
    --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL" \
    --skip-email
else
  echo "    WP already installed, skipping core install."
fi

echo "==> Setting site options..."
wp option update blogdescription "Baptistička crkva — Baptist Church"
wp option update timezone_string "Europe/Zagreb"
wp option update date_format "j. F Y."
wp option update time_format "H:i"
wp option update start_of_week 1
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard

echo "==> Installing & activating plugins..."
wp plugin install elementor --activate
wp plugin install polylang --activate
wp plugin install contact-form-7 --activate
wp plugin install wordpress-seo --activate

echo "==> Installing Hello Elementor parent theme..."
wp theme install hello-elementor --activate

echo "==> Activating rm-church child theme..."
wp theme activate rm-church

echo "==> Activating rm-church customizations plugin..."
wp plugin activate rm-church-customizations

echo "==> Configuring Polylang languages (Croatian + English)..."
# Polylang CLI commands
wp pll language create "Hrvatski" hr hr_HR --order=0 --no_default_cat=1 || true
wp pll language create "English" en en_US --order=1 --no_default_cat=1 || true
wp pll option set default_lang hr

echo "==> Importing starter pages..."
bash ./scripts/import-pages.sh

echo "==> Importing Elementor templates..."
bash ./scripts/import-templates.sh

echo ""
echo "Provisioning complete."
echo "Admin: $WP_SITE_URL/wp-admin"
echo "User:  $WP_ADMIN_USER"
echo "Pass:  (from .env)"

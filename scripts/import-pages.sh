#!/usr/bin/env bash
# Create the starter set of pages in both Croatian and English,
# and link them as Polylang translations.

set -euo pipefail

wp() { docker compose run --rm wpcli "$@"; }

# Create a page in a given language, return its ID
create_page() {
  local title="$1"
  local slug="$2"
  local lang="$3"
  local id
  id=$(wp post create \
        --post_type=page \
        --post_status=publish \
        --post_title="$title" \
        --post_name="$slug" \
        --porcelain)
  wp pll post language "$id" "$lang"
  echo "$id"
}

link_translations() {
  # Usage: link_translations hr_id en_id
  wp pll post create-translations "$1" "$2"
}

echo "==> Creating Home..."
HR_HOME=$(create_page "Početna" "pocetna" "hr")
EN_HOME=$(create_page "Home" "home" "en")
link_translations "$HR_HOME" "$EN_HOME" || true

echo "==> Creating About / O nama..."
HR_ABOUT=$(create_page "O nama" "o-nama" "hr")
EN_ABOUT=$(create_page "About Us" "about" "en")
link_translations "$HR_ABOUT" "$EN_ABOUT" || true

echo "==> Creating Beliefs / Što vjerujemo..."
HR_BELIEFS=$(create_page "Što vjerujemo" "sto-vjerujemo" "hr")
EN_BELIEFS=$(create_page "What We Believe" "what-we-believe" "en")
link_translations "$HR_BELIEFS" "$EN_BELIEFS" || true

echo "==> Creating Services / Bogoslužja..."
HR_SERVICES=$(create_page "Bogoslužja" "bogosluzja" "hr")
EN_SERVICES=$(create_page "Services" "services" "en")
link_translations "$HR_SERVICES" "$EN_SERVICES" || true

echo "==> Creating Contact / Kontakt..."
HR_CONTACT=$(create_page "Kontakt" "kontakt" "hr")
EN_CONTACT=$(create_page "Contact" "contact" "en")
link_translations "$HR_CONTACT" "$EN_CONTACT" || true

echo "==> Setting Croatian Home as front page..."
wp option update show_on_front "page"
wp option update page_on_front "$HR_HOME"

echo "==> Building primary menus..."
# Croatian menu
wp menu create "Glavni izbornik" || true
wp menu item add-post glavni-izbornik "$HR_HOME" --title="Početna"
wp menu item add-post glavni-izbornik "$HR_ABOUT" --title="O nama"
wp menu item add-post glavni-izbornik "$HR_BELIEFS" --title="Što vjerujemo"
wp menu item add-post glavni-izbornik "$HR_SERVICES" --title="Bogoslužja"
wp menu item add-post glavni-izbornik "$HR_CONTACT" --title="Kontakt"

# English menu
wp menu create "Main Menu" || true
wp menu item add-post main-menu "$EN_HOME" --title="Home"
wp menu item add-post main-menu "$EN_ABOUT" --title="About"
wp menu item add-post main-menu "$EN_BELIEFS" --title="What We Believe"
wp menu item add-post main-menu "$EN_SERVICES" --title="Services"
wp menu item add-post main-menu "$EN_CONTACT" --title="Contact"

# Assign menus to locations (Hello Elementor uses 'menu-1' as primary)
wp menu location assign glavni-izbornik menu-1 || true

echo "Pages and menus created."

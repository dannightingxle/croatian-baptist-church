# Croatian Baptist Church Website

Simple, bilingual (Croatian / English) website for a small Croatian baptist church. Built on **WordPress + Elementor** so the pastor can edit pages visually, with the underlying site infrastructure version-controlled in git.

## What's in this repo

```
church-website/
├── docker-compose.yml          Local WordPress + MySQL + WP-CLI
├── .env.example                Copy to .env before first run
├── scripts/
│   ├── provision.sh            One-shot install: WP core, plugins, theme, pages, menus, languages
│   ├── import-pages.sh         Create bilingual page set + menus
│   ├── import-templates.sh     Import Elementor template JSONs from templates/
│   └── export.sh               DB + uploads backup
├── wp-content/
│   ├── themes/rm-church/       Hello Elementor child theme (minimal — Elementor does the heavy lifting)
│   └── plugins/rm-church-customizations/
│                               Site settings page + shortcodes ([rm_church], [rm_church_socials])
├── templates/                  Elementor template exports (.json) — committed for reproducibility
└── docs/
    ├── EDITING.md              Guide for the pastor / Dad — how to edit pages
    ├── HOSTING.md              How to deploy to production
    └── CONTENT.md              List of info we need from the pastor
```

## Quickstart (local dev)

Prereqs: Docker Desktop.

```bash
cd church-website
cp .env.example .env          # edit credentials if you want
docker compose up -d          # starts WP + MySQL
./scripts/provision.sh        # installs WP, plugins, theme, creates pages
```

Open http://localhost:8080 (site) and http://localhost:8080/wp-admin (admin, creds from `.env`).

To bring up phpMyAdmin too: `docker compose --profile tools up -d`

## Editing the site

See [`docs/EDITING.md`](docs/EDITING.md) for the non-technical guide.

In short: log into `/wp-admin`, click **Pages**, pick a page, click **Edit with Elementor**, drag things around, click **Update**.

## Going to production

See [`docs/HOSTING.md`](docs/HOSTING.md). The TL;DR is: pick a managed WordPress host (Kinsta, SiteGround, etc.), migrate the database + `wp-content/uploads` from local, and point the domain.

## What still needs to happen

- [ ] Wait for content from Ratimir (see [`docs/CONTENT.md`](docs/CONTENT.md))
- [ ] Build Elementor templates for Home, About, Beliefs, Services, Contact
- [ ] Pick a domain
- [ ] Pick a host
- [ ] Hook up Facebook / Instagram / YouTube URLs in **Settings > RM Church**

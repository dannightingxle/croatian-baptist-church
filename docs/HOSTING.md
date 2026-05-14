# Hosting the Church Site

The local Docker setup is for development. Production needs a real host.

## Recommended hosts

For a small church site, any of these are fine. Sorted by ease of use:

| Host | Price/mo | Why |
|---|---|---|
| **SiteGround StartUp** | ~£3 | Cheap, decent performance, one-click WordPress, good support for non-technical users. |
| **Kinsta Starter** | ~£28 | Premium managed WP. Overkill for one small site but very low-maintenance. |
| **Hostinger Premium** | ~£3 | Cheapest. Fine for low traffic. |
| **Cloudways DigitalOcean 1GB** | ~£12 | More technical, but easy backups + staging. |

If Dad/Ratimir want this to "just work" with minimal fiddling: **SiteGround** is the right pick.

## Domain

Buy from any registrar (Namecheap, Cloudflare, GoDaddy). `.hr` domains are restricted — needs a Croatian connection. `.com` / `.org` / `.church` are open to anyone.

Suggestions:
- `[churchname].hr` if they qualify
- `[churchname].com`
- `[churchname].church` (purpose-built TLD)

## Deploying to production (first time)

1. **Provision** a fresh WordPress install on the host (most managed hosts do this in one click).
2. **Migrate** the dev site over using the **All-in-One WP Migration** plugin (free, reliable). Steps:
   - Locally: install All-in-One WP Migration, **Export > File**, download the `.wpress` file.
   - On the new host: install All-in-One WP Migration, **Import > File**, upload.
3. **Re-save permalinks**: Settings > Permalinks > Save (no changes needed, just click Save).
4. **Update site URL** if needed: Settings > General.
5. **Point the domain** at the host (DNS records — the host's docs will tell you which A/CNAME records to add).
6. **Install an SSL certificate** — every recommended host gives free Let's Encrypt SSL with one click.

## Backups

For production, set up automated backups via the host (most include daily backups on paid plans). As a safety net you can also install **UpdraftPlus** and point it at Google Drive — free tier is enough for a site this small.

Locally you can dump the DB + uploads with `./scripts/export.sh`.

## Updates

WordPress, plugins, and themes will need updating. With Elementor + Polylang on a small site this is normally safe to auto-update. Settings to enable:

- **Dashboard > Updates** — turn on auto-updates for plugins.
- For major WordPress versions, leave manual (so a bad release doesn't break the site silently).

## When things break

1. Most managed hosts (SiteGround, Kinsta) can roll back to yesterday's backup in one click.
2. If the site is completely down, contact the host's support — they're usually quick.
3. As a last resort: re-run the migration import from the most recent `.wpress` export.

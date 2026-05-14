# Editing the Church Website

This guide is for whoever is keeping the site up to date day-to-day (probably the pastor or a volunteer). No code knowledge needed.

## Logging in

1. Go to `https://yoursite.com/wp-admin`
2. Enter your username and password.

## Editing a page

1. In the left sidebar, click **Pages**.
2. Hover over the page you want to change (e.g. "Početna" / "Home").
3. Click **Edit with Elementor** (the blue button or link).
4. The page opens in the Elementor visual editor.
5. Click any block of text or image — its settings appear on the left.
6. To change text: just click and type.
7. To change an image: click the image, then click the image preview in the left sidebar, then **Choose Image** or upload a new one.
8. When you're done, click the green **Update** button at the bottom of the left sidebar.

## Adding a new page

1. **Pages > Add New**.
2. Give it a title (e.g. "Događanja" for "Events").
3. Click **Publish** once so WordPress saves it.
4. Click **Edit with Elementor**.
5. Drag widgets from the left sidebar onto the page.

### Linking the new page in both languages

The site uses **Polylang** to handle Croatian + English versions of every page.

1. After creating the Croatian page, look on the right side for the **Languages** box.
2. Next to "English", click the **+** icon to create the English version.
3. Translate the content and publish.

## Changing site-wide info (address, phone, social media)

1. In the WP admin sidebar: **Settings > RM Church**.
2. Edit the fields (address, Facebook URL, etc.).
3. Click **Save Changes**.

Anywhere on the site that shows this info will update automatically.

You can also drop these into any text block in Elementor:

- `[rm_church key="phone"]` — shows the phone number
- `[rm_church key="email"]` — shows the email
- `[rm_church key="address"]` — shows the address
- `[rm_church key="service_time"]` — shows service time in the visitor's language
- `[rm_church_socials]` — shows all set social links inline

## Adding the church to a social media post

Use the page URL from the address bar of your browser when you're on that page. WordPress generates clean, shareable URLs automatically. Facebook / Instagram / WhatsApp will pull the page title and a preview image when you paste the link.

To control which image is used as the preview, edit the page and set the **Featured Image** (right sidebar in the standard WP editor — not Elementor).

## Adding a sermon / blog post (when we add this later)

Not built yet. When it is, the workflow will be **Posts > Add New** instead of Pages.

## Help

If something looks broken, the safest thing is:
1. Don't click anything that says "delete."
2. Take a screenshot.
3. Send it to Dan.

#!/usr/bin/env bash
# Create the starter set of pages in both Croatian and English,
# populate them with placeholder content, and link them as Polylang
# translations. Idempotent-ish — safe to re-run, but will create
# duplicates if pages already exist.

set -euo pipefail

wp() { docker compose run --rm wpcli "$@"; }

# ---------- Page content (HR / EN) ----------

read -r -d '' HR_ABOUT <<'HTML' || true
<p class="lede">Mi smo mala baptistička zajednica koja se okuplja oko jednog cilja: poznati Krista i pomoći drugima da ga upoznaju.</p>

<h2>Naša priča</h2>
<p>Naša crkva osnovana je s uvjerenjem da Crkva nije zgrada, nego ljudi — okupljeni oko Riječi, krštenja i Gospodnje večere. Kroz godine smo bili obitelj koja se moli, koja uči zajedno, koja se brine jedni za druge.</p>

<h2>Tko smo</h2>
<p>Nismo velika crkva. Ne želimo to biti. Naša snaga je u zajedništvu — u tome što se poznajemo po imenu, što se molimo jedni za druge, i što djeca odrastaju oko stolova naših domova jednako kao u nedjeljnom bogoslužju.</p>

<p>Naša zajednica obuhvaća obitelji, samce, mlade i starije. Imamo ljude koji su odrasli u vjeri i one koji su tek počeli istraživati tko je Isus. Svi su dobrodošli — bez obzira gdje se nalaze na svom putu.</p>

<h2>Što je za nas važno</h2>
<ul>
  <li><strong>Pismo</strong> — Biblija oblikuje sve što vjerujemo i činimo.</li>
  <li><strong>Molitva</strong> — ovisimo o Bogu, ne o vlastitim sposobnostima.</li>
  <li><strong>Zajedništvo</strong> — život vjere se ne živi sam.</li>
  <li><strong>Misija</strong> — evanđelje je vijest za susjeda, kolegu, prijatelja.</li>
</ul>

<p><em>Više detalja o povijesti crkve i pastoru bit će dodano uskoro.</em></p>
HTML

read -r -d '' EN_ABOUT <<'HTML' || true
<p class="lede">We're a small baptist community gathered around one purpose: to know Christ and help others know him.</p>

<h2>Our Story</h2>
<p>Our church was founded with the conviction that the Church is not a building but a people — gathered around the Word, baptism, and the Lord's Supper. Across the years we've been a family that prays, that learns together, that looks after one another.</p>

<h2>Who We Are</h2>
<p>We're not a big church. We don't want to be. Our strength is community — knowing each other by name, praying for one another, and watching children grow up around our dinner tables as much as in Sunday worship.</p>

<p>Our congregation includes families, singles, young people, and older saints. Some grew up in the faith; others are just beginning to explore who Jesus is. All are welcome — wherever they are on the journey.</p>

<h2>What Matters to Us</h2>
<ul>
  <li><strong>Scripture</strong> — the Bible shapes everything we believe and do.</li>
  <li><strong>Prayer</strong> — we depend on God, not on our own abilities.</li>
  <li><strong>Community</strong> — the life of faith isn't lived alone.</li>
  <li><strong>Mission</strong> — the gospel is good news for neighbours, colleagues, friends.</li>
</ul>

<p><em>More details about our history and pastor coming soon.</em></p>
HTML

read -r -d '' HR_BELIEFS <<'HTML' || true
<p class="lede">Naše vjerovanje nije iznimno — dijelimo ga s baptistima i evanđeoskim kršćanima diljem svijeta. Evo što vjerujemo, ukratko.</p>

<h2>Pismo</h2>
<p>Vjerujemo da je Biblija — i Stari i Novi zavjet — nadahnuta Riječ Božja, nepogrešiva i u svemu mjerodavna za vjeru i život.</p>

<h2>Bog</h2>
<p>Vjerujemo u jednoga Boga, vječno postojećeg u tri Osobe: Otac, Sin i Duh Sveti.</p>

<h2>Isus Krist</h2>
<p>Vjerujemo da je Isus Krist potpuno Bog i potpuno čovjek. Rođen od djevice Marije, živio je bez grijeha, umro na križu za grijehe svijeta, treći dan uskrsnuo iz mrtvih, i jednoga će se dana vratiti u slavi.</p>

<h2>Spasenje</h2>
<p>Vjerujemo da je spasenje dar Božje milosti, primljen samo kroz vjeru u Isusa Krista — ne kroz djela, ne kroz tradiciju, nego kroz pouzdanje u ono što je Krist učinio.</p>

<h2>Krštenje</h2>
<p>Kao baptisti, vjerujemo u krštenje uranjanjem onih koji su osobno povjerovali u Krista. Krštenje je javni svjedok unutarnje promjene, ne sredstvo spasenja.</p>

<h2>Crkva</h2>
<p>Crkva je zajednica vjernika — mjesto poučavanja, molitve, slavljenja, zajedništva i službe svijetu.</p>

<h2>Posljednje stvari</h2>
<p>Vjerujemo u tjelesno uskrsnuće, u Kristov povratak, i u vječni život sa Bogom za sve koji su povjerovali u njega.</p>
HTML

read -r -d '' EN_BELIEFS <<'HTML' || true
<p class="lede">Our beliefs are not unusual — we share them with baptists and evangelicals around the world. Here's what we believe, in brief.</p>

<h2>Scripture</h2>
<p>We believe the Bible — both Old and New Testaments — is the inspired Word of God, without error and fully authoritative for faith and life.</p>

<h2>God</h2>
<p>We believe in one God, eternally existing in three Persons: Father, Son, and Holy Spirit.</p>

<h2>Jesus Christ</h2>
<p>We believe Jesus Christ is fully God and fully human. Born of the virgin Mary, he lived a sinless life, died on the cross for the sins of the world, rose again on the third day, and will one day return in glory.</p>

<h2>Salvation</h2>
<p>We believe salvation is a gift of God's grace, received only through faith in Jesus Christ — not through works, not through tradition, but through trust in what Christ has done.</p>

<h2>Baptism</h2>
<p>As baptists, we practise the baptism by immersion of those who have personally trusted in Christ. Baptism is a public witness to an inward change, not a means of salvation.</p>

<h2>The Church</h2>
<p>The Church is a community of believers — a place for teaching, prayer, worship, fellowship, and service to the world.</p>

<h2>Last Things</h2>
<p>We believe in the bodily resurrection, in Christ's return, and in eternal life with God for all who have trusted in him.</p>
HTML

read -r -d '' HR_SERVICES <<'HTML' || true
<p class="lede">Sastajemo se svake nedjelje u 10:00. Ako razmišljate posjetiti nas — evo što vas očekuje.</p>

<h2>Kada se sastajemo</h2>
<ul>
  <li><strong>Nedjelja, 10:00</strong> — glavno bogoslužje s propovijedi</li>
  <li><strong>Srijeda, 19:00</strong> — biblijski sat i molitva</li>
  <li><strong>Petak, 19:00</strong> — mladi (jednom mjesečno)</li>
</ul>

<h2>Što očekivati</h2>
<p>Bogoslužje traje oko 75 minuta. Pjevamo, čitamo Pismo, molimo se zajedno i slušamo propovijed iz Biblije — obično jedan odlomak detaljno objašnjen.</p>
<p>Nema dress codea. Dođite kakvi jeste. Nećemo vas zvati na pozornicu, nećemo tražiti darove, i nećete morati ništa potpisivati.</p>

<h2>Djeca</h2>
<p>Djeca su dobrodošla u glavno bogoslužje. Imamo i kratku zasebnu pouku za najmlađe tijekom propovijedi (po dogovoru).</p>

<h2>Kava i razgovor</h2>
<p>Nakon bogoslužja ostajemo na kavi i razgovoru. Ako ste novi — predstavite se. Volimo upoznati nove ljude.</p>

<h2>Kako stići</h2>
<p>Naša adresa i karta nalaze se na <a href="/kontakt/">stranici Kontakt</a>. Imate li pitanje prije dolaska — slobodno nam pišite.</p>
HTML

read -r -d '' EN_SERVICES <<'HTML' || true
<p class="lede">We meet every Sunday at 10:00. If you're thinking about visiting — here's what to expect.</p>

<h2>When We Meet</h2>
<ul>
  <li><strong>Sunday, 10:00</strong> — main worship service with a sermon</li>
  <li><strong>Wednesday, 19:00</strong> — Bible study and prayer</li>
  <li><strong>Friday, 19:00</strong> — youth meeting (monthly)</li>
</ul>

<h2>What to Expect</h2>
<p>The service lasts about 75 minutes. We sing, read the Scriptures, pray together, and listen to a sermon from the Bible — usually one passage explained in depth.</p>
<p>There's no dress code. Come as you are. We won't call you onto the stage, won't ask you for money, and won't make you sign anything.</p>

<h2>Children</h2>
<p>Children are welcome in the main service. We also offer a short separate lesson for the youngest during the sermon (just let us know).</p>

<h2>Coffee &amp; Conversation</h2>
<p>After the service we stay for coffee and conversation. If you're new — introduce yourself. We love meeting new people.</p>

<h2>Getting Here</h2>
<p>Our address and a map are on the <a href="/contact/">Contact page</a>. Got a question before you visit? Drop us a line.</p>
HTML

read -r -d '' HR_CONTACT <<'HTML' || true
<p class="lede">Imate pitanje? Razmišljate posjetiti? Pišite nam — odgovaramo unutar nekoliko dana.</p>

<h2>Kako nas pronaći</h2>
<p>Adresa, telefon i email nalaze se u podnožju svake stranice (i ovdje će biti, jednom kad ih dodamo u <em>Postavke &gt; RM Church</em>).</p>

<h2>Pošaljite nam poruku</h2>
<p>Kontakt obrazac dolazi uskoro. Za sada možete nam pisati direktno na email naveden u podnožju.</p>

<h2>Pratite nas</h2>
<p>Najavu propovijedi, fotografije i obavijesti dijelimo na našim društvenim mrežama. Linkovi su u podnožju stranice.</p>
HTML

read -r -d '' EN_CONTACT <<'HTML' || true
<p class="lede">Got a question? Thinking about visiting? Write to us — we usually reply within a few days.</p>

<h2>How to Find Us</h2>
<p>Address, phone, and email are in the footer of every page (and will appear here once we've added them under <em>Settings &gt; RM Church</em>).</p>

<h2>Send Us a Message</h2>
<p>A contact form is coming soon. For now you can email us directly using the address in the footer.</p>

<h2>Follow Us</h2>
<p>Sermon announcements, photos, and news go out on our social channels. Links are in the footer.</p>
HTML

# ---------- Helper ----------

create_page() {
  local title="$1"
  local slug="$2"
  local lang="$3"
  local content_var="$4"
  local content
  content="${!content_var-}"
  local id
  id=$(wp post create \
        --post_type=page \
        --post_status=publish \
        --post_title="$title" \
        --post_name="$slug" \
        --post_content="$content" \
        --porcelain)
  wp pll post language "$id" "$lang" || true
  echo "$id"
}

link_translations() {
  wp pll post create-translations "$1" "$2" || true
}

# ---------- Create pages ----------

echo "==> Creating Home..."
HR_HOME=$(create_page "Početna" "pocetna" "hr" "_NO_CONTENT")
EN_HOME=$(create_page "Home" "home" "en" "_NO_CONTENT")
link_translations "$HR_HOME" "$EN_HOME"

echo "==> Creating About / O nama..."
HR_ID=$(create_page "O nama" "o-nama" "hr" HR_ABOUT)
EN_ID=$(create_page "About Us" "about" "en" EN_ABOUT)
link_translations "$HR_ID" "$EN_ID"

echo "==> Creating Beliefs / Što vjerujemo..."
HR_ID=$(create_page "Što vjerujemo" "sto-vjerujemo" "hr" HR_BELIEFS)
EN_ID=$(create_page "What We Believe" "what-we-believe" "en" EN_BELIEFS)
link_translations "$HR_ID" "$EN_ID"

echo "==> Creating Services / Bogoslužja..."
HR_ID=$(create_page "Bogoslužja" "bogosluzja" "hr" HR_SERVICES)
EN_ID=$(create_page "Services" "services" "en" EN_SERVICES)
link_translations "$HR_ID" "$EN_ID"

echo "==> Creating Contact / Kontakt..."
HR_CONTACT_ID=$(create_page "Kontakt" "kontakt" "hr" HR_CONTACT)
EN_CONTACT_ID=$(create_page "Contact" "contact" "en" EN_CONTACT)
link_translations "$HR_CONTACT_ID" "$EN_CONTACT_ID"

echo "==> Setting Croatian Home as front page..."
wp option update show_on_front "page"
wp option update page_on_front "$HR_HOME"

echo "==> Setting site title..."
wp option update blogname "Baptistička crkva"
wp option update blogdescription "Mala crkva. Velika nada."

echo "==> Seeding RM Church settings with placeholder values..."
# So the footer / hero have something to display before the pastor sets them.
wp option update rm_church_settings --format=json '{
  "address": "Ulica i broj, Grad, Hrvatska",
  "phone": "+385 91 234 5678",
  "email": "info@example.hr",
  "service_time_hr": "Nedjeljom u 10:00",
  "service_time_en": "Sundays at 10:00",
  "facebook_url": "https://facebook.com/",
  "instagram_url": "https://instagram.com/",
  "youtube_url": "",
  "whatsapp_url": ""
}'

echo "==> Building primary menus..."
wp menu create "Glavni izbornik" 2>/dev/null || true
wp menu item add-post glavni-izbornik "$HR_HOME"   --title="Početna" 2>/dev/null || true
wp menu item add-post glavni-izbornik "$(wp post list --post_type=page --name=o-nama --field=ID)"        --title="O nama" 2>/dev/null || true
wp menu item add-post glavni-izbornik "$(wp post list --post_type=page --name=sto-vjerujemo --field=ID)" --title="Što vjerujemo" 2>/dev/null || true
wp menu item add-post glavni-izbornik "$(wp post list --post_type=page --name=bogosluzja --field=ID)"    --title="Bogoslužja" 2>/dev/null || true
wp menu item add-post glavni-izbornik "$HR_CONTACT_ID" --title="Kontakt" 2>/dev/null || true

wp menu create "Main Menu" 2>/dev/null || true
wp menu item add-post main-menu "$EN_HOME"   --title="Home" 2>/dev/null || true
wp menu item add-post main-menu "$(wp post list --post_type=page --name=about --field=ID)"            --title="About" 2>/dev/null || true
wp menu item add-post main-menu "$(wp post list --post_type=page --name=what-we-believe --field=ID)"  --title="What We Believe" 2>/dev/null || true
wp menu item add-post main-menu "$(wp post list --post_type=page --name=services --field=ID)"        --title="Services" 2>/dev/null || true
wp menu item add-post main-menu "$EN_CONTACT_ID" --title="Contact" 2>/dev/null || true

# Default location uses the current language's menu (Polylang handles per-language assignment).
wp menu location assign glavni-izbornik menu-1 2>/dev/null || true

echo "Pages, content, settings and menus created."

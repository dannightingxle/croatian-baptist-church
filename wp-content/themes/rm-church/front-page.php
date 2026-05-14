<?php
/**
 * Home page template — used automatically when the front page is set
 * to a static page (which our provision.sh does).
 *
 * If the page has Elementor content saved, that takes priority and this
 * template is bypassed. So the pastor can later "Edit with Elementor"
 * and override this design without losing the rest of the site.
 *
 * @package RM_Church
 */

get_header();

$is_en          = rm_church_lang() === 'en';
$church_name    = get_bloginfo( 'name' );
$service_hr     = rm_church_setting( 'service_time_hr', 'Nedjeljom u 10:00' );
$service_en     = rm_church_setting( 'service_time_en', 'Sundays at 10:00' );
$service        = $is_en ? $service_en : $service_hr;
$address        = rm_church_setting( 'address' );

// Resolve linked page IDs in current language
$id_about    = get_page_by_path( $is_en ? 'about' : 'o-nama' );
$id_beliefs  = get_page_by_path( $is_en ? 'what-we-believe' : 'sto-vjerujemo' );
$id_services = get_page_by_path( $is_en ? 'services' : 'bogosluzja' );
$id_contact  = get_page_by_path( $is_en ? 'contact' : 'kontakt' );
$url_about   = $id_about    ? get_permalink( $id_about )    : '#';
$url_beliefs = $id_beliefs  ? get_permalink( $id_beliefs )  : '#';
$url_serv    = $id_services ? get_permalink( $id_services ) : '#';
$url_contact = $id_contact  ? get_permalink( $id_contact )  : '#';
?>

<section class="hero">
	<div class="container hero__inner">
		<span class="hero__service">
			<?php echo esc_html( $service ); ?>
			<?php if ( $address ) : ?> · <?php echo esc_html( $address ); ?><?php endif; ?>
		</span>
		<h1>
			<?php echo esc_html( rm_church_t(
				'Mjesto gdje Riječ Božja oblikuje život.',
				'A place where God\'s Word shapes life.'
			) ); ?>
		</h1>
		<p class="lede">
			<?php echo esc_html( rm_church_t(
				'Mi smo mala baptistička zajednica u Hrvatskoj. Svake nedjelje okupljamo se oko Krista — da slušamo Pismo, molimo zajedno i živimo evanđelje u svakodnevici.',
				'We\'re a small baptist church in Croatia. Every Sunday we gather around Christ — to hear the Scriptures, pray together, and live out the gospel in everyday life.'
			) ); ?>
		</p>
		<div class="btn-row">
			<a class="btn btn--primary" href="<?php echo esc_url( $url_serv ); ?>"><?php echo esc_html( rm_church_t( 'Pridružite nam se', 'Plan a Visit' ) ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( $url_about ); ?>"><?php echo esc_html( rm_church_t( 'Saznajte više', 'Learn More' ) ); ?></a>
		</div>
	</div>
</section>

<section class="section">
	<div class="container split">
		<div>
			<span class="eyebrow"><?php echo esc_html( rm_church_t( 'Dobrodošli', 'Welcome' ) ); ?></span>
			<h2><?php echo esc_html( rm_church_t( 'Crkva s otvorenim vratima.', 'An open-doored church.' ) ); ?></h2>
			<p class="lede">
				<?php echo esc_html( rm_church_t(
					'Bez obzira tko ste, odakle dolazite ili gdje ste na svom putu vjere — kod nas ste dobrodošli.',
					'Whoever you are, wherever you\'re from, wherever you are on your journey of faith — you are welcome here.'
				) ); ?>
			</p>
			<p>
				<?php echo esc_html( rm_church_t(
					'Naša zajednica nije savršena, ali je iskrena. Susrećemo se kao obitelj — s djecom, mladima, starijima — i zajedno tražimo Krista u Pismu i u zajedništvu.',
					'Our church isn\'t perfect, but it is honest. We meet as a family — children, young adults, the older generation — and seek Christ together in Scripture and in community.'
				) ); ?>
			</p>
			<p>
				<a href="<?php echo esc_url( $url_about ); ?>"><?php echo esc_html( rm_church_t( 'Više o nama →', 'More about us →' ) ); ?></a>
			</p>
		</div>
		<div class="split__media" aria-hidden="true">
			<?php echo esc_html( rm_church_t( 'Fotografija zajednice', 'Community photo' ) ); ?>
		</div>
	</div>
</section>

<section class="section section--alt">
	<div class="container">
		<div style="text-align:center; max-width: 640px; margin-inline: auto;">
			<span class="eyebrow"><?php echo esc_html( rm_church_t( 'Što vjerujemo', 'What We Believe' ) ); ?></span>
			<h2><?php echo esc_html( rm_church_t( 'Krist je dovoljan.', 'Christ is enough.' ) ); ?></h2>
			<p class="lede" style="margin-inline:auto;">
				<?php echo esc_html( rm_church_t(
					'Naša vjera ne počiva na tradiciji ili osjećajima, već na osobi i djelu Isusa Krista, kako je otkriven u Pismu.',
					'Our faith doesn\'t rest on tradition or feelings, but on the person and work of Jesus Christ as revealed in Scripture.'
				) ); ?>
			</p>
		</div>

		<div class="grid grid--3" style="margin-top: 3rem;">
			<div class="card">
				<div class="card__icon">✝</div>
				<h3><?php echo esc_html( rm_church_t( 'Pismo', 'Scripture' ) ); ?></h3>
				<p><?php echo esc_html( rm_church_t( 'Biblija je nadahnuta i mjerodavna Riječ Božja — temelj svega što vjerujemo i činimo.', 'The Bible is the inspired, authoritative Word of God — the foundation of all we believe and do.' ) ); ?></p>
			</div>
			<div class="card">
				<div class="card__icon">✚</div>
				<h3><?php echo esc_html( rm_church_t( 'Evanđelje', 'The Gospel' ) ); ?></h3>
				<p><?php echo esc_html( rm_church_t( 'Spasenje je dar milosti, kroz vjeru u Krista raspetog i uskrslog. Ne zarađuje se — prima se.', 'Salvation is a gift of grace, through faith in Christ crucified and risen. Not earned — received.' ) ); ?></p>
			</div>
			<div class="card">
				<div class="card__icon">✦</div>
				<h3><?php echo esc_html( rm_church_t( 'Krštenje', 'Baptism' ) ); ?></h3>
				<p><?php echo esc_html( rm_church_t( 'Krštenjem na vlastito ispovijedanje vjere svjedočimo o novom životu u Kristu.', 'Believer\'s baptism is our public witness to new life in Christ.' ) ); ?></p>
			</div>
		</div>

		<p class="text-center" style="margin-top: 2.5rem;">
			<a class="btn btn--dark" href="<?php echo esc_url( $url_beliefs ); ?>"><?php echo esc_html( rm_church_t( 'Pročitajte naše vjerovanje', 'Read our statement of faith' ) ); ?></a>
		</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div style="text-align:center;">
			<span class="eyebrow"><?php echo esc_html( rm_church_t( 'Bogoslužja', 'Gather With Us' ) ); ?></span>
			<h2><?php echo esc_html( rm_church_t( 'Sastajemo se svake nedjelje.', 'We meet every Sunday.' ) ); ?></h2>
		</div>
		<div class="times">
			<div class="time-card">
				<div class="time-card__day"><?php echo esc_html( rm_church_t( 'Nedjeljom', 'Sunday' ) ); ?></div>
				<div class="time-card__time"><?php echo esc_html( $is_en ? '10:00' : '10:00' ); ?></div>
				<div class="time-card__desc"><?php echo esc_html( rm_church_t( 'Bogoslužje i propovijed', 'Worship & teaching' ) ); ?></div>
			</div>
			<div class="time-card">
				<div class="time-card__day"><?php echo esc_html( rm_church_t( 'Srijedom', 'Wednesday' ) ); ?></div>
				<div class="time-card__time">19:00</div>
				<div class="time-card__desc"><?php echo esc_html( rm_church_t( 'Biblijski sat i molitva', 'Bible study & prayer' ) ); ?></div>
			</div>
			<div class="time-card">
				<div class="time-card__day"><?php echo esc_html( rm_church_t( 'Petkom', 'Friday' ) ); ?></div>
				<div class="time-card__time">19:00</div>
				<div class="time-card__desc"><?php echo esc_html( rm_church_t( 'Mladi (jednom mjesečno)', 'Youth (monthly)' ) ); ?></div>
			</div>
		</div>
		<p class="text-center" style="margin-top: 2.5rem;">
			<a class="btn btn--ghost" style="color: var(--ink); border-color: var(--ink);" href="<?php echo esc_url( $url_serv ); ?>"><?php echo esc_html( rm_church_t( 'Što očekivati pri posjetu', 'What to expect when you visit' ) ); ?></a>
		</p>
	</div>
</section>

<section class="section section--alt">
	<div class="container split split--reverse">
		<div>
			<span class="eyebrow"><?php echo esc_html( rm_church_t( 'Riječ pastora', 'A Word from the Pastor' ) ); ?></span>
			<blockquote>
				<?php echo esc_html( rm_church_t(
					'„Volimo malu crkvu — gdje se znamo po imenu, gdje se molimo jedni za druge, i gdje je Krist središte svega."',
					'"We love being a small church — where we know each other by name, pray for one another, and where Christ is the centre of everything."'
				) ); ?>
				<cite><?php echo esc_html( rm_church_t( 'Pastor (ime se uskoro dodaje)', 'The Pastor (name coming soon)' ) ); ?></cite>
			</blockquote>
		</div>
		<div class="split__media" aria-hidden="true">
			<?php echo esc_html( rm_church_t( 'Fotografija pastora', 'Pastor portrait' ) ); ?>
		</div>
	</div>
</section>

<section class="cta-band">
	<div class="container">
		<h2><?php echo esc_html( rm_church_t( 'Posjetite nas ove nedjelje.', 'Visit us this Sunday.' ) ); ?></h2>
		<p class="lede"><?php echo esc_html( rm_church_t( 'Nema potrebe za pozivnicom. Dođite kakvi jeste — vidimo se u 10:00.', 'No invitation needed. Come as you are — see you at 10:00.' ) ); ?></p>
		<div class="btn-row">
			<a class="btn btn--primary" href="<?php echo esc_url( $url_contact ); ?>"><?php echo esc_html( rm_church_t( 'Kontaktirajte nas', 'Get in Touch' ) ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( $url_serv ); ?>"><?php echo esc_html( rm_church_t( 'Detalji bogoslužja', 'Service Details' ) ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();

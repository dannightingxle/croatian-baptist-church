<?php
/**
 * RM Church child theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RM_CHURCH_VERSION = '0.2.0';

/* ----------------------------------------------------------------------------
 * Theme setup
 * -------------------------------------------------------------------------- */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	register_nav_menus( [
		'menu-1' => __( 'Primary', 'rm-church' ),
		'footer' => __( 'Footer', 'rm-church' ),
	] );

	// Larger feature image sizes for hero photos
	add_image_size( 'rm-hero', 1920, 1080, true );
	add_image_size( 'rm-card', 720, 540, true );
} );

/* ----------------------------------------------------------------------------
 * Assets
 * -------------------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'rm-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'hello-elementor', get_template_directory_uri() . '/style.css', [], null );
	wp_enqueue_style(
		'rm-church',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'hello-elementor', 'rm-fonts' ],
		RM_CHURCH_VERSION
	);
	wp_enqueue_script(
		'rm-church',
		get_stylesheet_directory_uri() . '/assets/nav.js',
		[],
		RM_CHURCH_VERSION,
		true
	);
}, 20 );

add_filter( 'style_loader_tag', function ( $html, $handle ) {
	// Preconnect to Google Fonts for snappier first paint
	if ( $handle === 'rm-fonts' ) {
		$preconnect  = "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
		$preconnect .= "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
		return $preconnect . $html;
	}
	return $html;
}, 10, 2 );

/* ----------------------------------------------------------------------------
 * Helpers — content + settings access
 * -------------------------------------------------------------------------- */

/** Current Polylang language, falling back to 'hr'. */
function rm_church_lang() {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
		if ( $lang ) {
			return $lang;
		}
	}
	return 'hr';
}

/** Translate inline by passing both strings. */
function rm_church_t( $hr, $en ) {
	return rm_church_lang() === 'en' ? $en : $hr;
}

/** Get a setting value from rm-church-customizations plugin. */
function rm_church_setting( $key, $fallback = '' ) {
	if ( function_exists( 'rm_church_get_settings' ) ) {
		$settings = rm_church_get_settings();
		$value    = $settings[ $key ] ?? '';
		if ( ! empty( $value ) ) {
			return $value;
		}
	}
	return $fallback;
}

/** Get a translated page URL for the language switcher. */
function rm_church_translated_url( $lang ) {
	if ( ! function_exists( 'pll_current_language' ) ) {
		return home_url( '/' );
	}

	$current_id = get_queried_object_id();
	$front_id   = (int) get_option( 'page_on_front' );

	// On the front page (or any of its translations), link to the language's
	// home URL — Polylang serves the right translation at /, /en/, etc.
	// Using get_permalink() on a translation would give /en/home/ which is
	// a different (regular-page) route and doesn't use front-page.php.
	if ( $current_id && $front_id ) {
		$front_translations = function_exists( 'pll_get_post_translations' )
			? pll_get_post_translations( $front_id )
			: [];
		if ( in_array( $current_id, $front_translations, true ) || $current_id === $front_id ) {
			return function_exists( 'pll_home_url' ) ? pll_home_url( $lang ) : home_url( '/' );
		}
	}

	// Otherwise, follow the explicit translation of the current page.
	if ( $current_id && function_exists( 'pll_get_post' ) ) {
		$translated = pll_get_post( $current_id, $lang );
		if ( $translated ) {
			return get_permalink( $translated );
		}
	}

	if ( function_exists( 'pll_home_url' ) ) {
		return pll_home_url( $lang );
	}
	return home_url( '/' );
}

/** Render an inline SVG icon by name. Returns HTML string. */
function rm_church_icon( $name ) {
	$icons = [
		'facebook'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8h-3v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.378 14.192 5 15.115 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>',
		'instagram' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608C2.175 15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85C2.295 5.784 2.569 4.517 3.544 3.542 4.519 2.567 5.786 2.293 7.152 2.231 8.418 2.173 8.798 2.163 12 2.163zm0 1.802c-3.141 0-3.503.012-4.737.068-1.024.046-1.58.215-1.95.358-.49.19-.84.418-1.21.788-.37.37-.598.72-.788 1.21-.143.37-.312.926-.358 1.95-.056 1.234-.068 1.596-.068 4.737s.012 3.503.068 4.737c.046 1.024.215 1.58.358 1.95.19.49.418.84.788 1.21.37.37.72.598 1.21.788.37.143.926.312 1.95.358 1.234.056 1.596.068 4.737.068s3.503-.012 4.737-.068c1.024-.046 1.58-.215 1.95-.358.49-.19.84-.418 1.21-.788.37-.37.598-.72.788-1.21.143-.37.312-.926.358-1.95.056-1.234.068-1.596.068-4.737s-.012-3.503-.068-4.737c-.046-1.024-.215-1.58-.358-1.95-.19-.49-.418-.84-.788-1.21-.37-.37-.72-.598-1.21-.788-.37-.143-.926-.312-1.95-.358-1.234-.056-1.596-.068-4.737-.068zM12 6.865A5.135 5.135 0 1112 17.135 5.135 5.135 0 0112 6.865zm0 8.468A3.333 3.333 0 1012 8.667a3.333 3.333 0 000 6.666zm5.338-8.669a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z"/></svg>',
		'youtube'   => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
		'whatsapp'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12.012 22.5h-.005a9.94 9.94 0 0 1-5.06-1.386l-.36-.214-3.76.984 1-3.667-.235-.375a9.92 9.92 0 0 1-1.515-5.265c.003-5.481 4.464-9.94 9.945-9.94 2.654 0 5.149 1.034 7.025 2.913a9.875 9.875 0 0 1 2.91 7.034c-.002 5.483-4.466 9.94-9.945 9.94zM21.515 2.485A11.94 11.94 0 0 0 12.012.5C5.473.5.16 5.812.158 12.348c0 2.089.546 4.128 1.583 5.928L.058 23.5l5.335-1.399a11.946 11.946 0 0 0 5.717 1.456h.005c6.539 0 11.852-5.313 11.854-11.85a11.821 11.821 0 0 0-3.454-8.371z"/></svg>',
	];
	return $icons[ $name ] ?? '';
}

/* ----------------------------------------------------------------------------
 * Tidy up: remove Hello Elementor's default header/footer scaffolding by
 * letting our own header.php / footer.php take over (they already do via
 * template hierarchy — nothing extra needed here).
 * -------------------------------------------------------------------------- */

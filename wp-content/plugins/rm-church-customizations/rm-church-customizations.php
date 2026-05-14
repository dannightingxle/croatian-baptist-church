<?php
/**
 * Plugin Name: RM Church Customizations
 * Description: Site-specific tweaks for the Croatian Baptist Church site. Adds shortcodes for social links and service times so the pastor can drop them into any Elementor page.
 * Version: 0.1.0
 * Author: Dan Nightingale
 * Text Domain: rm-church
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings page: Settings > RM Church
 *
 * Stores a small set of site-wide values the pastor can edit without
 * touching theme code: social URLs, service times, address.
 */
add_action( 'admin_menu', function () {
	add_options_page(
		__( 'RM Church Settings', 'rm-church' ),
		__( 'RM Church', 'rm-church' ),
		'manage_options',
		'rm-church-settings',
		'rm_church_render_settings_page'
	);
} );

add_action( 'admin_init', function () {
	register_setting( 'rm_church_settings', 'rm_church_settings', [
		'type'              => 'array',
		'sanitize_callback' => 'rm_church_sanitize_settings',
		'default'           => rm_church_default_settings(),
	] );
} );

function rm_church_default_settings() {
	return [
		'address'         => '',
		'phone'           => '',
		'email'           => '',
		'service_time_hr' => 'Nedjeljom u 10:00',
		'service_time_en' => 'Sundays at 10:00',
		'facebook_url'    => '',
		'instagram_url'   => '',
		'youtube_url'     => '',
		'whatsapp_url'    => '',
	];
}

function rm_church_get_settings() {
	return wp_parse_args( get_option( 'rm_church_settings', [] ), rm_church_default_settings() );
}

function rm_church_sanitize_settings( $input ) {
	$out = [];
	foreach ( rm_church_default_settings() as $key => $default ) {
		$value = $input[ $key ] ?? $default;
		if ( str_ends_with( $key, '_url' ) ) {
			$out[ $key ] = esc_url_raw( $value );
		} elseif ( $key === 'email' ) {
			$out[ $key ] = sanitize_email( $value );
		} else {
			$out[ $key ] = sanitize_text_field( $value );
		}
	}
	return $out;
}

function rm_church_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$settings = rm_church_get_settings();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'RM Church Settings', 'rm-church' ); ?></h1>
		<p><?php esc_html_e( 'These values appear across the site (header, footer, contact page). Edit them once here and they update everywhere.', 'rm-church' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'rm_church_settings' ); ?>
			<table class="form-table" role="presentation">
				<tbody>
				<?php
				$fields = [
					'address'         => __( 'Address', 'rm-church' ),
					'phone'           => __( 'Phone', 'rm-church' ),
					'email'           => __( 'Email', 'rm-church' ),
					'service_time_hr' => __( 'Service time (Croatian)', 'rm-church' ),
					'service_time_en' => __( 'Service time (English)', 'rm-church' ),
					'facebook_url'    => __( 'Facebook URL', 'rm-church' ),
					'instagram_url'   => __( 'Instagram URL', 'rm-church' ),
					'youtube_url'     => __( 'YouTube URL', 'rm-church' ),
					'whatsapp_url'    => __( 'WhatsApp URL', 'rm-church' ),
				];
				foreach ( $fields as $key => $label ) :
					$value = $settings[ $key ] ?? '';
					?>
					<tr>
						<th scope="row"><label for="rm_church_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="rm_church_<?php echo esc_attr( $key ); ?>"
								name="rm_church_settings[<?php echo esc_attr( $key ); ?>]"
								value="<?php echo esc_attr( $value ); ?>"
							/>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Shortcodes — drop these into any Elementor text widget.
 *
 *   [rm_church key="phone"]
 *   [rm_church_social network="facebook"]
 *   [rm_church_socials] (renders all set social icons inline as text links)
 */
add_shortcode( 'rm_church', function ( $atts ) {
	$atts = shortcode_atts( [ 'key' => '' ], $atts, 'rm_church' );
	$settings = rm_church_get_settings();
	if ( $atts['key'] === 'service_time' ) {
		$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'hr';
		$key  = $lang === 'en' ? 'service_time_en' : 'service_time_hr';
		return esc_html( $settings[ $key ] ?? '' );
	}
	return esc_html( $settings[ $atts['key'] ] ?? '' );
} );

add_shortcode( 'rm_church_social', function ( $atts ) {
	$atts = shortcode_atts( [
		'network' => '',
		'label'   => '',
	], $atts, 'rm_church_social' );
	$settings = rm_church_get_settings();
	$url_key  = $atts['network'] . '_url';
	$url      = $settings[ $url_key ] ?? '';
	if ( empty( $url ) ) {
		return '';
	}
	$label = $atts['label'] !== '' ? $atts['label'] : ucfirst( $atts['network'] );
	return sprintf(
		'<a href="%s" class="rm-church-social rm-church-social--%s" target="_blank" rel="noopener noreferrer">%s</a>',
		esc_url( $url ),
		esc_attr( $atts['network'] ),
		esc_html( $label )
	);
} );

add_shortcode( 'rm_church_socials', function () {
	$settings = rm_church_get_settings();
	$networks = [ 'facebook', 'instagram', 'youtube', 'whatsapp' ];
	$links    = [];
	foreach ( $networks as $n ) {
		$url = $settings[ $n . '_url' ] ?? '';
		if ( ! empty( $url ) ) {
			$links[] = sprintf(
				'<a href="%s" class="rm-church-social rm-church-social--%s" target="_blank" rel="noopener noreferrer">%s</a>',
				esc_url( $url ),
				esc_attr( $n ),
				esc_html( ucfirst( $n ) )
			);
		}
	}
	return '<span class="rm-church-socials">' . implode( ' · ', $links ) . '</span>';
} );

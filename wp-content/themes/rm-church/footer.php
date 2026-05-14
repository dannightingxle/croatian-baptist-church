<?php
/**
 * Site footer.
 *
 * @package RM_Church
 */
$address       = rm_church_setting( 'address', rm_church_t( 'Adresa će biti uskoro dodana', 'Address coming soon' ) );
$phone         = rm_church_setting( 'phone' );
$email         = rm_church_setting( 'email' );
$service_hr    = rm_church_setting( 'service_time_hr', 'Nedjeljom u 10:00' );
$service_en    = rm_church_setting( 'service_time_en', 'Sundays at 10:00' );
$service       = rm_church_lang() === 'en' ? $service_en : $service_hr;
$socials       = [
	'facebook'  => rm_church_setting( 'facebook_url' ),
	'instagram' => rm_church_setting( 'instagram_url' ),
	'youtube'   => rm_church_setting( 'youtube_url' ),
	'whatsapp'  => rm_church_setting( 'whatsapp_url' ),
];
?>
<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-col">
				<span class="footer-brand"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<p class="footer-tag">
					<?php echo esc_html( rm_church_t(
						'Mala baptistička zajednica koja vjeruje u Riječ Božju, ljubi Krista i živi u zajedništvu.',
						'A small baptist community grounded in the Word, in love with Christ, and living together as a family.'
					) ); ?>
				</p>
				<div class="footer-socials">
					<?php foreach ( $socials as $network => $url ) : if ( empty( $url ) ) continue; ?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>">
							<?php echo rm_church_icon( $network ); // safe: hard-coded SVGs ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php echo esc_html( rm_church_t( 'Posjetite nas', 'Visit Us' ) ); ?></h4>
				<ul class="footer-list">
					<li><?php echo esc_html( $address ); ?></li>
					<?php if ( $phone ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
					<?php endif; ?>
					<li class="muted"><?php echo esc_html( $service ); ?></li>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php echo esc_html( rm_church_t( 'Stranice', 'Navigate' ) ); ?></h4>
				<?php
				wp_nav_menu( [
					'theme_location' => 'menu-1',
					'container'      => false,
					'menu_class'     => 'footer-list',
					'fallback_cb'    => false,
					'depth'          => 1,
				] );
				?>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			<span><?php echo esc_html( rm_church_t( 'Slava Bogu na visini.', 'Glory to God in the highest.' ) ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

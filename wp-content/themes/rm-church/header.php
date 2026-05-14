<?php
/**
 * Site header.
 *
 * @package RM_Church
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="container site-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="site-brand__mark" aria-hidden="true">B</span>
				<span class="site-brand__name">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					<span class="site-brand__sub"><?php echo esc_html( rm_church_t( 'Baptistička crkva', 'Baptist Church' ) ); ?></span>
				</span>
			<?php endif; ?>
		</a>

		<button class="nav-toggle" aria-label="<?php esc_attr_e( 'Menu', 'rm-church' ); ?>" aria-expanded="false" aria-controls="primary-nav">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<line x1="4" y1="7" x2="20" y2="7"></line>
				<line x1="4" y1="12" x2="20" y2="12"></line>
				<line x1="4" y1="17" x2="20" y2="17"></line>
			</svg>
		</button>

		<nav class="site-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'rm-church' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'menu-1',
				'container'      => false,
				'menu_class'     => 'site-nav__list',
				'fallback_cb'    => false,
				'depth'          => 1,
			] );
			?>

			<div class="lang-toggle" role="group" aria-label="<?php esc_attr_e( 'Language', 'rm-church' ); ?>">
				<a href="<?php echo esc_url( rm_church_translated_url( 'hr' ) ); ?>"
				   class="<?php echo rm_church_lang() === 'hr' ? 'is-active' : ''; ?>">HR</a>
				<a href="<?php echo esc_url( rm_church_translated_url( 'en' ) ); ?>"
				   class="<?php echo rm_church_lang() === 'en' ? 'is-active' : ''; ?>">EN</a>
			</div>
		</nav>
	</div>
</header>

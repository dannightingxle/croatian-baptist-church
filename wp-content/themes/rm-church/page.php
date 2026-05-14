<?php
/**
 * Default page template — used for About, Beliefs, Services, Contact, etc.
 *
 * Renders a small page hero followed by the WordPress content area (so the
 * pastor can edit content through Pages > Edit with Elementor or the block
 * editor without touching code).
 *
 * @package RM_Church
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="page-hero">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<article class="prose">
			<?php the_content(); ?>
		</article>
	</div>
</section>

<?php endwhile; ?>

<?php
get_footer();

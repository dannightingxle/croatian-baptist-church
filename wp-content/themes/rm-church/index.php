<?php
/**
 * Index fallback — used when no more specific template applies.
 *
 * @package RM_Church
 */

get_header();
?>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="prose" style="margin-bottom: 3rem;">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing here yet.', 'rm-church' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

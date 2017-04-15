<?php
/**
 * Template Name: Booking Request
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// REMOVE FILTER SO THAT TEXT AREA DOESN'T CONTAIN BR TAGS

remove_filter('the_content', 'wpautop');

add_filter('the_content', 'selective_wpautop');

function selective_wpautop($content) {
	if (get_the_title() == 'Booking Request') {
		return $content;
	} else {
		return wpautop($content);
	}
}

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
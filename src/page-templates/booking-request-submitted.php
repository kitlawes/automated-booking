<?php
/**
 * Template Name: Booking Request Submitted
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
			
			<?php
				echo "Test 2";
				$to = 'automatedbooking@gmail.com';
                $subject = 'The subject';
                $message = 'The email body content';
                $headers = array('Content-Type: text/html; charset=UTF-8');
				wp_mail($to, $subject, $message, $headers);
			?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
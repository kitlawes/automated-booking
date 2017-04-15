<?php
/**
 * Template Name: Booking Request Rejected
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
				
				$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
				if ($prev_url) {
					$prev_path = str_replace(home_url(), '', $prev_url);
					$page = get_page_by_path($prev_path);
					wp_delete_post($page->ID, true);
				}
				
				$to = $_POST['contact_email'];
                $subject = 'The Common House';
                $message = 'Your booking request has been rejected. You can make another booking request at https://automatedbooking.000webhostapp.com/index.php/book-the-space/.';
                $headers[] = 'From: The Common House <wordpress@automatedbooking.000webhostapp.com>';
				wp_mail($to, $subject, $message, $headers);
				
			?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
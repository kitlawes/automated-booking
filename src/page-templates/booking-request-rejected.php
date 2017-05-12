<?php
/**
 * Template Name: Booking Request Rejected
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
			
	<?php
		
		// DELETE BOOKING REQUEST PAGE
		
		$prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		if ($prev_url) {
			$prev_path = str_replace(home_url(), '', $prev_url);
			$page = get_page_by_path($prev_path);
			wp_delete_post($page->ID, true);
		}
		
		// EMAIL CONTACT EMAIL ADDRESS
		
		$to = $_POST['contact_email'];
		include 'booking_request_details.php';
		$subject = get_booking_request_booker_email_subject();
		$message = get_booking_request_rejected_booker_email_message();
		$headers[] = 'From: The Common House <wordpress@automatedbooking.000webhostapp.com>';
		wp_mail($to, $subject, $message, $headers);
		
	?>

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
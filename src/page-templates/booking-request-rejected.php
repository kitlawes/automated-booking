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
		$subject = 'The Common House';

		$message = 'Your booking request (see below) has been rejected. You can make another booking request at https://automatedbooking.000webhostapp.com/index.php/book-the-space/.

Name of group, project or organisation:
' . $_POST['group_name'] . '

Name of contact person:
' . $_POST['contact_person'] . '

Contact e-mail:
' . $_POST['contact_email'] . '

Contact phone number:
' . $_POST['contact_phone_number'] . '

How your project/group/… fits in with the ethos of the Common House*:
' . $_POST['project_fit'] . '

Type of booking (example: organising meeting, film screening, workshop, public meeting, closed meeting):
' . $_POST['booking_type'] . '

If the event is open to the public to attend please include an event title and blurb for the website/blog (if you are on Facebook and want to promote your event please tag Common House in it so it appears on our timeline):

Event title:
' . $_POST['event_title'] . '

Event blurb:
' . $_POST['event_blurb'] . '

Date of booking:
' . $_POST['booking_date'] . '

Start time (please include set-up time in your booking):
' . $_POST['start_time'] . '

End time (please include clean-up time in your booking):
' . $_POST['end_time'] . '

Do you plan to use the projector:
' . ($_POST['projector_use'] == 'on' ? 'Yes' : 'No') . '

*Please note that priority is given to groups/projects that don’t have access to other spaces (eg universities etc) and to those that do organising/campaigning/political work.
		';

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
<?php
/**
 * Template Name: Booking Request Accepted
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	
	<?php
		
		// DELETE BOOKING REQUEST PAGE
		
		$previous_url = $_POST['previous_url'];
		if ($previous_url) {
			$previous_path = str_replace(home_url(), '', $previous_url);
			$page = get_page_by_path($previous_path);
			wp_delete_post($page->ID, true);
		}
		
		// CREATE EVENT IN THE EVENTS CALENDAR
		
		$start_time = $_POST['start_time'];
		$start_hour = substr($start_time, 0, strrpos($start_time, ':'));
		$start_minute = substr($start_time, strrpos($start_time, ':') + 1, 2);
		$start_meridian = substr($start_time, strrpos($start_time, ' ') + 1, 2);
		
		$end_time = $_POST['end_time'];
		$end_hour = substr($end_time, 0, strrpos($end_time, ':'));
		$end_minute = substr($end_time, strrpos($end_time, ':') + 1, 2);
		$end_meridian = substr($end_time, strrpos($end_time, ' ') + 1, 2);
		
		$booking_date = substr($_POST['booking_date'], 6, 4) . '-' . substr($_POST['booking_date'], 3, 2) . '-' . substr($_POST['booking_date'], 0, 2);
		
		$args = array(
		   'post_title'			=> $_POST['event_title'],
		   'post_content'		=> $_POST['event_blurb'],
		   'post_status'		=> 'publish',
		   'post_author'		=> 1,
		   'EventStartDate'		=> $booking_date,
		   'EventEndDate'		=> $booking_date,
		   'EventStartHour'		=> $start_hour,
		   'EventStartMinute'	=> $start_minute,
		   'EventStartMeridian'	=> $start_meridian,
		   'EventEndHour'		=> $end_hour,
		   'EventEndMinute'		=> $end_minute,
		   'EventEndMeridian'	=> $end_meridian,
		   'Venue' => array(
				 'Venue'	=> 'Common House',
				 'Country'	=> 'United Kingdom',
				 'Address'	=> 'Unit E, 5 Pundersons Gardens, Bethnal Green, London, E29QG'
		   ),
		   'Organizer' => array(
			   'Organizer'	=> $_POST['group_name'],
			   'Email'		=> $_POST['contact_email']   
		   )
		);
		$event_id = tribe_create_event($args);
		
		$event_categories = get_terms(array(
				'taxonomy'		=> 'tribe_events_cat',
				'hide_empty'	=> false
			));
		foreach ($event_categories as &$event_category) {
			if ($event_category->slug == $_POST['booking_type']) {
				wp_set_post_terms($event_id, array($event_category->term_id), 'tribe_events_cat');
				break;
			}
		}
		
		// EMAIL CONTACT EMAIL ADDRESS
		
		$to = $_POST['contact_email'];
		$subject = 'The Common House';
		include 'booking_request_details.php';
		$subject = get_booking_request_booker_email_subject();
		$message = get_booking_request_accepted_booker_email_message();
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
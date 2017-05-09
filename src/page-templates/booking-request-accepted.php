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
		
		$booking_date = substr($_POST['booking_date'], 6, 4) . '-' . substr($_POST['booking_date'], 0, 2) . '-' . substr($_POST['booking_date'], 3, 2);
		
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

		$message = 'Your booking request (see below) has been accepted and added to the events calendar at https://automatedbooking.000webhostapp.com/whats-on/.

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
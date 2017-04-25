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
				
				// CREATE BOOKING REQUEST PAGE
				
				$post_content = '
<form class="booking_form" method="post">

	Name of group, project or organisation:<br />
	<input type="text" name="group_name" value="' . $_POST['group_name'] . '" readonly><br />
	<br />

	Name of contact person:<br />
	<input type="text" name="contact_person" value="' . $_POST['contact_person'] . '" readonly><br />
	<br />

	Contact e-mail:<br />
	<input type="text" name="contact_email" value="' . $_POST['contact_email'] . '" readonly><br />
	<br />

	Contact phone number:<br />
	<input type="text" name="contact_phone_number" value="' . $_POST['contact_phone_number'] . '" readonly><br />
	<br />

	How your project/group/… fits in with the ethos of the Common House*:<br />
	<textarea name="project_fit" rows="5" readonly>' . $_POST['project_fit'] . '</textarea><br />
	<br />

	Type of booking (example: organising meeting, film screening, workshop, public meeting, closed meeting):<br />
	<input type="text" name="booking_type" value="' . $_POST['booking_type'] . '" readonly><br />
	<br />

	If the event is open to the public to attend please include an event title and blurb for the website/blog (if you are on Facebook and want to promote your event please tag Common House in it so it appears on our timeline):<br />
	<br />

	Event title:<br />
	<input type="text" name="event_title" value="' . $_POST['event_title'] . '" readonly><br />
	<br />

	Event blurb:<br />
	<input type="text" name="event_blurb" value="' . $_POST['event_blurb'] . '" readonly><br />
	<br />

	Date of booking:<br />
	<input type="date" name="booking_date" value="' . $_POST['booking_date'] . '" readonly><br />
	<br />

	Start time (please include set-up time in your booking):<br />
	<input type="time" name="start_time" value="' . $_POST['start_time'] . '" readonly><br />
	<br />

	End time (please include clean-up time in your booking):<br />
	<input type="time" name="end_time" value="' . $_POST['end_time'] . '" readonly><br />
	<br />

	Do you plan to use the projector:<br />
	<input class="narrow_element" type="checkbox" name="projector_use" readonly' . ($_POST['projector_use'] == 'on' ? ' checked' : '') . '><br />
	<br />

	<button class="narrow_element" type="submit" formaction="/booking-request-accepted">Accept Booking Request</button>
	<button class="narrow_element" type="submit" formaction="/booking-request-rejected">Reject Booking Request</button>

</form>
<br />

*Please note that priority is given to groups/projects that don’t have access to other spaces (eg universities etc) and to those that do organising/campaigning/political work.
				';

				$post_data = array(
					'post_title'    => 'Booking Request',
					'post_content'  => $post_content,
					'post_status'   => 'publish',
					'post_type'     => 'page',
					'post_author'   => '1',
					'post_category' => array(1,2),
					'page_template' => 'page-templates/booking-request.php'
				);
				// Remove filters which remove <input> elements from the form
				remove_all_filters("content_save_pre");
				$new_page_id = wp_insert_post($post_data, $error_obj);
                
				// EMAIL CONTACT EMAIL ADDRESS
				
				$to = $_POST['contact_email'];
				$subject = 'The Common House';
				$message = 'Thank you for your booking request. You will receive an e-mail regarding acceptance of your booking request once it has been reviewed.';
				$headers[] = 'From: The Common House <wordpress@automatedbooking.000webhostapp.com>';
				wp_mail($to, $subject, $message, $headers);
                
				// EMAIL ADMIN EMAIL ADDRESS
				
				$to = 'automatedbooking@gmail.com';
				$subject = 'Booking Request';
				$message = 'A booking request has been made. The booking request can be accepted or rejected at ' . get_permalink($new_page_id) . '.';
				$headers[] = 'From: The Common House <wordpress@automatedbooking.000webhostapp.com>';
				wp_mail($to, $subject, $message, $headers);
				
			?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
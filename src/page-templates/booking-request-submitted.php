<?php
/**
 * Template Name: Booking Request Submitted
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	
	<?php
		
		// CREATE BOOKING REQUEST PAGE
		
		$post_content = '
<form id="booking_form" onsubmit="return validateBookingRequest()" method="post">

	Name of group, project or organisation:<br />
	<input type="text" name="group_name" value="' . $_POST['group_name'] . '"><br />
	<br />

	Name of contact person:<br />
	<input type="text" name="contact_person" value="' . $_POST['contact_person'] . '"><br />
	<br />

	Contact e-mail:<br />
	<input type="text" name="contact_email" value="' . $_POST['contact_email'] . '"><br />
	<br />

	Contact phone number:<br />
	<input type="text" name="contact_phone_number" value="' . $_POST['contact_phone_number'] . '"><br />
	<br />

	How your project/group/… fits in with the ethos of the Common House*:<br />
	<textarea name="project_fit" rows="5">' . $_POST['project_fit'] . '</textarea><br />
	<br />

	Type of booking (example: organising meeting, film screening, workshop, public meeting, closed meeting):<br />
	<select name="booking_type" >
		<option value="childrens-activity" ' . ($_POST['booking_type'] == 'childrens-activity' ? ' selected' : '') . '>children\'s activity</option>
		<option value="classes" ' . ($_POST['booking_type'] == 'classes' ? ' selected' : '') . '>classes</option>
		<option value="closed-event" ' . ($_POST['booking_type'] == 'closed-event' ? ' selected' : '') . '>closed event</option>
		<option value="common-house-meeting" ' . ($_POST['booking_type'] == 'common-house-meeting' ? ' selected' : '') . '>common house meeting</option>
		<option value="community-services" ' . ($_POST['booking_type'] == 'community-services' ? ' selected' : '') . '>community services</option>
		<option value="complementary-healthcare" ' . ($_POST['booking_type'] == 'complementary-healthcare' ? ' selected' : '') . '>complementary healthcare</option>
		<option value="film-screening" ' . ($_POST['booking_type'] == 'film-screening' ? ' selected' : '') . '>film screening</option>
		<option value="fundraiser" ' . ($_POST['booking_type'] == 'fundraiser' ? ' selected' : '') . '>fundraiser</option>
		<option value="organising-meeting" ' . ($_POST['booking_type'] == 'organising-meeting' ? ' selected' : '') . '>organising meeting</option>
		<option value="public-meeting" ' . ($_POST['booking_type'] == 'public-meeting' ? ' selected' : '') . '>public meeting</option>
		<option value="reading-group" ' . ($_POST['booking_type'] == 'reading-group' ? ' selected' : '') . '>reading group</option>
		<option value="social-event" ' . ($_POST['booking_type'] == 'social-event' ? ' selected' : '') . '>social event</option>
		<option value="workshop" ' . ($_POST['booking_type'] == 'workshop' ? ' selected' : '') . '>workshop</option>
	</select><br />
	<br />

	If the event is open to the public to attend please include an event title and blurb for the website/blog (if you are on Facebook and want to promote your event please tag Common House in it so it appears on our timeline):<br />
	<br />

	Event title:<br />
	<input type="text" name="event_title" value="' . $_POST['event_title'] . '"><br />
	<br />

	Event blurb:<br />
	<input type="text" name="event_blurb" value="' . $_POST['event_blurb'] . '"><br />
	<br />

	Date of booking:<br />
	<input class="datepicker" type="text" name="booking_date" value="' . $_POST['booking_date'] . '"><br />
	<br />

	Start time (please include set-up time in your booking):<br />
	<input class="timespinner" name="start_time" value="' . $_POST['start_time'] . '"><br />
	<br />

	End time (please include clean-up time in your booking):<br />
	<input class="timespinner" name="end_time" value="' . $_POST['end_time'] . '"><br />
	<br />

	Do you plan to use the projector:<br />
	<input class="narrow_element" type="checkbox" name="projector_use" ' . ($_POST['projector_use'] == 'on' ? ' checked' : '') . '><br />
	<br />

	Do you plan to have amplified sound:<br />
	<input class="narrow_element" type="checkbox" name="amplified_sound_use" ' . ($_POST['amplified_sound_use'] == 'on' ? ' checked' : '') . '><br />
	<br />

	<button class="narrow_element" type="submit" formaction="/process-booking-request-admin">Accept Booking Request</button>
	<button class="narrow_element" type="submit" formaction="/booking-request-rejected">Reject Booking Request</button>

</form>
<br />

*Please note that priority is given to groups/projects that don’t have access to other spaces (eg universities etc) and to those that do organising/campaigning/political work.
		';
		
		// Get unique booking request id from database
		global $wpdb;
		$table = $wpdb->prefix . "booking_request_count";
		$sql = "CREATE TABLE IF NOT EXISTS $table (`count` INTEGER)";
		$wpdb->query($sql);
		$count = $wpdb->get_results("SELECT * FROM $table;", OBJECT);
		if (empty($count)) {
			$wpdb->insert($table, array('count' => 0));
		}
		$count = $wpdb->get_results("SELECT * FROM $table;", OBJECT);
		$wpdb->update($table, array('count' => $count[0]->count + 1), array('count' => $count[0]->count));
		$count = $wpdb->get_results("SELECT * FROM $table;", OBJECT);
		$post_name = 'booking-request-' . $count[0]->count;
		
		$post_data = array(
			'post_title'    => 'Booking Request',
			'post_name'		=> $post_name,
			'post_content'  => $post_content,
			'post_status'   => 'publish',
			'post_type'     => 'page',
			'post_author'   => '1',
			'post_category' => array(1,2),
			'page_template' => 'page-templates/booking-request.php',
			'post_password' => 'CommonHouse123'
		);
		// Remove filters which remove <input> elements from the form
		remove_all_filters("content_save_pre");
		$new_page_id = wp_insert_post($post_data, $error_obj);
		
		include 'booking_request_email_content.php';
		
		// EMAIL CONTACT EMAIL ADDRESS
		
		$to = $_POST['contact_email'];
		$subject = get_booking_request_booker_email_subject();
		$message = get_booking_request_submitted_booker_email_message();
		$headers[] = 'From: The Common House <automatedbooking@gmail.com>';
		wp_mail($to, $subject, $message, $headers);
		
		// EMAIL ADMIN EMAIL ADDRESS
		
		$to = 'automatedbooking@gmail.com';
		$subject = get_booking_request_admin_email_subject();
		$message = get_booking_request_submitted_admin_email_message($new_page_id);
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
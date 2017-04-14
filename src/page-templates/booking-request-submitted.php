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
				
				$post_content = '
<form class="booking_form" action="booking-request-submitted" method="post">

	Name of group, project or organisation:<br />
	<input type="text" name="group_name" value="' . $_POST['group_name'] . '" readonly><br />
	<br />

	Name of contact person:<br />
	<input type="text" name="contact_person" value="' . $_POST['contact_person'] . '" readonly><br />
	<br />

	Contact phone number:<br />
	<input type="text" name="contact_phone_number" value="' . $_POST['contact_phone_number'] . '" readonly><br />
	<br />

	How your project/group/… fits in with the ethos of the Common House*:<br />
	<textarea name="project_fit" rows="5" readonly>' . $_POST['project_fit'] . '</textarea><br />
	<br />

	Type of booking (example: organising meeting, film screening, workshop, public meeting, closed meeting):<br />
	<select name="booking_type" disabled>
		<option value="childrens_activity"' . ($_POST['booking_type'] == 'childrens_activity' ? ' selected' : '') . '>childrens activity</option>
		<option value="classes"' . ($_POST['booking_type'] == 'classes' ? ' selected' : '') . '>classes</option>
		<option value="closed_event"' . ($_POST['booking_type'] == 'closed_event' ? ' selected' : '') . '>closed event</option>
		<option value="common_house_meeting"' . ($_POST['booking_type'] == 'common_house_meeting' ? ' selected' : '') . '>common house meeting</option>
		<option value="community_services"' . ($_POST['booking_type'] == 'community_services' ? ' selected' : '') . '>community services</option>
		<option value="complementary_healthcare"' . ($_POST['booking_type'] == 'complementary_healthcare' ? ' selected' : '') . '>complementary healthcare</option>
		<option value="film_screening"' . ($_POST['booking_type'] == 'film_screening' ? ' selected' : '') . '>film screening</option>
		<option value="fundraiser"' . ($_POST['booking_type'] == 'fundraiser' ? ' selected' : '') . '>fundraiser</option>
		<option value="organising_meeting"' . ($_POST['booking_type'] == 'organising_meeting' ? ' selected' : '') . '>organising meeting</option>
		<option value="public_meeting"' . ($_POST['booking_type'] == 'public_meeting' ? ' selected' : '') . '>public meeting</option>
		<option value="reading_group"' . ($_POST['booking_type'] == 'reading_group' ? ' selected' : '') . '>reading group</option>
		<option value="social_event"' . ($_POST['booking_type'] == 'social_event' ? ' selected' : '') . '>social event</option>
		<option value="workshop"' . ($_POST['booking_type'] == 'workshop' ? ' selected' : '') . '>workshop</option>
	</select><br />
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

	<input class="narrow_element" type="submit" value="Accept Booking Request">
	<input class="narrow_element" type="submit" value="Reject Booking Request">

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
				$new_page_id = wp_insert_post($post_data, $error_obj);
                
				$to = 'automatedbooking@gmail.com';
                $subject = 'The subject';
                $message = 'The email body content ' . get_permalink($new_page_id);
                $headers = array('Content-Type: text/html; charset=UTF-8');
				wp_mail($to, $subject, $message, $headers);
				
			?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * Template Name: Process Booking Request Admin
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// DOES BOOKING REQUEST CLASH WITH ANOTHER BOOKING IN THE CALENDAR?

$events = tribe_get_events(array(
	'start_date'   => $_POST['booking_date'] . ' ' . $_POST['start_time'],
	'end_date'     => $_POST['booking_date'] . ' ' . $_POST['end_time']
));

$submission_start_time = $_POST['start_time'];
$submission_start_hour = intval(substr($submission_start_time, 0, strrpos($submission_start_time, ':')));
$submission_start_minute = intval(substr($submission_start_time, strrpos($submission_start_time, ':') + 1, 2));
$submission_start_meridian = substr($submission_start_time, strrpos($submission_start_time, ' ') + 1, 2);
if ($submission_start_hour == 12) {
	$submission_start_hour = 0;
}
if ($submission_start_meridian == 'PM') {
	$submission_start_hour += 12;
}

$submission_end_time = $_POST['end_time'];
$submission_end_hour = intval(substr($submission_end_time, 0, strrpos($submission_end_time, ':')));
$submission_end_minute = intval(substr($submission_end_time, strrpos($submission_end_time, ':') + 1, 2));
$submission_end_meridian = substr($submission_end_time, strrpos($submission_end_time, ' ') + 1, 2);
if ($submission_end_hour == 12) {
	$submission_end_hour = 0;
}
if ($submission_end_meridian == 'PM') {
	$submission_end_hour += 12;
}

$calendar_clash = false;

foreach ($events as $event) {
	$event_start_hour = intval(tribe_get_start_date($event, false, $format = 'g'));
	$event_start_minute = intval(tribe_get_start_date($event, false, $format = 'i'));
	$event_end_hour = intval(tribe_get_end_date($event, false, $format = 'g'));
	$event_end_minute = intval(tribe_get_end_date($event, false, $format = 'i'));
	if (!($submission_end_hour == $event_start_hour && $submission_end_minute == $event_start_minute)
		&& !($submission_start_hour == $event_end_hour && $submission_start_minute == $event_end_minute)) {
		$calendar_clash = true;
		break;
	}
}

// REDIRECT TO RELEVANT PAGE IF BOOKING REQUEST CLASHES

if ($calendar_clash) {
	header("Location: " . get_site_url() . "/booking-request-clashes-admin");
	exit();
}

get_header(); ?>
	
	<!-- SUBMIT POST REQUEST CONTAINING FORM INPUT TO RELEVENT PAGE -->
	
	<form id="booking_form" action="/booking-request-accepted" method="post">
	<?php
	
		foreach ($_POST as $name => $value) {
			echo '<input type="hidden" name="' . htmlentities($name) . '" value="' . htmlentities($value) . '">';
		}
		
		$previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		echo '<input type="hidden" name="previous_url" value="' . $previous_url . '">';
		
	?>
	</form>
	<script type="text/javascript">
		document.getElementById('booking_form').submit();
	</script>
	
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
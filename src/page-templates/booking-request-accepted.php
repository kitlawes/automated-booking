<?php
/**
 * Template Name: Booking Request Accepted
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
				
				$args = array(
                   'post_title'			=> 'My post',
                   'post_content'		=> 'This is my post.',
                   'post_status'		=> 'publish',
                   'post_author'		=> 1,
                   'EventStartDate'		=> '2017-04-15',
                   'EventEndDate'		=> '2017-04-15',
                   'EventStartHour'		=> '2',
                   'EventStartMinute'	=> '29',
                   'EventStartMeridian'	=> 'pm',
                   'EventEndHour'		=> '4',
                   'EventEndMinute'		=> '20',
                   'EventEndMeridian'	=> 'pm',
                   'Venue' => array(
                         'Venue'	=> 'test',
                         'Country'	=> 'US',
                         'Address'	=> '1 W. Washington Ave.',
                         'City'		=> 'Madison',
                         'State'	=> 'WI'     
                   ),
                   'Organizer' => array(
                       'Organizer'	=> 'Jonah West',
                       'Email'		=> 'me@me.com'   
                   )
                );
				tribe_create_event($args);
                
				$to = $_POST['contact_email'];
                $subject = 'The Common House';
                $message = 'Your booking request has been accepted and added to the events calendar at https://automatedbooking.000webhostapp.com/whats-on/.';
                $headers[] = 'From: The Common House <wordpress@automatedbooking.000webhostapp.com>';
				wp_mail($to, $subject, $message, $headers);
				
			?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
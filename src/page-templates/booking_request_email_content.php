<?php

	function get_booking_request_booker_email_subject() {
		return 'The Common House - ' . $_POST['contact_person'] . ' - ' . $_POST['booking_date'] . ' - ' . $_POST['event_title'];
	}

	function get_booking_request_admin_email_subject() {
		return 'Booking Request - ' . $_POST['contact_person'] . ' - ' . $_POST['booking_date'] . ' - ' . $_POST['event_title'];
	}

	function get_booking_request_submitted_booker_email_message() {
		return 'Thank you for your booking request (see below). You will receive an e-mail regarding acceptance of your booking request once it has been reviewed.' . get_booking_request_details();
	}
	
	function get_booking_request_submitted_admin_email_message() {
		return 'A booking request has been made (see below). The booking request can be accepted or rejected at ' . get_permalink($new_page_id) . '.' . get_booking_request_details();
	}
	
	function get_booking_request_accepted_booker_email_message() {
		return 'Your booking request (see below) has been accepted and added to the events calendar at https://automatedbooking.000webhostapp.com/whats-on/.' . get_booking_request_details();
	}
	
	function get_booking_request_rejected_booker_email_message() {
		return 'Your booking request (see below) has been rejected. You can make another booking request at https://automatedbooking.000webhostapp.com/index.php/book-the-space/.' . get_booking_request_details();
	}

	function get_booking_request_details() {
		$booking_request_details = '

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

Do you plan to have amplified sound:
' . ($_POST['amplified_sound_use'] == 'on' ? 'Yes' : 'No') . '

*Please note that priority is given to groups/projects that don’t have access to other spaces (eg universities etc) and to those that do organising/campaigning/political work.
		';
		return $booking_request_details;
	}
	
?>
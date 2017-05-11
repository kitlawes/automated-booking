<?php
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

*Please note that priority is given to groups/projects that don’t have access to other spaces (eg universities etc) and to those that do organising/campaigning/political work.
		';
		return $booking_request_details;
	}
?>
jQuery(document).ready(function($) {
	$('.booking_form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13 && !$('.booking_form textarea').is(':focus')) { 
			e.preventDefault();
			return false;
		}
	});
});
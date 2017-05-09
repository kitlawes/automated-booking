jQuery(document).ready(function($) {
	$('#booking_form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13 && !$('#booking_form textarea').is(':focus')) { 
			e.preventDefault();
			return false;
		}
	});
});

function validateBookingRequest() {
    var bookingDate = document.getElementsByName("booking_date")[0].value;
	if (bookingDate.length != 10
		|| bookingDate.charAt(2) != "/"
		|| bookingDate.charAt(5) != "/"
		|| isNaN(Date.parse(bookingDate.substr(3, 2) + "/" + bookingDate.substr(0, 2) + "/" + bookingDate.substr(6, 4)))) {
        alert("The booking date field must contain a valid date with format DD/MM/YYYY.");
        return false;
	}
	/*
    var startTime = document.getElementsByName("startTime")[0].value;
	if (startTime.length == 10
		|| bookingDate.charAt(2) != "/"
		|| bookingDate.charAt(5) != "/"
		|| isNaN(Date.parse(bookingDate.substr(3, 2) + "/" + bookingDate.substr(0, 2) + "/" + bookingDate.substr(6, 4)))) {
        alert("The start time field must contain a valid time with a valid format (e.g. 10:30 AM).");
        return false;
    }
    var endTime = document.getElementsByName("endTime")[0].value;
    if (endTime == "") {
        alert("The end time is empty");
        return false;
    }
    */
}
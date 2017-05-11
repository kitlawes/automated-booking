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
    var startTime = document.getElementsByName("start_time")[0].value;
	if (startTime.length != 8
		|| isNaN(Number(startTime.substr(0, 2)))
		|| !(parseInt(startTime.substr(0, 2)) >= 1)
		|| !(parseInt(startTime.substr(0, 2)) <= 12)
		|| startTime.charAt(2) != ":"
		|| isNaN(Number(startTime.substr(3, 2)))
		|| !(parseInt(startTime.substr(3, 2)) >= 0)
		|| !(parseInt(startTime.substr(3, 2)) <= 59)
		|| startTime.charAt(5) != " "
		|| (startTime.substr(6, 2) != "AM"
		&& startTime.substr(6, 2) != "PM")) {
        alert("The start time field must contain a valid time with a valid format (e.g. 10:30 AM).");
        return false;
    }
    var endTime = document.getElementsByName("end_time")[0].value;
	if (endTime.length != 8
		|| isNaN(Number(startTime.substr(0, 2)))
		|| !(parseInt(endTime.substr(0, 2)) >= 1)
		|| !(parseInt(endTime.substr(0, 2)) <= 12)
		|| endTime.charAt(2) != ":"
		|| isNaN(Number(startTime.substr(3, 2)))
		|| !(parseInt(endTime.substr(3, 2)) >= 0)
		|| !(parseInt(endTime.substr(3, 2)) <= 59)
		|| endTime.charAt(5) != " "
		|| (endTime.substr(6, 2) != "AM"
		&& endTime.substr(6, 2) != "PM")) {
        alert("The end time field must contain a valid time with a valid format (e.g. 10:30 AM).");
        return false;
    }
}
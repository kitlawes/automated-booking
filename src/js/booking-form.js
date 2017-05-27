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
	if (!startTime.includes(":")
		|| startTime.length != startTime.indexOf(":") + 6
		|| isNaN(Number(startTime.substr(0, startTime.indexOf(":"))))
		|| !(parseInt(startTime.substr(0, startTime.indexOf(":"))) >= 1)
		|| !(parseInt(startTime.substr(0, startTime.indexOf(":"))) <= 12)
		|| startTime.charAt(0) == "0"
		|| isNaN(Number(startTime.substr(startTime.indexOf(":") + 1, 2)))
		|| !(parseInt(startTime.substr(startTime.indexOf(":") + 1, 2)) >= 0)
		|| !(parseInt(startTime.substr(startTime.indexOf(":") + 1, 2)) <= 59)
		|| startTime.charAt(startTime.indexOf(":") + 3) != " "
		|| !(startTime.substr(startTime.indexOf(" ") + 1, 2) == "AM"
		|| startTime.substr(startTime.indexOf(" ") + 1, 2) == "PM")) {
        alert("The start time field must contain a valid time with a valid format (e.g. 10:30 AM).");
        return false;
    }
    
    var endTime = document.getElementsByName("end_time")[0].value;
	if (!endTime.includes(":")
		|| endTime.length != endTime.indexOf(":") + 6
		|| isNaN(Number(endTime.substr(0, endTime.indexOf(":"))))
		|| !(parseInt(endTime.substr(0, endTime.indexOf(":"))) >= 1)
		|| !(parseInt(endTime.substr(0, endTime.indexOf(":"))) <= 12)
		|| endTime.charAt(0) == "0"
		|| isNaN(Number(endTime.substr(endTime.indexOf(":") + 1, 2)))
		|| !(parseInt(endTime.substr(endTime.indexOf(":") + 1, 2)) >= 0)
		|| !(parseInt(endTime.substr(endTime.indexOf(":") + 1, 2)) <= 59)
		|| endTime.charAt(endTime.indexOf(":") + 3) != " "
		|| !(endTime.substr(endTime.indexOf(" ") + 1, 2) == "AM"
		|| endTime.substr(endTime.indexOf(" ") + 1, 2) == "PM")) {
        alert("The end time field must contain a valid time with a valid format (e.g. 10:30 AM).");
        return false;
    }
	
	if (startTime.substr(startTime.indexOf(" ") + 1, 2) == "PM"
		&& endTime.substr(endTime.indexOf(" ") + 1, 2) == "AM"
		|| startTime.substr(startTime.indexOf(" ") + 1, 2) == endTime.substr(endTime.indexOf(" ") + 1, 2)
		&& (parseInt(startTime.substr(0, startTime.indexOf(":"))) % 12 > parseInt(endTime.substr(0, endTime.indexOf(":"))) % 12
		|| parseInt(startTime.substr(0, startTime.indexOf(":"))) == parseInt(endTime.substr(0, endTime.indexOf(":")))
		&& parseInt(startTime.substr(startTime.indexOf(":") + 1, 2)) >= parseInt(endTime.substr(endTime.indexOf(":") + 1, 2)))) {
        alert("The event start time must be before the event end time.");
        return false;
    }
    
}
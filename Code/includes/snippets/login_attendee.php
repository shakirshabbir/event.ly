<?php

$attendeeRefCode = $_POST['attendeeRefCode'];

$invitee = Invitee::getAttendeeInfoByRefCode($attendeeRefCode);

if ($invitee!=null) {
	$location = 'attendee.php?attendeeRefCode='. $invitee->attendeeRefCode . '&attendeeId=' . $invitee->attendeeId;
	echo '<script> location.replace("'.$location.'"); </script>';
	die();			
}
else{
	$attendeeLoginFailed = true;
}

?>
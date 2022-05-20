<?php
	$thisUser = null;
	
	if(!isset($_SESSION)) session_start();
	
	/* If user is not logged in, redirect the user to homepage */
	if (!isset($_SESSION['userLoggedInStatus'])) {
			header( 'Location: index.php' );
	}
	
	/* If user is logged in, get user details */
	if (isset($_SESSION['userLoggedInStatus']) && $_SESSION['userLoggedInStatus'] == true) {
		$thisUser = User::getUser( $_SESSION['userEmailAddress'] );
		if ( $thisUser == null ) header( 'Location: index.php' );
		if ( !$thisUser->authenticateEventModifier($eventId) )
			header('Location: error.php?errorMsg=You are not authorized to modify this event!');
	}
?>
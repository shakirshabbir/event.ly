<?php
	$thisUser = null;
	
	if(!isset($_SESSION)) session_start();
	
	/* If user is not logged in, redirect the user to homepage */
	if (!isset($_SESSION['userLoggedInStatus'])) {
			header( 'Location: index.php' );
	}
	
	/* If user is logged in, get user details and make sure its a client becuase we are dealing with the client page */
	if (isset($_SESSION['userLoggedInStatus']) && $_SESSION['userLoggedInStatus'] == true) {
		$thisUser = User::getUser( $_SESSION['userEmailAddress'] );
		if ( $thisUser != null && $thisUser->usertypeId != 1 ) //$thisUser->usertypeId should be equals 1 for it to be an admin
			header( 'Location: index.php' );
	}
?>
<?php
	$thisUser = null;
	
	if(!isset($_SESSION)) session_start();
	
	/* If user is logged in, get user details and make sure its a client becuase we are dealing with the client page */
	if (isset($_SESSION['userLoggedInStatus']) && $_SESSION['userLoggedInStatus'] == true) {
		$thisUser = User::getUser( $_SESSION['userEmailAddress'] );
	}
?>
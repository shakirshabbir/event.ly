<?php
	$thisUser = null;
	
	if(!isset($_SESSION)) session_start();
	
	/* If user is not logged in, redirect the user to homepage */
	if (!isset($_SESSION['userLoggedInStatus'])) {
		//header( 'Location: index.php' );
		echo '<script> location.replace("index.php"); </script>';
		die();						
	}
	
	/* If user is logged in, get user details and make sure its a client becuase we are dealing with the client page */
	if (isset($_SESSION['userLoggedInStatus']) && $_SESSION['userLoggedInStatus'] == true) {
		$thisUser = User::getUser( $_SESSION['userEmailAddress'] );
		//if ( $thisUser != null && $thisUser->usertypeId != 2 ) //$thisUser->usertypeId should be equals 2 for it to be a client\
		//We allow all users to get to this page but the admin user
		//if ( $thisUser != null && $thisUser->usertypeId == 1 )
		if ( $thisUser == null ){
			//header( 'Location: index.php' );
			echo '<script> location.replace("index.php"); </script>';
			die();									
		}
	}
?>
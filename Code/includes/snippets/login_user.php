<?php
$clientEmailAddress = $_POST['clientEmailAddress'];
$clientPassword = $_POST['clientPassword'];

$user = new User($clientEmailAddress, $clientPassword);
$isValidUser = $user->authenticate($errorMessage);

if ($isValidUser && ( $user->usertypeId == 1 || $user->usertypeId == 2 || $user->usertypeId == 3 || $user->usertypeId == 4 ) ) {
	//Initiate a session
	if(!isset($_SESSION)) session_start();
	$_SESSION['userLoggedInStatus'] = true;
	$_SESSION['userType'] = $user->userType;
	$_SESSION['userEmailAddress'] = $user->userEmailAddress;
	$_SESSION['userLoginStartTime'] = time();
	if ( $user->usertypeId == 1 )
		//Redirect to the admin page
		//exit(header( 'Location: admin.php' ));
		echo '<script> location.replace("admin.php"); </script>';
		
	else 
		//Redirect to the client page
		//exit(header( 'Location: client.php' ));
		echo '<script> location.replace("client.php"); </script>';
}
else
	//exit(header( 'Location: index.php?authFailed=1#client' ));
	echo '<script> location.replace("index.php?authFailed=1#client"); </script>';
?>
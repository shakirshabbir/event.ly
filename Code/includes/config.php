<?php

/*
session_start(); 
$session_id = session_id();
ob_start();
*/

/*@error_reporting(0);
@ini_set('error_reporting', 0);
@ini_set('display_errors', 'Off');*/

define('DBHOST', 'localhost');
define('DB', 'evently');
define('DBUSER', 'root');
define('DBPASSWORD', '');

try {
	$conn = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo 'Connection Failed: ' . $e->getMessage();
	header( 'Location: error.php' );
}

?>
<?php

require_once ('./includes/config.php');
require_once ('user.php');

class EventOwners{
	
	public $eventId;
	public $ownerId;	
	
	public function __construct(){
		return new EventOwners();
	}
	
	public static function addEventOwner($eventId, $ownerId){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$string = "INSERT INTO event_owners(eventId, ownerId)";
		$string.= "VALUES(";
		$string.= $eventId . ",";
		$string.= $ownerId . "";		
		$string.= ")";		
		
		$query = $db->exec($string);
		if($query>0)
			return $query;
		else
			header('Location: error.php?errorMsg='. urlencode($db->errorInfo()[2]));
			
		return -1;
	}
	
	public static function getEventOwner($eventId){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$string = "SELECT ownerId FROM event_owners WHERE eventId=".$eventId;
		$query = $db->query($string);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			$row = $results[0];
			$ownerId = $row['ownerId'];
			$owner = User::getUser('', $ownerId);
			return $owner;
		}		

		return null;
	}	
}

?>
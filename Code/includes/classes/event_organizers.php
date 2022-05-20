<?php

require_once ('./includes/config.php');

class EventOrganizers{
	
	public $eventId;
	public $organizerId;	
	
	public function __construct(){
		return new EventOrganizers();
	}
	
	public static function addEventOrganizer($eventId, $organizerId){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$string = "INSERT INTO event_organizers(eventId, organizerId)";
		$string.= "VALUES(";
		$string.= $eventId . ",";
		$string.= $organizerId . "";		
		$string.= ")";		
		
		$query = $db->exec($string);
		if($query>0)
			return $query;
		else
			header('Location: error.php?errorMsg='. urlencode($db->errorInfo()[2]));
			
		return -1;
	}
	
	public static function updateEventOrganizer($eventId, $organizerId, &$errorMessage){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{

			$string = "INSERT IGNORE INTO event_organizers(eventId, organizerId)";					
			$string.= "VALUES(";
			$string.= $eventId . ",";
			$string.= $organizerId . "";		
			$string.= ")";							
			$query = $db->exec($string);
		
			$string = "UPDATE event_organizers";
			$string.= " SET organizerId = ".$organizerId ."";
			$string.= " WHERE eventId = ".$eventId ."";
			
			$query = $db->exec($string);
			if ($query !== false){
				if ($query == 0) $query=1;
			} 
		}				
		catch ( Exception $e ) {
			$query = -1;
			$errorMessage = $e->getMessage();
		}
			return $query;
	}	
	
	public static function deleteEventOrganizer($eventId, &$errorMessage){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$db->beginTransaction();

				$st = $db->prepare('DELETE FROM event_organizers WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();			
				
			$db->commit();				
			
			return true;
		}				
		catch ( Exception $e ) {
			$db->rollback();
			$errorMessage = $e->getMessage();
		}
			return false;
	}		
	
	public static function getOrganizersList($ownerId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
			//$queryString.= 'SELECT * FROM vu_client_organizers';
			$queryString.= 'SELECT * FROM vu_organizer_info';
		if ($ownerId != 0)
			$queryString.= ' WHERE ownerId = '.$ownerId;
			//$queryString.= ' GROUP BY organizerId ORDER BY organizerName ASC';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}
	
	/*
	public static function getOrganizersListByEventId($eventId){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
			$queryString.= 'SELECT * FROM vu_client_organizers';
			$queryString.= ' WHERE clientId = (SELECT ownerId FROM event_owners WHERE eventId='.$eventId.')';
			$queryString.= ' GROUP BY organizerId ORDER BY organizerName ASC';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}*/
	
}

?>
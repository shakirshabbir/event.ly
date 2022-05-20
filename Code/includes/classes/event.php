<?php

require_once ('./includes/config.php');

class Event{
	
	public $eventId;
	public $eventTitle;	
	public $eventStartTime;
	public $eventEndTime;
	public $eventLocation;
	public $eventDetails;
	
	public $eventDate;
	public $ownerName;
	public $ownerId;
	public $ownerContactNumber;
	public $organizerName;
	public $organizerId;		
	public $organizerContactNumber;
	
	public function __construct(){
		$this->eventStartTime = date('Y-m-d G:i:s');
		$this->eventEndTime = date('Y-m-d G:i:s');
	}
	
	public function addEvent(&$lastInsertedId, &$errorMessage){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try{
			$string = "INSERT INTO events(eventTitle, eventStartTime, eventEndTime, eventLocation, eventDetails)";
			$string.= "VALUES(";
			$string.= "'". addslashes($this->eventTitle) . "',";
			$string.= "'". $this->eventStartTime . "',";
			$string.= "'". $this->eventEndTime . "',";		
			$string.= "'". addslashes($this->eventLocation) . "',";
			$string.= "'". addslashes($this->eventDetails) . "'";	
			$string.= ")";		
			
			$query = $db->exec($string);
			if($query>0){
				$lastInsertedId = $db->lastInsertId();
			}
		}
		catch ( Exception $e ) {
			$query = -1;
			if ( $e->getCode() == 23000 )
			$errorMessage = "Event with title: ".addslashes($this->eventTitle). " already exists!";
			else
			$errorMessage = $e->getMessage();
		}
			return $query;
	}	
	
	public function updateEvent(&$lastUpdatedId, &$errorMessage){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$db->beginTransaction();
			
			$string = "UPDATE events";
			$string.= " SET";
			$string.= "  eventTitle = '". addslashes($this->eventTitle) . "'";
			$string.= " ,eventStartTime = '". $this->eventStartTime . "'";
			$string.= " ,eventEndTime = '". $this->eventEndTime . "'";		
			$string.= " ,eventLocation = '". addslashes($this->eventLocation) . "'";
			$string.= " ,eventDetails = '". addslashes($this->eventDetails) . "'";
			$string.= " WHERE eventId = ". $this->eventId . "";
			
			$query = $db->exec($string);
			if ($query !== false) {
				if ($query == 0) { $query = 1; }
			}
			$db->commit();		
		}
		catch ( Exception $e ) {
			$db->rollback();
			$query = -1;
			if ( $e->getCode() == 23000 )
			$errorMessage = "Event with title: ".addslashes($this->eventTitle). " already exists!";
			else
			throw $e;
		}
			return $query;
	}
	
	public static function deleteEvent($eventId, &$errorMessage=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{			
			$db->beginTransaction();
			
				$st = $db->prepare('DELETE FROM event_owners WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();
				//$st->execute( array(':eventId', $eventId) );
				
				$st = $db->prepare('DELETE FROM event_organizers WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM invitations WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM checkins WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM events WHERE eventId = :eventId');
				$st->bindValue( ":eventId", $eventId, PDO::PARAM_INT );
				$st->execute();
				
			$db->commit();				
			
			return true;
		}
		catch ( Exception $e ) {
			$db->rollback();
		
			$errorMessage = $e->getMessage();
				
			$errorMessage = $errorMessage."<br />Unable to delete this event!";
			$location = "error.php?errorMsg=".urlencode($errorMessage);
			
			echo '<script> location.replace("'.$location.'"); </script>';
		}
		
			return false;
	}	
	
	public static function getEventInfo($eventId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		

		$queryString = "";
		$queryString.= "
						SELECT
							e.eventId
							,eventTitle
							,DATE_FORMAT(eventStartTime, '%m/%d/%Y') as eventDate
							,DATE_FORMAT(eventStartTime, '%h:%i %p') as eventStartTime
							,DATE_FORMAT(eventEndTime,   '%h:%i %p') as eventEndTime
							,eventLocation
							,eventDetails
							,CONCAT(owner.userLname, ', ', owner.userFname) AS ownerName, eOWNs.ownerId
							,owner.userContactNumber AS ownerContactNumber
							,owner.usertypeId AS ownerUserTypeId
							,ownerUsertype.usertype AS ownerUserType
							,IFNULL(CONCAT(organizer.userLname, ', ', organizer.userFname),'Unassigned') AS organizerName, organizer.userId AS organizerId 
							,organizer.userContactNumber AS organizerContactNumber
						FROM events e
						JOIN event_owners eOWNs 
							ON e.eventId = eOWNs.eventId
						LEFT JOIN event_organizers eORGs
							ON e.eventId = eORGs.eventId
						JOIN users owner
							ON owner.userId = eOWNs.ownerId
						JOIN user_types ownerUsertype
							ON ownerUsertype.usertypeId = owner.usertypeId
						LEFT JOIN users organizer 
							ON organizer.userId = eORGs.organizerId		
		";
		if ($eventId != 0)
		$queryString.= " WHERE e.eventId = ".$eventId."";		
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			$row = $results[0];

			return $row;
		}
		else
			return null;		
	}
	
	public static function getEventInfoById($eventId){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		$queryString = '';
		$queryString.= ' SELECT * FROM vu_event_info';
		$queryString.= ' WHERE eventId = '.$eventId;
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			$row = $results[0];
			
			$event = new Event();
			
			$event->eventId = $row['eventId'];
			$event->eventTitle = $row['eventTitle'];
			$event->eventStartTime = $row['eventStartTime'];
			$event->eventEndTime = $row['eventEndTime'];
			$event->eventLocation = $row['eventLocation'];
			$event->eventDetails = $row['eventDetails'];
			
			$event->eventDate = $row['eventDate'];
			$event->ownerName = $row['ownerName'];
			$event->ownerId = $row['ownerId'];
			$event->ownerContactNumber = $row['ownerContactNumber'];
			$event->organizerName = $row['organizerName'];
			$event->organizerId = $row['organizerId'];		
			$event->organizerContactNumber = $row['organizerContactNumber'];			
			
			return $event;
		}
		else
			return null;	
	}

	public static function getEventsForOwner($ownerId=0){
		try{
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		$queryString = '';
		$queryString.= 'SELECT * FROM vu_event_info';
		if ($ownerId != 0)
			$queryString.= ' WHERE ownerId = '.$ownerId;
		$queryString.= ' ORDER BY eventDate DESC, eventStartTime DESC';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
		}
		catch(Exception $e){
			$errorMessage = $e->getMessage();
			$errorMessage = $errorMessage."<br />Unable to fetch events for owner!";
			$location = "error.php?errorMsg=".urlencode($errorMessage);
			exit(header($location));
			return null;
		}
	}
	
	public static function getEventsForOrganizer($organizerId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
			$queryString.= 'SELECT * FROM vu_event_info';
		if ($organizerId != 0)
			$queryString.= ' WHERE organizerId = '.$organizerId;
			$queryString.= ' ORDER BY eventDate DESC, eventStartTime DESC';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

}

?>
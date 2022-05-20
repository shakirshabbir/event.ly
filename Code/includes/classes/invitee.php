<?php

require_once ('./includes/config.php');
require_once ('./includes/functions/rand_code_gen.php');
require_once ('./includes/functions/email_functions.php');
require_once ('./includes/classes/event.php');

class Invitee{
	
	public $eventId;
	public $hostUserId;
	public $attendeeId;
	public $attendeeRefCode;
	public $attendeeName;
	public $attendeeEmailAddress;
	public $attendeeResponse;
	public $additionalNote;	
	public $invitationSentDate;
	
	public function __construct($attendeeResponse='INV'){
		$this->attendeeResponse = $attendeeResponse;
		date_default_timezone_set('America/Chicago');	//date("Y-m-d H:i:s");
		$this->invitationSentDate = date("Y-m-d H:i:s");
	}
	
	public function insertInvitee($sendEmail, &$errorMessage=''){	
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$string = "INSERT INTO invitations(";
		$string.= "eventId, hostUserId,"; 
		$string.= "attendeeRefCode, ";
		$string.= "attendeeName, ";		
		$string.= "attendeeEmailAddress, attendeeResponse, additionalNote, invitationSentDate)";
		$string.= " VALUES(";
		$string.= $this->eventId . ",";
		$string.= $this->hostUserId . ",";
		$string.= "'". $this->attendeeRefCode . "',";		
		$string.= "'". addslashes($this->attendeeName) . "',";				
		$string.= "'". addslashes($this->attendeeEmailAddress) . "',";		
		$string.= "'". $this->attendeeResponse . "',";
		$string.= "'". addslashes($this->additionalNote) ."',";
		$string.= "'". $this->invitationSentDate . "'";				
		$string.= ")";

		$query = $db->exec($string);
		if($query>0) {
			$this->attendeeId = $db->lastInsertId();
			if ($sendEmail)
				$this->sendInvite();
			return $query;
		}
		else {
			//header( 'Location: error.php?errorMsg=' . urlencode("Unable to process this invitees!") );
			echo '<script> location.replace("error.php?errorMsg=' . urlencode("Unable to process this invitees!").'"); </script>';
			die();			
		}

		return -1;
	}
	
	public static function deleteInvitee($inviteeId, &$errorMessage=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{			
			$db->beginTransaction();
				
				$st = $db->prepare('DELETE FROM checkins WHERE attendeeId = :inviteeId');
				$st->bindValue( ":inviteeId", $inviteeId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM invitations WHERE attendeeId = :inviteeId');
				$st->bindValue( ":inviteeId", $inviteeId, PDO::PARAM_INT );
				$st->execute();
				
			$db->commit();				
			
			return true;
		}
		catch ( Exception $e ) {
			$db->rollback();
		
			$errorMessage = $e->getMessage();
				
			$errorMessage = $errorMessage."<br />Unable to delete this invitee!";
			$location = "error.php?errorMsg=".urlencode($errorMessage);
			
			//echo '<script> location.replace("'.$location.'"); </script>';
			//die(header('Location: '.$location));
			header('Location: '.$location);
		}
		
			return false;
	}			
	
	public function sendInvite(){
        $name = $this->attendeeName;
		$email = $this->attendeeEmailAddress;
		
		$event = Event::getEventInfoById($this->eventId);
		if ( isset($event) && $event!=null)
		$eventName = $event->eventTitle;
        
        $body = get_email_body($this, $event);		
		
		$sent = send_email("noreply@event.ly", "Evently - Invitation", $this->attendeeEmailAddress, $this->attendeeName, $event->eventTitle, $body, "");
		if($sent)
			return true;
		else
			return false;		
	}
	
	public static function getAttendeeInfo($attendeeId, $attendeeRefCode=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT * FROM invitations';
		//if ($attendeeRefCode=='')
		//$queryString.= ' WHERE attendeeRefCode=\''.$attendeeRefCode.'\'';
		//else
		$queryString.= ' WHERE attendeeId='.$attendeeId.'';
		$query = $db->query($queryString);
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ($query->rowCount() > 0){
			
			$invitee = new Invitee();
			
			$invitee->eventId = $row['eventId'];
			$invitee->hostUserId = $row['hostUserId'];
			$invitee->attendeeId = $row['attendeeId'];
			$invitee->attendeeRefCode = $row['attendeeRefCode'];
			$invitee->attendeeName = $row['attendeeName'];
			$invitee->attendeeEmailAddress = $row['attendeeEmailAddress'];
			$invitee->attendeeResponse = $row['attendeeResponse'];
			$invitee->additionalNote = $row['additionalNote'];		
			$invitee->invitationSentDate = $row['invitationSentDate'];					
			
			return $invitee;
		}
		else
			return null;	
	}
	
	public static function getAttendeeInfoByRefCode($attendeeRefCode){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT * FROM invitations';
		$queryString.= " WHERE attendeeRefCode='{$attendeeRefCode}'";
		$query = $db->query($queryString);
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ($query->rowCount() > 0){
			
			$invitee = new Invitee();
			
			$invitee->eventId = $row['eventId'];
			$invitee->hostUserId = $row['hostUserId'];
			$invitee->attendeeId = $row['attendeeId'];
			$invitee->attendeeRefCode = $row['attendeeRefCode'];
			$invitee->attendeeName = $row['attendeeName'];
			$invitee->attendeeEmailAddress = $row['attendeeEmailAddress'];
			$invitee->attendeeResponse = $row['attendeeResponse'];
			$invitee->additionalNote = $row['additionalNote'];		
			$invitee->invitationSentDate = $row['invitationSentDate'];					
			
			return $invitee;
		}
		else
			return null;	
	}	
	
	public static function getAllAttendees(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT * FROM invitations';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			return $results;
		}
		else
			return null;
	}
	
	public static function getAttendeeCheckins($attendeeId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.eventId';
		$queryString.= ' 	,vu.eventTitle';		
		$queryString.= ' 	,vu.ownerId';				
		$queryString.= ' 	,vu.organizerId';		
		$queryString.= ' 	,vu.attendeeId';
		$queryString.= ' 	,vu.attendeeRefCode';
		$queryString.= ' 	,vu.attendeeName';	
		$queryString.= ' 	,vu.attendeeEmailAddress';	
		$queryString.= ' 	,vu.invitationStatus';	
		$queryString.= ' 	,DATE_FORMAT(vu.checkInTime, \'%h:%i %p\') AS checkInTime';			
		$queryString.= ' 	,vu.checkInStatus';
		$queryString.= ' FROM vu_attendee_checkins vu';
		
		if ($attendeeId!=0)
		$queryString.= ' WHERE vu.attendeeId='.$attendeeId.'';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			return $results;
		}
		else
			return null;
	}	

	public static function getEventCheckins($eventId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.eventId';
		$queryString.= ' 	,vu.eventTitle';		
		$queryString.= ' 	,vu.ownerId';				
		$queryString.= ' 	,vu.organizerId';		
		$queryString.= ' 	,vu.attendeeId';
		$queryString.= ' 	,vu.attendeeRefCode';
		$queryString.= ' 	,vu.attendeeName';	
		$queryString.= ' 	,vu.attendeeEmailAddress';	
		$queryString.= ' 	,vu.invitationStatus';	
		$queryString.= ' 	,DATE_FORMAT(vu.checkInTime, \'%h:%i %p\') AS checkInTime';			
		$queryString.= ' 	,vu.checkInStatus';
		$queryString.= ' FROM vu_attendee_checkins vu';
		
		if ($eventId!=0)
		$queryString.= ' WHERE vu.eventId='.$eventId.'';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			return $results;
		}
		else
			return null;
	}	

	public static function getUserCheckins($userId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.eventId';		
		$queryString.= ' 	,vu.eventTitle';		
		$queryString.= ' 	,vu.ownerId';				
		$queryString.= ' 	,vu.organizerId';		
		$queryString.= ' 	,vu.attendeeId';
		$queryString.= ' 	,vu.attendeeRefCode';
		$queryString.= ' 	,vu.attendeeName';	
		$queryString.= ' 	,vu.attendeeEmailAddress';	
		$queryString.= ' 	,vu.invitationStatus';	
		$queryString.= ' 	,DATE_FORMAT(vu.checkInTime, \'%h:%i %p\') AS checkInTime';			
		$queryString.= ' 	,vu.checkInStatus';
		$queryString.= ' FROM vu_attendee_checkins vu';
		
		if ($userId!=0)
		$queryString.= ' WHERE vu.ownerId='.$userId.' OR vu.organizerId='.$userId.'';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($results) > 0){
			return $results;
		}
		else
			return null;
	}		
	
	public function checkInAttendee($checkInTime, &$errorMessage=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$query = -1;
			
			$string = "INSERT INTO checkins";
			$string.= "(";
			$string.= "	 eventId";			
			$string.= "	,attendeeId";						
			$string.= "	,checkInTime";									
			$string.= ")";
			$string.= "VALUES(";	
			$string.= "".$this->eventId."";			
			$string.= ",".$this->attendeeId."";			
			$string.= ",'".$checkInTime."'";
			$string.= ")";			
			
			$query = $db->exec($string);
			if ($query !== false) {
				if ($query == 0) { $query = 1; }
			}
		}
		catch ( Exception $e ) {
			if ($e instanceof PDOException){
				//$errorMessage = $db->errorInfo()[2];
				//$errorMessage = $db->errorInfo();
				$errorMessage = $e->getMessage();
				//throw new Exception ($db->errorInfo()[2]);
				throw new Exception ($e->getMessage());
			}
			else{
				$errorMessage = $e->getMessage();
				throw new Exception ($e->getMessage());
			}
		}

			return $query;
	}		
	
	public function updateResponse(&$errorMessage=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$string = "UPDATE invitations";
			$string.= " SET";
			$string.= "  attendeeResponse = '". $this->attendeeResponse . "'";
			$string.= " WHERE attendeeId = ". $this->attendeeId . "";
			
			$query = $db->exec($string);
			if ($query !== false) {
				if ($query == 0) { $query = 1; }
			}
		}
		catch ( Exception $e ) {
			$query = -1;
			if ($e instanceof PDOException)
				$errorMessage = $db->errorInfo()[2];
			else
				$errorMessage = $e->getMessage();
		}

			return $query;

	}	
	
	public function generateAttendeeId(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$query = $db->query('SELECT * FROM invitations ORDER BY attendeeId DESC');
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			if (isset($row))
				$lastGeneratedAttendeeId = $row['attendeeRefCode'];
	
			if(isset($lastGeneratedAttendeeId)){
				$newGeneratedAttendeeId = strtoupper(get_rand_id(10));
				while($newGeneratedAttendeeId==$lastGeneratedAttendeeId){
					$newGeneratedAttendeeId = strtoupper(get_rand_id(10));
				}
			}
			else{
				$newGeneratedAttendeeId = strtoupper(get_rand_id(10));
			}
		}
		catch (Exception $e) {
			throw $e;
		}
		
		return $newGeneratedAttendeeId;
	}	
}

?>
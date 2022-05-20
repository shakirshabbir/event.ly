<?php

include_once ('./includes/config.php');

class Statistics{
	
	public $timeNow;

	public function __construct(){
		date_default_timezone_set('America/Chicago');	//date("Y-m-d H:i:s");
		$this->timeNow = date("Y-m-d H:i:s");
	}

	public static function getCompanyEventsStatistics(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.ownerLname';
		$queryString.= ' 	,vu.ownerFname';		
		$queryString.= ' 	,vu.ownerName';				
		$queryString.= ' 	,vu.ownerId';		
		$queryString.= ' 	,vu.ownerUserTypeId';
		$queryString.= ' 	,vu.ownerUserType';
		$queryString.= ' 	,vu.eventCount';	
		$queryString.= ' FROM vu_client_event_statistics vu';
			
		$queryString.= ' WHERE vu.ownerUserTypeId=2'; //For an company client

		$queryString.= ' ORDER BY vu.eventCount DESC';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public static function getIndividualEventsStatistics(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.ownerLname';
		$queryString.= ' 	,vu.ownerFname';		
		$queryString.= ' 	,vu.ownerName';				
		$queryString.= ' 	,vu.ownerId';		
		$queryString.= ' 	,vu.ownerUserTypeId';
		$queryString.= ' 	,vu.ownerUserType';
		$queryString.= ' 	,vu.eventCount';	
		$queryString.= ' FROM vu_client_event_statistics vu';
		
		$queryString.= ' WHERE vu.ownerUserTypeId=4'; //For an individual client
		
		$queryString.= ' ORDER BY vu.eventCount DESC';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}	
	
	public static function getOrganizerEventsStatistics(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	
		$queryString = '';
		$queryString.= ' SELECT';
		$queryString.= ' 	 vu.organizerLname';
		$queryString.= ' 	,vu.organizerFname';		
		$queryString.= ' 	,vu.organizerName';				
		$queryString.= ' 	,vu.organizerId';		
		$queryString.= ' 	,vu.organizerUserTypeId';
		$queryString.= ' 	,vu.organizerUserType';
		$queryString.= ' 	,vu.eventCount';	
		$queryString.= ' FROM vu_organizer_event_statistics vu';
		
		$queryString.= ' WHERE vu.organizerUserTypeId=3'; //For an organizer, because it also includes individuals
		
		$queryString.= ' ORDER BY vu.eventCount DESC';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public static function getUserTypeStatistics(){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	
		$queryString = '
						SELECT
							 user_types.usertype
							,COUNT(users.userId) AS usertypeCount 
						FROM users
						JOIN user_types
						ON user_types.usertypeId = users.usertypeId
						WHERE users.usertypeId <> 1
						GROUP BY users.usertypeId		
		';
		
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}		
	
	public static function getAttendeeCount($eventId=0){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
		$queryString = '';
		$queryString.= 'SELECT * FROM vu_event_attendee_count';
		if ($eventId != 0)
			$queryString.= ' WHERE eventId = '.$eventId;
		$queryString.= ' ORDER BY attendeeCount DESC';
		$query = $db->query($queryString);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}		
	
}

?>
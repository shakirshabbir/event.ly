<?php

require_once ('./includes/config.php');

class User{
	
	public $userId;
	public $usertypeId;
	public $userEmailAddress;
	public $userPassword;
	public $userFname;
	public $userLname;	
	public $userFullName;		
	public $userContactNumber;
	public $userParentId;
	
	public $userType;	
	public $userOwnerId;		
	public $userOwnerName;			
	
	public function __construct($userEmailAddress='', $userPassword=''){
		$this->userEmailAddress = $userEmailAddress;
		$this->userPassword = $userPassword;
	}
	
	public function authenticate(&$errorMessage){	
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$query = $db->query('SELECT * FROM vu_user_full_info WHERE userEmailAddress="'.$this->userEmailAddress.'" AND userPassword="'.$this->userPassword.'"');		
			$row = $query->fetch(PDO::FETCH_ASSOC);
			if ($query->rowCount() > 0){
				$this->userId = $row['userId'];
				$this->usertypeId = $row['usertypeId'];
				$this->userParentId = $row['userParentId'];
				$this->userEmailAddress = $row['userEmailAddress'];
				$this->userFname = $row['userFname'];		
				$this->userLname = $row['userLname'];
				$this->userFullName = $row['userFullName'];
				$this->userContactNumber = $row['userContactNumber'];		
				
				$this->userOwnerId = $row['ownerId'];
				$this->userOwnerName = $row['ownerName'];
				$this->userType = $row['usertype'];
			
				return true;
			}
			else{
				return false;
			}
		}
		catch (Exception $e) {
			header('Location: error.php?errorMsg='. urlencode($e->getMessage())); die();
		}		
	}
	
	public static function getAllUsers($usertypeId=0, $errorMessage=''){	
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		
		try {
				$queryString = 'SELECT * FROM vu_user_full_info WHERE usertypeId!=1';
			if ($usertypeId!=0)
				$queryString.= ' AND usertypeId='.$usertypeId;
			
			$query = $db->query($queryString);
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
			if ($query->rowCount() > 0){
				return $results;
			}
		}
		catch (Exception $e) {
			$errorMessage = $e->getMessage();
				
			$errorMessage = $errorMessage."<br />Unable to fetch users!";
			$location = "error.php?errorMsg=".urlencode($errorMessage);
			
			//echo '<script> location.replace("'.$location.'"); </script>';
			//die(header('Location: '.$location));
			//header('Location: '.$location);
		}
			return null;		//no results
	}

	public static function getUserTypes(){	
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		try {
			$query = $db->query('SELECT * FROM user_types WHERE usertypeId NOT IN(1,3,5)');
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
			if ($query->rowCount() > 0){
				return $results;
			}
			else{
				return null;
			}
		}
		catch (Exception $e) {
			header('Location: error.php?errorMsg='. urlencode($e->getMessage())); die();
		}		
	}		
	
	public static function getUser($userEmailAddress, $userId=-1){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if ($userId==-1)
		$query = $db->query('SELECT * FROM vu_user_full_info WHERE userEmailAddress="'. $userEmailAddress. '"');
		else
		$query = $db->query('SELECT * FROM vu_user_full_info WHERE userId="'. $userId. '"');
		
		$results = $query->fetchAll(PDO::FETCH_ASSOC);		
		
		if (count($results) > 0){
			$row = $results[0];
			$user = new User();
			
			$user->userId = $row['userId'];
			$user->usertypeId = $row['usertypeId'];
			$user->userParentId = $row['userParentId'];
			$user->userEmailAddress = $row['userEmailAddress'];
			$user->userFname = $row['userFname'];		
			$user->userLname = $row['userLname'];
			$user->userFullName = $row['userFullName'];
			$user->userContactNumber = $row['userContactNumber'];		
			
			$user->userOwnerId = $row['ownerId'];
			$user->userOwnerName = $row['ownerName'];
			$user->userType = $row['usertype'];
			
			return $user;
		}
		else
			return null;		
	}	
	
	public function createNewUser($userEmailAddress, $userPassword, $userFname, $userLname, $userContactNumber, $userParentId, $usertypeId=3, &$errorMessage=''){	

		$this->userEmailAddress = $userEmailAddress;
		$this->userPassword = $userPassword;
		$this->userFname = $userFname;
		$this->userLname = $userLname;
		$this->userContactNumber = $userContactNumber;
		$this->usertypeId = $usertypeId;
		$this->userParentId = $userParentId;

		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			$string = "INSERT INTO users(userEmailAddress, userPassword, userFname, userLname, userContactNumber, usertypeId, userParentId) ";
			$string.= "VALUES(";
			$string.= "'". $this->userEmailAddress . "',";
			$string.= "'". $this->userPassword . "',";		
			$string.= "'". $this->userFname . "',";
			$string.= "'". $this->userLname . "',";		
			$string.= "'". $this->userContactNumber . "',";				
			$string.= "". $this->usertypeId . ",";				
			$string.= "". $this->userParentId . "";						
			$string.= ")";

			$query = $db->exec($string);
			if($query>0){
				$newUser = User::getUser($userEmailAddress);
					return $newUser;
			}
		}
		catch ( Exception $e ) {
			if ( $e->getCode() == 23000 )
			$errorMessage = "User with email address: <strong>".$this->userEmailAddress. "</strong> already exists!";
			else
			throw $e;
		}
			return null;
	}
	
	public function authenticateEventModifier($eventId){
		if ( $this->usertypeId == 1 ){
			return true;
		}
		
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $db->query('SELECT * FROM vu_event_info WHERE eventId='. $eventId);
		
		$results = $query->fetchAll(PDO::FETCH_ASSOC);		
		
		if (count($results) > 0){
			$row = $results[0];
			if ( $this->userId == $row['ownerId'] ) { 
				//$this->userType = "OWNER"; 
				return true; 
			}
			else if ( $this->userId == $row['organizerId'] ) { 
				//$this->userType = "ORGANIZER"; 
				return true; 
			}
			else return false;
		}

		return false;
	}
	
	public static function deleteUser($userId, &$errorMessage=''){
		$db = new PDO('mysql:host='.DBHOST.';dbname='.DB.'', DBUSER, DBPASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{			
			$db->beginTransaction();

				$st = $db->prepare('DELETE FROM invitations WHERE eventId IN ( SELECT eventId FROM event_owners WHERE ownerId = :userId )');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM checkins WHERE eventId IN (SELECT eventId FROM event_owners WHERE ownerId = :userId)');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM events WHERE eventId IN (SELECT eventId FROM event_owners WHERE ownerId = :userId)');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();

				$st = $db->prepare('DELETE FROM event_owners WHERE ownerId = :userId');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();
				
				$st = $db->prepare('DELETE FROM event_organizers WHERE organizerId = :userId');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();				
				
				$st = $db->prepare('DELETE FROM event_organizers WHERE organizerId IN (SELECT userId FROM users WHERE userParentId = :userId)');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();				
				
				//$st = $db->prepare('DELETE FROM users WHERE userId IN (SELECT userId FROM users WHERE userParentId = :userId)');
				//You cannot do above statement
				//Ref: http://stackoverflow.com/questions/4429319/you-cant-specify-target-table-for-update-in-from-clause
				$st = $db->prepare('DELETE FROM users WHERE userId IN (SELECT t.userId FROM (SELECT userId FROM users WHERE userParentId = :userId) AS t)');				
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();	
				
				$st = $db->prepare('DELETE FROM users WHERE userId = :userId');
				$st->bindValue( ":userId", $userId, PDO::PARAM_INT );
				$st->execute();
				
			$db->commit();				
			
			return true;
		}
		catch ( Exception $e ) {
			$db->rollback();
		
			$errorMessage = $e->getMessage();
				
			$errorMessage = $errorMessage."<br />Unable to delete this user!";
			$location = "error.php?errorMsg=".urlencode($errorMessage);
			
			echo '<script> location.replace("'.$location.'"); </script>';
		}
			return false;
	}		
}

?>
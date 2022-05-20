<?php
	$checkinSubmitSuccess = false;
	$errorMessageLog = "";	
	
	if ( isset($_POST['checkinSubmit']) )
	{
		$checkInSubmitFailed = false;
		
		if (isset($_POST['checkins'])){
			$checkins = $_POST['checkins'];
			if (count($checkins) > 0) {
				try{
					foreach($checkins as $attendeeId) {
					
						$attendee = Invitee::getAttendeeInfo($attendeeId);
						date_default_timezone_set('America/Chicago');
						$checkInTime = date("Y-m-d H:i:s");
													
						//if ( $attendee->checkInAttendee($checkInTime, $errorMessage) > 0 ) $checkinSubmitSuccess=true;
						//else
						//header( 'Location: error.php?errorMsg=1' . urlencode($errorMessage."<br />Unable to process checkins!") );
						
						$attendee->checkInAttendee($checkInTime);	//, $errorMessage);
					}
					$checkinSubmitSuccess = true;
				}
				catch ( Exception $e ) {
					$checkInSubmitFailed = true;
					$errorMessageLog .= "".$e->getMessage()."<br />";
				}				
			}
		}
		
		if ($checkInSubmitFailed){
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessageLog. "<br /><br />Unable to process checkins!") );
		}
		else{	//Checkins were successful
			unset($_POST['checkinSubmit']);
		}

	}
?>
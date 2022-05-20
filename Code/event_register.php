<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/check_loggedin_client.php');	?>
<?php
		$adminAccess = false;
		if (isset($_REQUEST['userId'])){
			//If this request was from admin then its a valid request otherwise unauthorized access
			if ($thisUser!=null && $thisUser->usertypeId==1){
				$adminAccess = true;
				$adminAccessUser = User::getUser( "", $_REQUEST['userId'] );
			}else{
				//exit(header( 'Location: error.php?errorMsg=' . urlencode("Unauthorized access!<br />Only registered users can access this page!") ));
				$location = 'error.php?errorMsg=' . urlencode("Unauthorized access!<br />Only registered users can access this page!");
				echo '<script> location.replace("'.$location.'"); </script>';
				die();				
			}
		}
?>
<?php
	if (!$adminAccess && $thisUser!=null && $thisUser->usertypeId==1) {
		//exit( header( 'Location: admin.php' )	);	
		$location = 'admin.php';
		echo '<script> location.replace("'.$location.'"); </script>';
		die();						
	}
?>
<?php	require_once ('./includes/classes/event.php');	?>
<?php	require_once ('./includes/classes/event_organizers.php');	?>
<?php	require_once ('./includes/classes/event_owners.php');	?>
<?php
	$eventInsertSuccess = false;
	$eventOwnerInsertSuccess = false;		
	$eventOrganizerInsertSuccess = false;
	$duplicateEventFailed = false;
	
	if ( isset($_POST['eventRegisterFormSubmit']) )
	{
		//echo "<script>alert('eventRegisterFormSubmit POSTED');</script>";
		$event = new Event();
		
		date_default_timezone_set('America/Chicago');	//date("Y-m-d H:i:s");
			
		$event->eventTitle = $_POST['eventTitle'];	
		$event->eventDate = $_POST['eventDate'];
		$event->eventStartTime = date("Y-m-d H:i:s", strtotime($event->eventDate . ' ' .$_POST['eventStartTime']));
		$event->eventEndTime = date("Y-m-d H:i:s", strtotime($event->eventDate . ' ' .$_POST['eventEndTime']));		
		$event->eventLocation = $_POST['eventLocation'];
		$event->eventType = isset($_POST['eventType']) ? $_POST['eventType'] : "Onsite";
		$event->eventDetails = $_POST['eventDetails'];
		
		$eventOwnerId = $_POST['eventOwnerId'];
		$eventOrganizerId = $_POST['eventOrganizerId'];	
		
		$resultCount = 0;
		$errorMessage = '';
		try { 
			$resultCount = $event->addEvent($lastInsertedId, $errorMessage);
		}
		catch(Exception $e){
			//header( 'Location: error.php?errorMsg=' . urlencode($errorMessage ."<br />Unable to add this new event!") );
			$location = 'error.php?errorMsg=' . urlencode($errorMessage ."<br />Unable to add this new event!");
			echo '<script> location.replace("'.$location.'"); </script>';
			die();						
		}
		
		if ( $resultCount > 0 ) 		$eventInsertSuccess = true;
		else if($errorMessage != ''){
			$duplicateEventFailed = true;
			$duplicateEventFailedErrorMessage = $errorMessage;
		}		
	
		if ($eventInsertSuccess) {
			$errorMessage = '';
			if ( EventOwners::addEventOwner($lastInsertedId, $eventOwnerId) > 0 ) $eventOwnerInsertSuccess = true;
			else{
				//header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. " ; "."\n".$event->eventTitle." added but unable to assign owner!"));
				$location = 'error.php?errorMsg=' . urlencode($errorMessage. " ; "."<br />".$event->eventTitle." added but unable to assign owner!");
				echo '<script> location.replace("'.$location.'"); </script>';
				die();									
			}
			if ( $eventOrganizerId != -1 ) {//In case of no company organizers, I have sent a negative 1 value.. If not negative 1, then insert organizer too.
				$errorMessage = '';
				if ( EventOrganizers::addEventOrganizer($lastInsertedId, $eventOrganizerId) > 0 ) $eventOrganizerInsertSuccess = true;
				else{
					//header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. " ; "."<br />".$event->eventTitle." added but unable to assign organizer!"));
					$location = 'error.php?errorMsg=' . urlencode($errorMessage. " ; "."<br />".$event->eventTitle." added but unable to assign organizer!");
					echo '<script> location.replace("'.$location.'"); </script>';
					die();													
				}			
			}
		}
	}
?>

<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li><a href="attendee.php">Attendee</a></li>
	<li class="active"><a href="client.php">Client</a></li>
	<li><a href="event.php">Events</a></li>	
	<li><a href="index.php#contact">Contact</a></li>
	</ul>';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<?php	require_once ('./includes/head_info.php');	?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <div class="site-main" id="sTop">
            <div class="site-header">
				<?php	require_once ('./includes/site_header.php');	?>            
			</div> <!-- /.site-header -->
        </div> <!-- /.site-main -->
	
        <div class="content-section level-2-pages" id="our-team">
            <div class="container">
				<?php	include_once ('./includes/sections/user_buttons.php');	?>			
				<div class="row">					
					<div class="heading-section text-center">
						<p>
							<h2 class="tableCaptionHeadingLarger">Add <?php echo ($eventInsertSuccess ? 'another' : ''); ?> Event</h2>					
						</p>					
					<?php if ($adminAccess) { ?>
						<p>
							Admin user adding event for 
							  <b>
								<a style="text-transform: none;">
									<?php echo $adminAccessUser->userType; ?>
								</a>
							  </b> 
							  
							  user 
							  
							  <b>
								  <a href="client.php?userId=<?php echo $adminAccessUser->userId?>">
									<?php echo $adminAccessUser->userFullName; ?>
								  </a>
							  </b>
						</p>
					<?php } ?>					
					
					<?php if ($eventInsertSuccess) { ?>
					
							<p>
								<strong style="color:green;">Event Added:&nbsp;
								<a style="color:green;" href="./event.php?eventId=<?php echo $lastInsertedId ;?>">
									<?php echo $event->eventTitle ;?>
								</a></strong>
							</p>
						
					<?php } ?>
					
					<?php if ($duplicateEventFailed) { ?>
					
							<p>
								<strong style="color:red;">Event Insertion Failed!&nbsp;</strong><br />
								<a><u><?php echo $duplicateEventFailedErrorMessage; ?></u></a>
							</p>						

					<?php } ?>									
					
					</div>									
				</div> <!-- /.row -->
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->		
		
        <div class="content-section level-2-pages-rest" id="our-team">
            <div class="container">
                <div class="row">

					
					<div class="col-md-4 col-sm-6">
					
					</div>
					
					<div class="col-md-4 col-sm-6">
				
						<div class="contact-form" id="eventRegisterFormDiv">
							<form name="eventRegisterForm" id="eventRegisterForm" method="post" action="">
								<p>
									<label for="eventTitle">Event Title</label>								
									<input name="eventTitle" id="eventTitle" type="text" placeholder="Event Title" required />
								</p>
								<p>
									<label for="eventTitle">Event Date</label>								
									<input name="eventDate" id="eventDate" type="text" placeholder="MM/DD/YYYY" required />
								</p>		
								<p>
									<label for="eventTitle">Event Start Time</label>						
									<input name="eventStartTime" class="time" id="eventStartTime" type="text" placeholder="HH:MM AM/PM" required />
								</p>
								<p>
									<label for="eventTitle">Event End Time</label>								
									<input name="eventEndTime" class="time" id="eventEndTime" type="text" placeholder="HH:MM AM/PM" required />
								</p>																					
								<p>
									<label for="eventTitle">Event Location</label>								
									<input name="eventLocation" id="eventLocation" type="text" placeholder="Location" required />
								</p>
								<?php
									$thisEventUser = $adminAccess ? $adminAccessUser : $thisUser;
									if ($thisEventUser->usertypeId == 3 ) //$thisEventUser IS ORGANIZER
									{
										echo '<input name="eventOwnerId" id="eventOwnerId" type="hidden" value="'.$thisEventUser->userParentId.'" />';
										echo '<input name="eventOrganizerId" id="eventOrganizerId" type="hidden" value="'.$thisEventUser->userId.'" />';										
									}
									else if ($thisEventUser->usertypeId == 4 ) //$thisEventUser IS INDIVIDUAL
									{
										//INDIVIDUAL is event owner as well as organizer
										echo '<input name="eventOwnerId" id="eventOwnerId" type="hidden" value="'.$thisEventUser->userId.'" />';
										echo '<input name="eventOrganizerId" id="eventOrganizerId" type="hidden" value="'.$thisEventUser->userId.'" />';										
									}
									else if ($thisEventUser->usertypeId == 2 ) //$thisEventUser IS COMPANY
									{
										//Define event owner as company
										echo '<input name="eventOwnerId" id="eventOwnerId" type="hidden" value="'.$thisEventUser->userId.'" />';
										
										//Now find organizers
										$resultsEventOrganizers = EventOrganizers::getOrganizersList($thisEventUser->userId);

										if (count($resultsEventOrganizers) <= 0){
											// No organizers found for this company
											echo '<input name="eventOrganizerId" id="eventOrganizerId" type="hidden" value="-1" />';
											echo '<p>';
											echo '<label>No organizers! Event will be unassigned for now!</label>';
											echo '</p><br />';
										} else {
											echo '<p>';
											echo '<label for="eventOrganizerId">Event Organizer</label>';
											echo '<select name="eventOrganizerId" id="eventOrganizerId">';
											echo '<option value="-1">Unassign</option>';											
												foreach($resultsEventOrganizers as $organizer) {
													echo '<option value="'.$organizer['organizerId'].'"';
													echo '>'.$organizer['organizerName'].'</option>';
												}
											echo '</select>';
											echo '</p>';									
										}										
									}
								?>								
								<p>
									<label for="eventTitle">Event Details</label>								
									<textarea name="eventDetails" id="eventDetails" placeholder="Event Details"></textarea>    			
								</p>
								<input name="eventRegisterFormSubmit" id="eventRegisterFormSubmit" type="submit" class="mainBtn" value="Submit" />
							</form>
						</div> <!-- /.contact-form -->
					</div> <!-- /.col-md-4 -->
					
					<div class="col-md-4 col-sm-6">
					
					</div>					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
           
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>				
			<?php	require_once ('includes/date_time_controls_script.php');	?>
        
    </body>
</html>
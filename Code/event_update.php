<?php	require_once ('./includes/classes/event.php');	?>
<?php	require_once ('./includes/classes/event_organizers.php');	?>
<?php	require_once ('./includes/classes/event_owners.php');	?>
<?php	require_once ('./includes/classes/user.php');	?>

<?php
	$eventId = isset($_REQUEST['eventId']) ? $_REQUEST['eventId'] : 0;
	if ( isset($eventId) && $eventId != 0){
		//$row = Event::getEventInfo($eventId);
		$event = Event::getEventInfoById($eventId);
		if ($event == null){
			//header( 'Location: error.php?errorMsg=' . urlencode("No event found!") );
			$location = 'error.php?errorMsg=' .urlencode("<br />No event found!");
			echo '<script> location.replace("'.$location.'"); </script>';
			die();							
		}
	}
	
	require_once ('./includes/snippets/check_loggedin_event_modifiers.php');
	
	$retainStartTimeAMPM = $event->eventStartTime;
	$retainEndTimeAMPM = $event->eventEndTime;
?>

<?php
		$adminAccess = false;
		if ($thisUser!=null && $thisUser->usertypeId==1){
			$adminAccess = true;		
			$adminAccessUser = User::getUser( "", $event->ownerId );
		}
?>

<?php
	$eventUpdateSuccess = false;
	$duplicateEventFailed = false;
	
	if ( isset($_POST['eventUpdateFormSubmit']) )
	{
		$retainStartTimeAMPM = $_POST['eventStartTime'];
		$retainEndTimeAMPM = $_POST['eventEndTime'];		
		
		$event = new Event();
		
		$event->eventId = $_POST['eventId'];
		$event->eventTitle = $_POST['eventTitle'];
		$event->eventDate = $_POST['eventDate'];
		$event->eventStartTime = date("Y-m-d H:i:s", strtotime($event->eventDate . ' ' .$_POST['eventStartTime']));
		$event->eventEndTime = date("Y-m-d H:i:s", strtotime($event->eventDate . ' ' .$_POST['eventEndTime']));
		$event->eventLocation = $_POST['eventLocation'];
		$event->eventType = isset($_POST['eventType']) ? $_POST['eventType'] : "Onsite";
		$event->eventDetails = $_POST['eventDetails'];

		$eventOrganizerId = $_POST['eventOrganizerId'];	
		$event->organizerId = $eventOrganizerId;
		
		$resultCount = 0;
		$errorMessage = '';
		try { 
			$resultCount = $event->updateEvent($lastUpdatedId, $errorMessage); 
		}
		catch(Exception $e){
			//exit ( header( 'Location: error.php?errorMsg=' . urlencode($e->getMessage(). "<br />Unable to update the event!") ) );
			$location = 'error.php?errorMsg=' . urlencode($e->getMessage(). "<br />Unable to update the event!");
			echo '<script> location.replace("'.$location.'"); </script>';
			die();					
		}
		
		if ( $resultCount > 0 ) 		$eventUpdateSuccess = true;		
		else if($errorMessage != ''){
			$duplicateEventFailed = true;
			$duplicateEventFailedErrorMessage = $errorMessage;
		}
			
		if ($eventUpdateSuccess) {  
			if ($eventOrganizerId == -1) {
				$errorMessage = '';
				if ( EventOrganizers::deleteEventOrganizer($event->eventId, $errorMessage) ) $eventOrganizerUpdateSuccess = true;
				else{
					//exit(header( 'Location: error.php?errorMsg=' .urlencode($errorMessage ."<br />".$event->eventTitle." updated but unable to update organizer!")));
					$location = 'error.php?errorMsg=' .urlencode($errorMessage ."<br />".$event->eventTitle." updated but unable to update organizer!");
					echo '<script> location.replace("'.$location.'"); </script>';
					die();				
				}
			} else if ($eventOrganizerId != -1) {
				$errorMessage = '';
				if ( EventOrganizers::updateEventOrganizer($event->eventId, $eventOrganizerId, $errorMessage) > 0 ) $eventOrganizerUpdateSuccess = true;
				else{
					//exit(header( 'Location: error.php?errorMsg=' .urlencode($errorMessage ."<br />".$event->eventTitle." updated but unable to update organizer!")));
					$location = 'error.php?errorMsg=' .urlencode($errorMessage ."<br />".$event->eventTitle." updated but unable to update organizer!");
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
							<h2 class="tableCaptionHeadingLarger">Update Event</h2>
						</p>									
						<?php /*if ($row['organizerId'] == $row['ownerId']) { ?>
							<!-- if (ownerId && organizerId are same) then just display client, otherwise diplay owner seperate and organizer seperate-->
							<p>OWNER: <?php echo $row['ownerName'] ;?></p>
							<?php } else { ?>
							<p>OWNER: <?php echo $row['ownerName'] ;?></p>						
							<p>ORGANIZER: <?php echo $row['organizerName']; ?></p>
						<?php }*/?>													

						<?php if ($adminAccess) { ?>
							<p>
								Admin user editing event&nbsp;

								<b>
								  <a href="event.php?eventId=<?php echo $eventId; ?>">
									<?php echo $event->eventTitle; ?>
								  </a>
								</b>
								
							</p>
						<?php } ?>					

						<?php if ($eventUpdateSuccess) { ?>
						
								<p>
									<strong style="color:green;">Event Updated:&nbsp;
									<a style="color:green;" href="./event.php?eventId=<?php echo $eventId ;?>">
										<?php echo $event->eventTitle ;?>
									</a></strong>
								</p>
							
						<?php } ?>	
					
						<?php if ($duplicateEventFailed) { ?>
						
								<p>
									<strong style="color:red;">Event Update Failed!&nbsp;</strong><br />
									<a><u><?php echo $duplicateEventFailedErrorMessage; ?></u></a>
								</p>						

						<?php } ?>										
					</div>
				</div>
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->		

        <div class="content-section level-2-pages-rest" id="our-team">
            <div class="container">
				<div class="row">		

					<div class="col-md-4 col-sm-6">
					
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="contact-form">
							<form name="eventUpdateForm" id="eventUpdateForm" method="post" action="">
								<p>
									<label for="eventTitle">Event Title</label>
									<input name="eventTitle" id="eventTitle" type="text" placeholder="Event Title" value="<?php echo $event->eventTitle; ?>" required />
								</p>
								<p>
									<label for="eventTitle">Event Date</label>
									<input name="eventDate" id="eventDate" type="text" placeholder="Date" value="<?php echo $event->eventDate; ?>" required />
								</p>		
								<p>
									<label for="eventTitle">Event Start Time</label>
									<input name="eventStartTime" id="eventStartTime" type="text" placeholder="Start Time" value="<?php echo $retainStartTimeAMPM; ?>" required />
								</p>
								<p>
									<label for="eventTitle">Event End Time</label>
									<input name="eventEndTime" id="eventEndTime" type="text" placeholder="End Time" value="<?php echo $retainEndTimeAMPM; ?>" required />
								</p>																					
								<p>
									<label for="eventTitle">Event Location</label>
									<input name="eventLocation" id="eventLocation" type="text" placeholder="Location" value="<?php echo $event->eventLocation; ?>"required />
								</p>
								<?php
									$thisEventUser = $adminAccess ? $adminAccessUser : $thisUser;
									if ($thisEventUser->usertypeId == 3 || $thisEventUser->usertypeId == 4)
									{
										echo '<input name="eventOrganizerId" id="eventOrganizerId" type="hidden" value="-1" />'; //-1 Means Organizer update is not allowed
									}
									else if ($thisEventUser->usertypeId == 2) {
									
										$resultsEventOrganizers = EventOrganizers::getOrganizersList($thisEventUser->userId);

										if (count($resultsEventOrganizers) <= 0){
											//Self Assigned
											echo '<input name="eventOrganizerId" id="eventOrganizerId" type="hidden" value="-1" />';
											echo '<p>';
											echo '<label>No organizers! Event will remain unassigned for now!</label>';
											echo '</p><br />';
										} else {
											echo '<p>';
											echo '<label for="eventOrganizerId">Event Organizer</label>';
											echo '<select name="eventOrganizerId" id="eventOrganizerId">';
											echo '<option value="-1">Unassign</option>';
												foreach($resultsEventOrganizers as $organizer) {
													echo '<option value="'.$organizer['organizerId'].'"';
													if ( $event->organizerId == $organizer['organizerId']) echo ' selected="selected"';
													echo '>'.$organizer['organizerName'].'</option>';
												}
											echo '</select>';
											echo '</p>';									
										}
									}
								?>
								<p>
									<label for="eventTitle">Event Details</label>
									<textarea name="eventDetails" id="eventDetails" placeholder="Event Details"><?php echo nl2br($event->eventDetails); ?></textarea>    			
								</p>
									<input name="eventId" id="eventId" type="hidden" value="<?php echo $eventId; ?>" />
								<input name="eventUpdateFormSubmit" id="eventUpdateFormSubmit" type="submit" class="mainBtn" value="Submit" />
							</form>
						</div> <!-- /.contact-form -->
					</div>
					<div class="col-md-4 col-sm-6">
					
					</div>					
				</div>
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->		
           
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>
			<?php	require_once ('includes/date_time_controls_script.php');	?>			
        
    </body>
</html>
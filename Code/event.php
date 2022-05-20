<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/get_loggedin_user.php');	?>

<?php	require_once ('./includes/classes/invitee.php');	?>
<?php	require_once ('./includes/classes/event.php');	?>

<?php
	$event = null;
	if (isset($_REQUEST['eventId'])){
		$eventId = $_REQUEST['eventId'];
		$event = Event::getEventInfoById($eventId);
		
		if ($event == null)
		header( 'Location: error.php?errorMsg=' . urlencode("No event found!") );
	}
?>

<?php	require_once ('./includes/snippets/checkins/process_checkins.php');	?>

<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li><a href="attendee.php">Attendee</a></li>
	<li><a href="client.php">Client</a></li>
	<li class="active"><a href="event.php">Events</a></li>
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
	    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>		
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
							
		
		<?php if( isset($event) && $event != null ) { ?>
		<div class="content-section" id="attendee">
            <div class="container">
                <div class="row">
					<div class="col-md-3">
					
					</div>
					<div class="col-md-6">				
						<div class="heading-section text-center">
							<h2><?php echo $event->eventTitle; ?></h2>
						<div class="heading-section text-left">
							<p>&nbsp;</p>
							<p><label>When:</label> <?php echo $event->eventDate;?></p>
							<p><label>Where:</label> <?php echo $event->eventLocation;?></p>							
							<p><label>Start:</label> <?php echo $event->eventStartTime;?></p>
							<p><label>End:</label> <?php echo $event->eventEndTime;?></p>
							<p><label>Details:</label> <?php echo nl2br($event->eventDetails);?></p>
							<p><label>OWNER:</label> <?php echo $event->ownerName;?> | <?php echo $event->ownerContactNumber;?></p>							
							<!--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $event->ownerContactNumber;?></p>-->
							<?php if ( $event->ownerId != $event->organizerId ) { ?>
							<p><label>ORGANIZER:</label> <?php echo $event->organizerName;?> | <?php echo $event->organizerContactNumber;?></p>
							<!--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $event->organizerContactNumber;?></p>-->
							<?php } ?>
						</div>
						</div>
					</div>
					<div class="col-md-3 text-right">
						<?php if ( $thisUser!=null && $thisUser->authenticateEventModifier($event->eventId) ) { ?>
						<!--<form name="editEventForm" method="post" action="event_update.php?eventId=<?php echo $event->eventId; ?>">
							<p><input name="editEventFormSubmit" id="editEventFormSubmit" type="submit" class="mainBtn" value="Edit"></p>
						</form>-->
						<?php } ?>
					</div>					
				</div>

				<?php if ($thisUser!=null && $thisUser->authenticateEventModifier($event->eventId) ) {?>
				<div class="row">
                    <div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
					<div class="col-md-4 col-sm-6">
                        <div class="contact-form">
							<form name="editEventForm" method="post" action="event_update.php?eventId=<?php echo $event->eventId; ?>">
								<p><input name="editEventFormSubmit" id="editEventFormSubmit" type="submit" class="mainBtn" value="Edit this event"></p>
							</form>							
							<form method="post" action="./invite.php" >
                                <input type="hidden" name="invitationEventId" id="invitationEventId" value="<?php echo $event->eventId; ?>" />
								<input type="hidden" name="hostUserId" id="hostUserId" value="<?php echo $thisUser->userId; ?>" />
								<input name="invitationFormSubmit" id="invitationFormSubmit" type="submit" class="mainBtn" value="Send Invitations" />
							</form>
							<!--<form method="post" action="./manageInvitations.php" >-->
							<input name="btnInvitations" id="btnInvitations" type="button" class="mainBtn" value="Manage Invitations for this Event" />
							<!--</form>-->
							<form method="post" action="" >
								<input name="btnCheckIn" id="btnCheckIn" type="button" class="mainBtn" value="Manage Checkins for this event" />
                            </form>					
                        </div> <!-- /.contact-form -->
					</div> <!-- /.col-md-4 -->
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->		
				</div> <!-- /.row -->							
				<?php } ?>
				
			</div> <!-- /.container -->
        </div> <!-- /#attendee -->		
		<?php } ?>
		
		
		
        <?php if ($thisUser!=null && $event!=null && $thisUser->authenticateEventModifier($event->eventId) ) {?>
		<div class="content-section level-2-pages content-level-2" id="invitations" style="display:none;">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>Invitations</h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">					
						<?php require_once('./includes/snippets/invitations/event_invitees_grid.php'); ?>
					</div>
				</div> <!-- /.row -->	
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		<?php } ?>			
		
		
        <?php if ($thisUser!=null && $event!=null && $thisUser->authenticateEventModifier($event->eventId) ) {?>
		<div class="content-section level-2-pages content-level-2" id="event-checkins" style="display:none;">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>Checkins</h2>
						<?php if ($checkinSubmitSuccess) { ?>
						<p>Checkins have been posted successfully!</p>
						<?php } ?>
						<?php /*if ($errorMessageLog == "" && !$checkinSubmitSuccess) { ?>
						<p>All checked attendees were already posted!</p>						
						<?php }*/ ?>		
					</div>
					<div style="max-height:270px; overflow-y:scroll;">					
					<?php $results = Invitee::getEventCheckins($event->eventId); ?>
					<?php require_once('./includes/snippets/checkins/checkins_grid.php'); ?>
					<?php
					/*
					<table class="rwd-table col-md-12">
					  <tr>
						<th><input type="checkbox" onclick="albuwi(this);" />&nbsp;Checkin All</th>
						<th>Attendee Email</th>
						<th>Invitation Status</th>
						<th>Checkin Status</th>
						<th>Checkin time</th>
						<th></th>
						<!--<th></th>-->
					  </tr>
					  
						<?php
							//Get All events
							
							if (count($results) > 0){
								?>
								<form name="checkinSubmitForm" id="checkinSubmitForm" method="post" action="">
								<?php
								foreach($results as $row) {
									echo '<tr>';
									echo '<td><input type="checkbox" name="checkins[]" id="checkins" value="'.$row['attendeeId'].'"';
									if ( $row['checkInStatus'] != "NotCheckedIn") echo ' checked="checked" disabled="true"';
										echo ' />';
									//echo '<td/>';
									?>									
									<?php
									echo '<td data-th="Attendee Email">'. $row['attendeeEmailAddress'].'</td>';
									echo '<td data-th="Invitation Status">'.$row['invitationStatus'].'</td>';
									echo '<td data-th="Checkin Status">'.($row['checkInStatus']!="NotCheckedIn" ? "Checked in" : "Not checked in!").'</td>';
									echo '<td data-th="Checkin time">'.($row['checkInStatus']!="NotCheckedIn" ? $row['checkInTime'] : "None!").'</td>';									
									echo '<td data-th="">';
									if ($row['checkInStatus']=="NotCheckedIn")
									echo 	'<a href="rsvp.php?attendeeId='.$row['attendeeId'].'">Update Response</a>';
									else
									echo	'';
									echo '</td>';
									/*echo '<td data-th="">';
									echo 	'<form action="" method="post">';
									echo 		'<input type="hidden" name="attendeeId" id="attendeeId" value="'.$row['attendeeId'].'" />';
									echo 		'<input class="tblButton" type="submit" name="attendeeDeleteFormSubmit" id="attendeeDeleteFormSubmit" value="Remove" />';
									echo 	'</form>';
									echo '</td>';
									*/
									/*echo '</tr>';
								}
								?>
								<?php
							}	
						?>
					</table>
					*/
					?>
					</div>
				</div> <!-- /.row -->
				
				<?php if (count($results) > 0) { ?>
				<div class="row">
					<br />
					<input type="hidden" name="eventId" id="eventId" value="<?php echo $event->eventId; ?>" />
					<input name="checkinSubmit" id="checkinSubmit" type="submit" class="mainBtn" value="Submit Checkins" />
					</form>					
					<!--<input name="btnCheckinSubmit" id="btnCheckinSubmit" type="button" class="mainBtn" value="Submit Checkins" />-->
				</div> <!-- /.row -->	
				<?php } ?>
				
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		<?php } ?>		
		
        <?php if (!isset($_REQUEST['eventId'])) { ?>
		<div class="content-section" id="portfolio">
			<?php	require_once ('./includes/sections/all_events_section.php');	?>		
        </div> <!-- /#portfolio -->			
		<?php } ?>
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>						
			
		<script type="text/javascript">
			
			$( "#btnInvitations" ).click(function() {
				$( "#invitations" ).show();
				var offset = 0; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#invitations").offset().top + offset
				}, 1000);
			});
			
			$( "#btnCheckIn" ).click(function() {
				$( "#event-checkins" ).show();
				var offset = 0; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#event-checkins").offset().top + offset
				}, 1000);
			});
			
			$('a[href="#top"]').click(function(){
				$( ".content-level-2" ).hide();
				$('html, body').animate({scrollTop: 0}, 1000);
				return false;
			});

			function albuwi(obj){
				var checkboxes = document.getElementsByName("checkins[]");
				var length = checkboxes.length;
				for (var i=0; i<length; i++) {
					if(!checkboxes[i].disabled) checkboxes[i].checked = obj.checked;
				}	
			}			
		</script>
		
    </body>
</html>
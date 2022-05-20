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
				exit(header( 'Location: error.php?errorMsg=' . urlencode("Unauthorized access!<br />Only registered users can access this page!") ));
			}
		}
?>

<?php
	if (!$adminAccess && $thisUser!=null && $thisUser->usertypeId==1)
		exit( header( 'Location: admin.php' )	);	
?>

<?php	require_once ('./includes/classes/event.php');	?>

<?php
	$eventDeleteSuccess = false;
	
	if ( isset($_POST['eventDeleteFormSubmit']) )
	{
		$eventId = $_POST['eventIdDelete'];
		if ( Event::deleteEvent($eventId, $errorMessage) > 0 ) $eventDeleteSuccess = true;
		
		if (!$eventDeleteSuccess)
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the event!") );
		//else
			//header( 'Location: manageEvents.php' );
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
					<?php if ($adminAccess) { ?>
						<div class="heading-section text-center">
							Admin user accessing manage events page for <a><b><?php echo $adminAccessUser->userType; ?></b> user <b><a href="client.php?userId=<?php echo $adminAccessUser->userId?>"><?php echo $adminAccessUser->userFullName; ?></a></b>
						</div>
					<?php } ?>				
					<div class="heading-section text-center">
						<h2 class="tableCaptionHeading">MANAGE EVENTS</h2>
					</div>
				</div>
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->

        <div class="content-section level-2-pages-rest">
            <div class="container">
                <div class="row">
						<table class="rwd-table col-md-12">
							<tr>
							<th>Event</th>
							<th>Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Organizer</th>				
							<?php if ( ($thisUser!=null && ($thisUser->usertypeId==2 || $thisUser->usertypeId==4)) || ($adminAccess && ($adminAccessUser->usertypeId==2 || $adminAccessUser->usertypeId==4)) ){ ?>
							<th colspan="2">
								<form method="post" action="./event_register.php<?php echo ($adminAccess ? '?userId='.$adminAccessUser->userId : ''); ?>" name="eventRegisterForm" id="eventRegisterForm">
									<input name="eventRegisterButtonSubmit" id="eventRegisterButtonSubmit" type="submit" class="mainBtn" value="Add Event" />
								</form>
							</th>								
							<?php } else if ( ($thisUser!=null && $thisUser->usertypeId==3) || ($adminAccess && $adminAccessUser->usertypeId==3) ){?>
							<th></th>
							<?php } ?>							
							</tr>
							<?php
								$showRemove=false;
								if ( ($thisUser->usertypeId == 2 || $thisUser->usertypeId == 4) || ($adminAccess && ($adminAccessUser->usertypeId==2 || $adminAccessUser->usertypeId==4)) )
									{ 
										if (!$adminAccess)
										$results = Event::getEventsForOwner($thisUser->userId);
										else
										$results = Event::getEventsForOwner($adminAccessUser->userId); 
										
										$showRemove=true;
									}
								else if ( ($thisUser->usertypeId == 3) || ($adminAccess && $adminAccessUser->usertypeId==3) )
									{ 
										if (!$adminAccess)
										$results = Event::getEventsForOrganizer($thisUser->userId); 
										else
										$results = Event::getEventsForOrganizer($adminAccessUser->userId); 
										
										$showRemove=false; 
									}
									
								if (count($results) <= 0){
									$zeroRowsMessage = "No records found in the database!";
									echo '<tr>';
									echo '<td data-th="Company" colspan="5">'.$zeroRowsMessage.'</td>';
									echo '</tr>';			
								} else {
									foreach($results as $row) {
										echo '<tr>';
										echo '<td data-th="Event"><a href="event.php?eventId='.$row['eventId'].'">'.$row['eventTitle'].'</a></td>';
										echo '<td data-th="Date">'. $row['eventDate'].'</td>';
										echo '<td data-th="Start Time">'.$row['eventStartTime'].'</td>';
										echo '<td data-th="End Time">'.$row['eventEndTime'].'</td>';
										echo '<td data-th="Organizer">'.$row['organizerName'].'</td>';
										//UPDATE
										echo '<td data-th=""><a href="event_update.php?eventId='.$row['eventId'].'">Update</a></td>';
										if ($showRemove){
										//REMOVE
										echo '<td data-th="">';
										echo 	'<form action="" method="post">';
										echo 		'<input type="hidden" name="eventIdDelete" id="eventIdDelete" value="'.$row['eventId'].'" />';
										echo 		'<input type="submit" name="eventDeleteFormSubmit" id="eventDeleteFormSubmit" value="Remove" />';
										echo 	'</form>';
										echo '</td>';
										}										
										echo '</tr>';
									}
								}
							?>
						</table>			
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->

        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>		
    </body>
</html>
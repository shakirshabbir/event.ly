<?php	require_once ('./includes/classes/invitee.php');	?>
<?php	require_once ('./includes/classes/event.php');	?>

<?php
	$attendeeId = 0;
	if ( isset($_REQUEST['attendeeId']) ) $attendeeId = $_REQUEST['attendeeId'];
	
	$attendee = Invitee::getAttendeeInfo($attendeeId);
	if ($attendee == null)
	header( 'Location: error.php?errorMsg=' . urlencode("We are sorry but we are not able to find information associated with this invitee!") );	
?>

<?php
	$currentResponse = $attendee->attendeeResponse;
?>

<?php
	$eventId = $attendee->eventId;
	$event = Event::getEventInfoById($eventId);
	
	if ($event == null)
	header( 'Location: error.php?errorMsg=' . urlencode("We are sorry but we are not able to find an associated event with your details!") );
?>

<?php
	$attendeeResponseUpdateSuccess = false;
	
	$response = "";
	if ( isset($_POST['btnYes']) )		$response="YES";
	if ( isset($_POST['btnNo']) )		$response="NO";	
	if ( isset($_POST['btnMayBe']) ) 	$response="MAY";
	
	if ($attendee!=null)
	$attendee->attendeeResponse = $response;
	
	if ( isset($response) && $response !== "")
	{	
		if ( $attendee->updateResponse($errorMessage) > 0 ) 		$attendeeResponseUpdateSuccess = true;		
		else
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Sorry! Unable to update response!") );
	}
	
?>

<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li class="active"><a href="#">Attendee</a></li>
	<li><a href="client.php">Client</a></li>
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

        <div class="content-section level-2-pages" id="our-team">
            <div class="container">
                <div class="row">
					<div class="heading-section text-center">
						<p><h2>RSVP</h2></p>
						<p><h2 class="tableCaptionHeading"><a href="event.php?eventId=<?php echo $event->eventId; ?>"><?php echo $event->eventTitle; ?></a></h2></p>
						This invitation was sent to <a><b><?php echo $attendee->attendeeEmailAddress; ?></b></a>
						<?php if ( $attendeeResponseUpdateSuccess ) { ?>
						<p>Thank you! Your response for the event has been recorded as <b>"<?php echo $response=="MAY" ? "MAYBE" : $response; ?>"</b></p>
						<?php } ?>
					</div>
				</div>
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
					<div class="contact-form">
						<div class="col-md-4 col-sm-6">    
							<form name="attendeeResponeForm" id="attendeeResponeForm" method="post">
								<?php if ( !$attendeeResponseUpdateSuccess ) { ?>
								<input name="btnYes" id="btnYes" type="submit" class="mainBtn" value="YES" />
                                <input name="btnNo" id="btnNo" type="submit" class="mainBtn" value="NO">
								<input name="btnMayBe" id="btnMayBe" type="submit" class="mainBtn" value="MAYBE">
								<?php } ?>
								<input id="btnSeeDetails" type="button" value="SEE DETAILS">
								<?php if ( $attendeeResponseUpdateSuccess ) { ?>
								<input name="btnChangeResponse" id="btnChangeResponse" type="submit" class="mainBtn" value="CHNAGE RESPONSE">
								<?php } ?>								
								<input name="attendeeId" id="attendeeId" type="hidden" value="<?php echo $attendeeId; ?>" />
							</form>
						</div> <!-- /.col-md-2  -->
					</div> <!-- /.contact-form -->
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->		
				</div> <!-- /.row -->					
	
				<br />
				
                <div class="content-level-2" id="event-details" style="display:none;">
				<div class="row">
					<div class="col-md-9">				
						<div class="heading-section">
							<h2 class="tableCaptionHeading"><u>Event Details:</u></h2>
							<p><label>What:</label> <?php echo $event->eventTitle;?></p>
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
					<div class="col-md-3 text-right">

					</div>					
				</div>
				</div>
	
			</div> <!-- /.container -->
        </div> <!-- /#attendee -->


        <!--<div class="content-section" id="portfolio">
			<?php	//require_once ('./includes/sections/events_section.php');	?>		
        </div> <!-- /#portfolio -->
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
        
			<?php	require_once ('./includes/footer_script.php');	?>
			
		<script type="text/javascript">
			$( "#btnSeeDetails" ).click(function() {
				$( "#event-details" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#event-details").offset().top + offset
				}, 1000);
			});
			
			$('a[href="#top"]').click(function(){
				$( ".content-level-2" ).hide();
				$('html, body').animate({scrollTop: 0}, 1000);
				return false;
			});				
		</script>
    </body>
</html>
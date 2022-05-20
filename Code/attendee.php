<?php	require_once ('./includes/classes/invitee.php');	?>
<?php	require_once ('./includes/classes/event.php');	?>

<?php	
	if (!isset($_REQUEST['attendeeId'])) 
		exit(header( 'Location: error.php?errorMsg=' . urlencode("Unauthorized access!<br />Only registered attendees who are logged in can access this page!") ));
	
	$attendeeId = 0;
	if ( isset($_REQUEST['attendeeId']) ) $attendeeId = $_REQUEST['attendeeId'];
	
	$attendee = Invitee::getAttendeeInfo($attendeeId);
	if ($attendee == null)
	header( 'Location: error.php?errorMsg=' . urlencode("We are sorry but we are not able to find information associated with this attendee!") );	
?>

<?php
	$eventId = $attendee->eventId;
	$event = Event::getEventInfoById($eventId);
	
	if ($event == null)
	header( 'Location: error.php?errorMsg=' . urlencode("We are sorry but we are not able to find an associated event with your details!") );
?>

<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li class="active"><a href="attendee.php">Attendee</a></li>
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
						<h2>Attendee</h2>
						<p><?php echo $attendee->attendeeName; ?></p>
						<p style="text-transform:none;"><?php echo $attendee->attendeeEmailAddress; ?></p>
						<p>Attendee Ref Code: <?php echo $attendee->attendeeRefCode; ?></p>						
					</div>
				</div>
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
					<div class="contact-form">
						<div class="col-md-4 col-sm-6">    
								<input id="btnEvents" type="button" class="mainBtn" value="CHECKIN" />
								<input id="btnSeeDetails" type="button" value="SEE EVENT DETAILS">
						</div> <!-- /.col-md-4  -->
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
				
				<!--<div class="row">
					<div class="col-md-6 col-sm-6">											
                        <p><input type="submit" class="mainBtn" id="submit" value="Checkin">
						Are you up for an early checkout?
						<input id="reasonCheckout" placeholder="Reason? (Optional)" />
						<input type="submit" class="mainBtn" id="submit" value="Checkout"></p>
						<p>You already checked in for the event at 04:32 PM </p>
						<ul class="social-icons">
							<li style="display:inline;"><a href="#" class="fa fa-facebook"></a></li>
							<li style="display:inline;"><a href="#" class="fa fa-twitter"></a></li>
							<li style="display:inline;"><a href="#" class="fa fa-dribbble"></a></li>
							<li style="display:inline;"><a href="#" class="fa fa-linkedin"></a></li>
						</ul>
						<p>You already checked in for the event at 04:32 PM </p>						
                    </div> <!-- /.heading-section 		
                </div> <!-- /.row -->		
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
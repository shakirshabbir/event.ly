<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/check_loggedin_client.php');	?>

<?php	require_once ('./includes/classes/event.php');	?>
<?php	require_once ('./includes/classes/invitee.php');	?>

<?php
	
	if ( !isset($_REQUEST['invitationEventId']) )
		header( 'Location: error.php?errorMsg=' . urlencode("You tried to access Invitations page from an unknown workflow!") );
	$postedInvitationId = $_REQUEST['invitationEventId'];
	$postedHostUserId = isset($_POST['hostUserId'])? $_POST['hostUserId'] : $thisUser->userId;
	$eventId = $postedInvitationId;
	$event = Event::getEventInfoById($eventId);
	
	if ($event == null)
	header( 'Location: error.php?errorMsg=' . urlencode("No event found!") );

?>

<?php
	if (isset($_POST['inviteeEmailAddress'])) {
		
		$sucessCount=0;
		
		$inviteesNameList = $_POST['inviteeName'];
		$inviteesEmailAddressList = $_POST['inviteeEmailAddress'];
		$invitationEventId = $_POST['invitationEventId'];
		$hostUserId = $_POST['hostUserId'];
		$additionalNote = $_POST['additionalNote'];
		$sendEmailAll = false;
		if ( isset($_POST['chkBoxSendAll']) ) $sendEmailAll = true;
		
		try{
			$successfullInvites = array();
			$unSuccessfullInvites = array();
			$i=-1;
			foreach($inviteesEmailAddressList as $inviteeEmail) {
				$i++;
				
				$invitee = null;
				$invitee = new Invitee();

				$invitee->eventId = $invitationEventId;
				$invitee->hostUserId = $hostUserId;
				$invitee->attendeeRefCode = $invitee->generateAttendeeId();
				$invitee->attendeeName = $inviteesNameList[$i];
				$invitee->attendeeEmailAddress = $inviteeEmail;
				$invitee->additionalNote = $additionalNote;
				
				if ( $invitee->insertInvitee($sendEmailAll) > 0 ) $sucessCount++;
			}
		}
		catch(Exception $e){
			//If unSuccessfullInvites count > 0 , then remove those entries from databse as we dont want to duplicate entries in inviation table
			header( 'Location: error.php?errorMsg=' . urlencode($e->getMessage()."<br />No event found!") );
		}
	}
?>

<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li><a href="attendee.php">Attendee</a></li>
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
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <div class="site-main" id="sTop">
            <div class="site-header">
				<?php	require_once ('./includes/site_header.php');	?>
				<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
			</div> <!-- /.site-header -->
        </div> <!-- /.site-main -->

        <div class="content-section level-2-pages" id="our-team">
            <div class="container">
                <div class="row">
					<div class="heading-section text-center">
						<h2>Invitation</h2><br /><br />
						
						<h2 class="tableCaptionHeading">EVENT: <a href="event.php?eventId=<?php echo $event->eventId; ?>"><?php echo $event->eventTitle; ?></a></h2>
						<?php if($thisUser->usertypeId==3) {
							echo '<p>ORGANIZER: '.$thisUser->userLname.', '.$thisUser->userFname.'</p>';
							echo '<p>'.$thisUser->userContactNumber.'</p>';							
							echo '<p>COMPANY: '.$thisUser->userOwnerName.'</p>';
						} else if($thisUser->usertypeId==2 || $thisUser->usertypeId==4) {
							echo '<p>CLIENT: '.$thisUser->userLname.', '.$thisUser->userFname.'</p>';
							echo '<p>'.$thisUser->userContactNumber.'</p>';
						}
						?>
					</div>
				</div>
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">
					
                    </div> <!-- /.col-md-4 -->
					
					<div class="col-md-4 col-sm-6" id="divEmailBoxes">
						<?php 	
							if(isset($sucessCount) && $sucessCount>=0) {
								echo '<div class="heading-section text-center">';
								echo '<a><b>'.$sucessCount.' invitations sent successfully!</b></a>';
								echo '</div>';
							}
						?>
						<div class="contact-form">
							<form name="emailForm" id="emailForm" method="post" action="">							
								<div id="inviteeListDiv">
									<label> Invitee 1: </label>
									<p><input type="text" name="inviteeName[]" id="inviteeName" placeholder="Name" required />
									<input type="email" name="inviteeEmailAddress[]" id="inviteeEmailAddress" placeholder="Email Address" required /></p>
								</div>
								<p><input style="max-width:80px;" type="button" class="tblButton" id="addMoreEmailFields" value="ADD"/></p>
								
								<label for="additionalNote">Additional Note (Optional):</label>
								<p><textarea name="additionalNote" id="additionalNote"></textarea></p>
                                <input type="hidden" name="invitationEventId" id="invitationEventId" value="<?php echo $postedInvitationId; ?>" />
								<input type="hidden" name="hostUserId" id="hostUserId" value="<?php echo $postedHostUserId; ?>" />
								<br /><label>Dispatch Emails</label>&nbsp;<input type="checkbox" name="chkBoxSendAll" id="chkBoxSendAll" />
								<input type="submit" name="submit" id="submit" class="mainBtn" value="INVITE" />
							</form>
						</div> <!-- /.contact-form -->
					</div> <!-- /.col-md-4  -->
					
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->		
				</div> <!-- /.row -->					
	
			</div> <!-- /.container -->
        </div> <!-- /#attendee -->
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
        
			<?php	require_once ('./includes/footer_script.php');	?>	
			
		<script type="text/javascript">
			$( document ).ready(function() {
				var inviteeCount = 1;
				
				$( "#addMoreEmailFields" ).click(function() {
				
					inviteeCount++;
					
					if (inviteeCount<=10) {
					
					var appendElements = "";
						appendElements += "<label> Invitee "+inviteeCount+": </label>";
						appendElements += "<p><input type=\"text\" name=\"inviteeName[]\" id=\"inviteeName\" placeholder=\"Name\" required /><input type=\"email\" name=\"inviteeEmailAddress[]\" id=\"inviteeEmailAddress\" placeholder=\"Email Address\" required /></p>";
						//appendElements += "<p><input style=\"max-width:100px;\" type=\"button\" class=\"tblButton\" id=\"delField\" value=\"REMOVE\"/></p>";
					
					$("#inviteeListDiv").append(appendElements);			
					
					var offset = -200; //Offset of 20px

					$('html, body').animate({
						scrollTop: $("#addMoreEmailFields").offset().top + offset
					});
				
					}
				});
				
				$( "#delField" ).click(function() {
				
					$('#inviteeName['+inviteeCount+']').remove();
					$(this).closest('#inviteeLabel').remove();
					$(this).remove();
					inviteeCount--;
					
					var offset = 20; //Offset of 20px

					$('html, body').animate({
						scrollTop: $("#addMoreEmailFields").offset().top + offset
					});
				
				});				
				
			});
			
			
		</script>				
			
			
    </body>
	
	
</html>
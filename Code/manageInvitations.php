<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/check_loggedin_client.php');	?>

<?php	require_once ('./includes/classes/event.php');	?>
<?php	require_once ('./includes/classes/invitee.php');	?>

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
	$attendeeDeleteSuccess = false;
	
	if ( isset($_POST['attendeeDeleteFormSubmit']) )
	{
		$inviteeId = $_POST['attendeeIdDelete'];
		$errorMessage = '';		
		if ( Invitee::deleteInvitee($inviteeId, $errorMessage) ) $attendeeDeleteSuccess = true;
		
		if (!$attendeeDeleteSuccess)
			exit( header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the user!") ));
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
				<?php	include_once ('./includes/sections/user_buttons.php');	?>
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">					
                    </div> <!-- /.col-md-4 -->
					
					<div class="col-md-4 col-sm-6">
					</div> <!-- /.col-md-4  -->
					
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
				</div> <!-- /.row -->					
	
			</div> <!-- /.container -->
        </div> <!-- /#attendee -->
		
        <?php //if ($thisUser!=null && $thisUser->authenticateEventModifier($event->eventId) ) {?>
        <?php if ($thisUser!=null) {?>		
		<div class="content-section level-2-pages content-level-2" id="event-checkins">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>Invitees</h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">		
						<?php require_once('./includes/snippets/invitations/user_invitees_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
				
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		<?php } ?>				
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
        
			<?php	require_once ('./includes/footer_script.php');	?>				
			
    </body>
	
</html>
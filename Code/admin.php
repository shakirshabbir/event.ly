<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/check_loggedin_admin.php');	?>

<?php	require_once ('./includes/classes/event.php');	?>
<?php	require_once ('./includes/classes/invitee.php');	?>

<?php	require_once ('./includes/snippets/checkins/process_checkins.php');	?>

<?php
	$eventDeleteSuccess = false;
	
	if ( isset($_POST['eventDeleteFormSubmit']) )
	{
		$eventId = $_POST['eventIdDelete'];
		$errorMessage = '';
		if ( Event::deleteEvent($eventId, $errorMessage) ) $eventDeleteSuccess = true;
		
		if (!$eventDeleteSuccess)
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the event!") );
		else
			header( 'Location: admin.php' );
	}
?>

<?php
	$userDeleteSuccess = false;
	
	if ( isset($_POST['userDeleteFormSubmit']) )
	{
		$userId = $_POST['userIdDelete'];
		$errorMessage = '';
		if ( User::deleteUser($userId, $errorMessage) > 0 ) $userDeleteSuccess = true;
		
		if (!$userDeleteSuccess)
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the user!") );
		else
			header( 'Location: admin.php' );
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
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the attendee!") );
		else
			header( 'Location: admin.php' );
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
					<div class="col-md-4">
                    </div> <!-- /.col-md-4 -->
					<div class="col-md-4">
						<div class="heading-section text-center">
							<h2>ADMIN</h2>
							<p><?php echo $thisUser->userLname ;?>, <?php echo " ". $thisUser->userFname ;?></p>
							<p><?php echo $thisUser->userContactNumber ;?></p>
						</div>					
                    </div> <!-- /.col-md-4 -->
					<div class="col-md-4 text-right">
							<form name="logoutAdminForm" method="post" action="logout_script.php">
								<p><input name="logoutAdminSubmit" id="logoutAdminSubmit" type="submit" class="mainBtn" value="LOGOUT"></p>
							</form>			
                    </div> <!-- /.col-md-4 -->
				</div>
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
					<div class="contact-form">
						<div class="col-md-4 col-sm-6">    
								<!--<input id="btnAllUsers" type="button" class="mainBtn" value="All Users">-->
								
							<form action="statistics.php">
								<input id="btnStatiticsSubmit" type="submit" class="mainBtn" value="Statistics" />
							</form>                       
                                
								
								
						</div> <!-- /.col-md-4  -->
					</div> <!-- /.contact-form -->
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->		
				</div> <!-- /.row -->	
				
				<div class="row">
                    <div class="contact-form">
						<div class="col-md-4 col-sm-6">
									<input id="btnEvents" type="button" class="mainBtn" value="Events" />
						</div> <!-- /.col-md-4 -->
						
							<div class="col-md-4 col-sm-6">    
									<input id="btnAllInvitations" type="button" class="mainBtn" value="Invitations" />
							</div> <!-- /.col-md-4  -->
						
						<div class="col-md-4 col-sm-6">
									<input id="btnAllIndividuals" type="button" class="mainBtn" value="Individuals" />					
						</div> <!-- /.col-md-4 -->		
					</div> <!-- /.contact-form -->
				</div><!-- /.row -->				

				<div class="row">
                    <div class="contact-form">
						<div class="col-md-4 col-sm-6">
									<input id="btnAllCompanies" type="button" class="mainBtn" value="Companies" />
						</div> <!-- /.col-md-4 -->
						
							<div class="col-md-4 col-sm-6">    
									<input id="btnAllOrganizers" type="button" class="mainBtn" value="Organizers" />
							</div> <!-- /.col-md-4  -->
						
						<div class="col-md-4 col-sm-6">
									<input id="btnCheckins" type="button" class="mainBtn" value="Checkins" />			
						</div> <!-- /.col-md-4 -->		
					</div> <!-- /.contact-form -->
				</div><!-- /.row -->	

				
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
		
        <!--<div class="content-section level-2-pages content-level-2" id="admin-all-events" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-events">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All events<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">					
						<?php require_once('./includes/snippets/events/admin_all_events_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		
        <?php
		/*
		<!--<div class="content-section level-2-pages content-level-2" id="admin-all-users" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-users">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All users<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">
						<?php require_once('./includes/snippets/users/admin_all_users_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		*/
		?>
		
        <!--<div class="content-section level-2-pages content-level-2" id="admin-all-companies" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-companies">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All companies<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">
						<?php require_once('./includes/snippets/users/admin_all_companies_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->		
		
        <!--<div class="content-section level-2-pages content-level-2" id="admin-all-organizers" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-organizers">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All organizers<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">
						<?php require_once('./includes/snippets/users/admin_all_organizers_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->				
		
        <!--<div class="content-section level-2-pages content-level-2" id="admin-all-individuals" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-individuals">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All individuals<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">
						<?php require_once('./includes/snippets/users/admin_all_individuals_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->						

        <!--<div class="content-section level-2-pages content-level-2" id="admin-statistics" style="display:none;">-->
		<?php
		/*
		<div class="content-section level-2-pages content-level-2" id="admin-statistics">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>Event Statistics<h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">
					<table class="rwd-table col-md-12">
					  <tr>
						<th>Event</th>
						<th>Date</th>
						<!--<th>Owner</th>-->
						<th>Attendees' Count</th>		
						<th></th>	
					  </tr>
					  
						<?php
							//Get All events
							$results = Event::getAttendeeCount();
							if (count($results) > 0){
								foreach($results as $row) {
									echo '<tr>';
									echo '<td data-th="Event">'.$row['eventTitle'].'</td>';
									echo '<td data-th="Date">'.$row['eventDate'].'</td>';
									//echo '<td data-th="Owner">'.$row['ownerName'].'</td>';
									echo '<td data-th="Audience Count">'.$row['attendeeCount'].'</td>';
									echo '<td data-th=""><a href="event.php?eventId='.$row['eventId'].'">Link</a>';
									echo '</tr>';
								}
							}	
						?>
					</table>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->
		*/
		?>
		
        <!--<div class="content-section level-2-pages content-level-2" id="admin-all-invitations" style="display:none;">-->
		<div class="content-section level-2-pages content-level-2" id="admin-all-invitations">
            <div class="container">
                <div class="row">
					<div class="heading-section">
						<h2>All Invitations</h2>
					</div>
					<div style="max-height:270px; overflow-y:scroll;">					
						<?php require_once('./includes/snippets/invitations/admin_all_invitees_grid.php'); ?>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.content-section -->			

		<?php	require_once ('./includes/snippets/checkins/process_admin_checkins.php');	?>		
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>			
			
		<script type="text/javascript">		
			
			$( "#btnAllUsers" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-users" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-users").offset().top + offset
				}, 1000);
			});

			$( "#btnAllCompanies" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-companies" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-companies").offset().top + offset
				}, 1000);
			});			
			
			$( "#btnAllOrganizers" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-organizers" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-organizers").offset().top + offset
				}, 1000);
			});						
			
			$( "#btnAllIndividuals" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-individuals" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-individuals").offset().top + offset
				}, 1000);
			});
			
			$( "#btnAllInvitations" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-invitations" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-invitations").offset().top + offset
				}, 1000);
			});
			
			$( "#btnEvents" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-all-events" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-all-events").offset().top + offset
				}, 1000);
			});
				
	

			$( "#btnStatistics" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-statistics" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-statistics").offset().top + offset
				}, 1000);
			});
			
			/*
			$( "#btnAttendees" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#admin-attendees" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#admin-attendees").offset().top + offset
				}, 1000);
			});*/			

			$( "#btnCheckins" ).click(function() {
				$( ".content-level-2" ).hide();
				$( "#event-checkins" ).show();
				var offset = 20; //Offset of 20px

				$('html, body').animate({
					scrollTop: $("#event-checkins").offset().top + offset
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
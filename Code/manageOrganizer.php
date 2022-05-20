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
		exit( header( 'Location: admin.php' ) );	
?>

<?php	require_once ('./includes/classes/event_organizers.php');	?>

<?php
	$organizerDeleteSuccess = false;
	
	if ( isset($_POST['organizerDeleteFormSubmit']) )
	{
		$organizerId = $_POST['organizerIdDelete'];
		if ( User::deleteUser($organizerId, $errorMessage) > 0 ) $organizerDeleteSuccess = true;
		
		if (!$organizerDeleteSuccess)
			header( 'Location: error.php?errorMsg=' . urlencode($errorMessage. "! Unable to delete the organizer!") );
		else
			header( 'Location: manageOrganizer.php' );
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
							Admin user accessing manage organizers page for <a><b><?php echo $adminAccessUser->userType; ?></b> user <b><a href="client.php?userId=<?php echo $adminAccessUser->userId?>"><?php echo $adminAccessUser->userFullName; ?></a></b>
						</div>
					<?php } ?>				
				
					<div class="heading-section text-center">
						<h2 class="tableCaptionHeading">MANAGE ORGANIZERS</h2>
					</div>
				</div>
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->

        <div class="content-section level-2-pages-rest">
            <div class="container">
                <div class="row">
					<table class="rwd-table col-md-12">
					  <tr>
						<th>Organizer</th>
						<th>Contact</th>
						<th>Email Address</th>
						<th colspan="2">
							<form name="addOrganizerForm" id="addOrganizerForm" method="post" action="./client_register.php">
								<input name="userCompanyId" id="userCompanyId" type="hidden" value="<?php echo ($adminAccess ? $adminAccessUser->userId : $thisUser->userId); ?>" />
								<input name="userCompanyTypeId" id="userCompanyTypeId" type="hidden" value="<?php echo ($adminAccess ? $adminAccessUser->usertypeId : $thisUser->usertypeId); ?>" />								
								<input name="addOrganizerSubmit" id="addOrganizerSubmit" type="submit" class="mainBtn" value="NEW ORGANIZER" />
							</form>
						</th>
						<!--<th></th>-->
					  </tr>
					  
						<?php
							//Get All organizers under this company
							if (!$adminAccess)
							$results = EventOrganizers::getOrganizersList($thisUser->userId);
							else
							$results = EventOrganizers::getOrganizersList($adminAccessUser->userId);
							if (count($results) <= 0){
								$zeroRowsMessage = "No records found in the database!";
								echo '<tr>';
								echo '<td data-th="Company" colspan="5">'.$zeroRowsMessage.'</td>';
								echo '</tr>';			
							} else {							
								foreach($results as $row) {
									echo '<tr>';
									echo '<td data-th="Organizer">'. $row['organizerName'].'</td>';
									echo '<td data-th="Contact">'. $row['organizerContact'].'</td>';
									echo '<td data-th="Email Address">'. $row['organizerEmailAddress'].'</td>';									
									//UPDATE
									echo '<td data-th=""><a href="#">Update</a>';
									//REMOVE
									echo '<td data-th="">';
									echo 	'<form action="" method="post">';
									echo 		'<input type="hidden" name="organizerIdDelete" id="organizerIdDelete" value="'.$row['organizerId'].'" />';
									echo 		'<input type="submit" name="organizerDeleteFormSubmit" id="organizerDeleteFormSubmit" value="Remove" />';
									echo 	'</form>';
									echo '</td>';												
									echo '</tr>';
								}
							}
						?>		  
					</table>					
				</div>
			</div> <!-- /.container -->
		</div>

        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>	     		
		
    </body>
</html>
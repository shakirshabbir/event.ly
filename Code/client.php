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
				<?php	include_once ('./includes/sections/user_buttons.php');	?> <!-- User Buttons are okay with all user types that are redirected here -->    
				
				<div class="row">
                    <div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->
					<div class="col-md-4 col-sm-6">
                        <div class="contact-form">
							<?php if ($adminAccess) { ?>
								<div class="heading-section text-center">
									Admin user accessing dashboard for <a><b><?php echo $adminAccessUser->userType; ?></b> user <b><?php echo $adminAccessUser->userFullName; ?></b></a>					
								</div>
							<?php } ?>
							<?php if ( ($thisUser!=null && $thisUser->usertypeId==2) || ($adminAccess && $adminAccessUser->usertypeId==2) ){?>
							<form method="post" action="./manageOrganizer.php<?php echo ($adminAccess ? '?userId='.$adminAccessUser->userId : '');?>" name="mangeOrganizerForm" id="mangeOrganizerForm">
                                <input type="submit" class="mainBtn" id="mangeOrganizer" value="Manage Organizers">
                            </form>
							<?php } ?>														
							<form method="post" action="./manageEvents.php<?php echo ($adminAccess ? '?userId='.$adminAccessUser->userId : ''); ?>" name="contactform" id="contactform">
								<input type="submit" class="mainBtn" id="submit" value="Manage Events">
                            </form>
							<form method="post" action="./manageInvitations.php<?php echo ($adminAccess ? '?userId='.$adminAccessUser->userId : ''); ?>" name="contactform" id="contactform">
								<input type="submit" class="mainBtn" id="submit" value="Manage Invitations">
                            </form>
							<form method="post" action="./manageCheckins.php<?php echo ($adminAccess ? '?userId='.$adminAccessUser->userId : ''); ?>" name="contactform" id="contactform">
								<input type="submit" class="mainBtn" id="submit" value="Manage Checkins">
                            </form>							
                        </div> <!-- /.contact-form -->
					</div> <!-- /.col-md-4 -->
					<div class="col-md-4 col-sm-6">
                    </div> <!-- /.col-md-4 -->		
				</div> <!-- /.row -->				
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>	
        
    </body>
</html>
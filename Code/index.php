<?php 	if(!isset($_SESSION)) session_start(); ?>
<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/classes/invitee.php');	?>

<?php
	/*
		This portion of code has to do with displaying client name and instructions for going to dashboard if client is logged in
	*/
	$thisUser = null;
	$clientName = "Client";

	if(!isset($_SESSION)) session_start();
	
	/* If user is logged in, get user details */
	if (isset($_SESSION['userLoggedInStatus']) && $_SESSION['userLoggedInStatus'] == true) {
		$thisUser = User::getUser( $_SESSION['userEmailAddress'] );
		/*
			usertypeId = 1/ADMIN
			usertypeId = 2/COMPANY/Client
			usertypeId = 3/Organizer
			usertypeId = 4/Indivisual
		*/
		if ( $thisUser!=null && ( $thisUser->usertypeId == 1 || $thisUser->usertypeId == 2 || $thisUser->usertypeId == 3 || $thisUser->usertypeId == 4) )
			$clientName=$thisUser->userLname.", ".$thisUser->userFname;
	}
?>

<?php
	if ( isset($_POST['clientFormSubmit']) )
	{
		require_once ('./includes/snippets/login_user.php');
	}
?>

<?php
	$attendeeLoginFailed = false;
	if ( isset($_POST['attendeeRefCodeSubmit']) )
	{
		require_once ('./includes/snippets/login_attendee.php');
	}
?>

<?php
	$navigationMenu = '';
	$navigationMenu.= '';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<?php	require_once ('includes/head_info.php');	?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <div class="site-main" id="sTop">
            <div class="site-header">
				<?php	require_once ('includes/site_header_social.php');	?>
				<?php	require_once ('includes/site_header.php');	?>
            </div> <!-- /.site-header -->
            <div class="site-slider">
				<?php	require_once ('includes/site_slider.php');	?>
            </div> <!-- /.site-slider -->
        </div> <!-- /.site-main -->

		<!--<?php	//require_once ('includes/services.php');	?>-->
		<!--<?php	//require_once ('includes/sections/team.php');	?>-->		

        <div class="content-section" id="attendee">
				<?php	require_once ('includes/sections/attendee_section.php');	?>		
        </div> <!-- /#attendee -->

        <div class="content-section" id="client">
				<?php	require_once ('includes/sections/client_section.php');	?>		
        </div> <!-- /#client -->
        
        <!--<div class="content-section" id="events">
				<?php	//require_once ('includes/sections/events_section.php');	?>		
        </div> <!-- /#events -->

        <div class="content-section" id="contact">
				<?php	require_once ('includes/sections/contact_section.php');	?>		
        </div> <!-- /#contact -->
            
        <div id="footer">
			<?php	require_once ('includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>	     
			<?php	require_once ('includes/footer_script_map.php');	?>		
			
    </body>
</html>
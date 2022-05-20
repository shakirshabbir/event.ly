<?php
	//if (empty($_SESSION['userLoggedInStatus'])) {
		//$_SESSION['backURL'] = $_SERVER['REQUEST_URI'];
		//exit;
	//}
	
	//$backURL = empty($_SESSION['userLoggedInStatus']) ? '/' : $_SESSION['backURL'];
	//unset($_SESSION['backURL']);
	//header('Location: ' . $backURL);

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
		<?php	require_once('./includes/head_info.php');	?>
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

        <div class="content-section level-2-pages">
            <div class="container">
                <div class="row">
						<div class="heading-section text-center">
							<h2>ERROR!</h2>
						</div>
				</div>
				
				<div class="row">
					<div class="heading-section text-center">
							<form method="post" action="./index.php" name="errorForm" id="errorForm">
							<!--<form method="post" action="<?php echo $backURL; ?>" name="errorForm" id="errorForm">-->
							
								<p>Oops! An error has occured while execution!</p><br />
								<h2 class="tableCaptionHeading"><?php if (isset($_GET['errorMsg'])) echo $_GET['errorMsg']; else echo "We are sorry for the inconvenience!"; ?></h2><br />
								<p>" Please report to the site admin as soon as possible. Thank you!"</p>
					</div> <!-- /.heading-section -->
				</div> <!-- /.row -->					
				<div class="row">					
					<div class="col-md-4"></div>
					
					<div class="contact-form col-md-4 col-sm-6 text-center">
							<input type="submit" class="mainBtn" id="submit" value="RETURN TO HOME">
							</form>							
					</div>					
					
					<div class="col-md-4"></div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
           
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
        
			<?php	require_once ('./includes/footer_script.php');	?>		
    </body>
</html>
<?php	require_once ('./includes/classes/user.php');	?>

<?php	
	if ( !isset($_POST['newClientRegisterFormSubmit']) )
	require_once ('./includes/snippets/check_loggedin_client.php');	
?>

<?php
	//For User Type "CLIENT", usertypeId = 2;
	$usertypeId = 55; //its a junk Id
	$userCompanyId = isset($_POST['userCompanyId']) ? $_POST['userCompanyId'] : 0;
	$userCompanyTypeId = isset($_POST['userCompanyTypeId']) ? $_POST['userCompanyTypeId'] : 0;
?>

<?php
	$createSuccess = false;
	$createSuccessOrganizer = false;	
	
	if ( isset($_POST['clientRegisterFormSubmit']) )
	{
		//echo "<script>alert('clientRegisterForm POSTED');</script>";
		$userEmailAddress = $_POST['clientEmailAddress'];
		$userPassword = $_POST['clientPassword'];
		$userFname = $_POST['clientFname'];
		$userLname = $_POST['clientLname'];
		$userContactNumber = $_POST['clientContactNumber'];
		$userParentId = $userCompanyId;
		$usertypeId = $_POST['clientUserTypeId'];
		
		$user = new User($userEmailAddress, $userPassword);
		$errorMessage = '';
		try{
			$newUser = $user->createNewUser($userEmailAddress, $userPassword, $userFname, $userLname, $userContactNumber, $userParentId, $usertypeId, $errorMessage);
		}
		catch(Exception $e){
			exit( header( 'Location: error.php?errorMsg=' .urlencode($e->getMessage()."<br />Unable to register this user!") ));
		}
		if ($newUser==null) {
			$createSuccess = false;
			$createSuccessErrorMessage = $errorMessage;
			
		} else if ($newUser!=null) {
			$createSuccess = true;
			if ( $userParentId != 0 ) {
				//it means its an organizer that was created
				$createSuccessOrganizer = true;
			} else {
				if ($thisUser!=null && $thisUser->usertypeId==1) {//Admin User
					header( 'Location: admin.php' );
				}
				else {
					//include_once('./logout_script.php');
					header( 'Location: logout_script.php' );
				}
			}
		}
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
		<?php	require_once('./includes/head_info.php');	?>
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

		<?php if ($userCompanyId != 0) { ?>
        <div class="content-section level-2-pages" id="our-team">
            <div class="container">
                <div class="row">
					<div class="heading-section text-center">
						<h2>Client</h2>
						<p>CLIENT: <?php echo $thisUser->userLname ;?>, <?php echo " ". $thisUser->userFname ;?></p>
						<p>CONTACT:<?php echo $thisUser->userContactNumber ;?></p>
					</div>
				</div>
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
		<?php } ?>
		
		<div class="content-section level-2-pages<?php if ($userCompanyId != 0) echo "-rest"; ?>">
            <div class="container">
                <div class="row">
						<?php
							if (!$createSuccess && isset($createSuccessErrorMessage)) {
								echo '<div class="heading-section text-center">
										<p><a>'.$createSuccessErrorMessage.'</a></p>
								</div>';								
							}
							else 
							if($createSuccess) {
								if ($createSuccessOrganizer)
								echo '<div class="heading-section text-center">
										<p>Organizer <u>'.$userLname.', '.$userFname.'</u> created successfully.
											<a href="./client.php"> Please go to client dashboard!</a>
										</p>
								</div>';
								else
								echo '<div class="heading-section text-center">
										<p>Client '.$userLname.', '.$userFname.' created successfully.
											<a href="./index.php#client"> Please login!</a>
										</p>
								</div>';								
							}
						?>
						<div class="heading-section text-center">
							<?php if ( $userCompanyId != 0 ) { ?>
								<h2>Organizer Registration Form</h2>
							<?php } else { ?>					
								<h2>Client Registration Form</h2>
							<?php } ?>					
						</div>
					<div class="col-md-4 col-sm-6">
						<!-- intentionally left blank -->
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="contact-form">			
							<form method="post" name="clientRegisterForm" action="">
								<?php 
									if ($userCompanyTypeId==2){
										echo '<input type="hidden" name="clientUserTypeId" id="clientUserTypeId" value="3" />';
									} else {
										$resultsUserTypes = User::getUserTypes();
										if ($resultsUserTypes!=null){
										echo '<p>';
										echo '<label for="clientUserTypeId">Subscription type</label>';
										echo '<select name="clientUserTypeId" id="clientUserTypeId">';
											foreach($resultsUserTypes as $userType) {
												echo '<option value="'.$userType['usertypeId'].'"';
												//if ( $row[''] == $organizer['']) echo ' selected="selected"';
												echo '>'.$userType['usertype'].'</option>';
											}
										echo '</select>';								
										echo '</p>';
										}
									}
								?>								
								<p>
									<label for="eventTitle">First Name</label>
									<input name="clientFname" id="clientFname" type="text" placeholder="First name" />
								</p>
								<p>
									<label for="eventTitle">Last Name <?php echo ($userCompanyTypeId==2 ? '' : '(or Company name)'); ?></label>
									<input name="clientLname" id="clientLname" type="text" placeholder="Last name" required />
								</p>
								<p>
									<label for="eventTitle">Contact Number</label>
									<!--(<input type="tel" size="3" style="width:100px; dislay:inline;">) <input type="tel" size="3" style="dislay:inline;"> - <input type="tel" size="4">-->
									<!--<input name="clientContactNumber" id="clientContactNumber" type="tel" pattern="^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$" placeholder="+1 XXX-XXX-XXXX"/>-->
									<input name="clientContactNumber" id="clientContactNumber" type="tel" placeholder="Contact Number" required/>
								</p>																					
								<p>
									<label for="eventTitle">Email Address</label>
									<input name="clientEmailAddress" id="clientEmailAddress" type="email" placeholder="Email address" required />
								</p>
								<p>
									<label for="eventTitle">Password</label>
									<input name="clientPassword" id="clientPassword" type="password" placeholder="Case-sensitive minimum 8 characters password" required />
								</p>								
								<p>
									<label for="eventTitle">Confirm Password</label>								
									<input name="clientConfirmPassword" id="clientConfirmPassword" type="password" placeholder="Confirm password" required />
								</p>
									<input name="userCompanyId" id="userCompanyId" type="hidden" value="<?php echo $userCompanyId; ?>" />
									<input name="userCompanyTypeId" id="userCompanyTypeId" type="hidden" value="<?php echo $userCompanyTypeId; ?>" />									
								<input name="clientRegisterFormSubmit" id="clientRegisterFormSubmit" type="submit" class="mainBtn" value="Submit">
							</form>
						</div> <!-- /.contact-form -->
					</div> <!-- /.col-md-5 -->
					<div class="col-md-4 col-sm-6">
						<!-- intentionally left blank -->					
					</div>					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
        </div> <!-- /#our-team -->
           
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
		
			<?php	require_once ('includes/footer_script.php');	?>				
			
		<script type="text/javascript">
			/*
			$( window ).load(function() {
				$("#clientContactNumber").mask("+9 999-999?-9999");

				$("#clientContactNumber").on("blur", function() {
					var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );
					
					if( last.length == 3 ) {
						var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1 );
						var lastfour = move + last;
						
						var first = $(this).val().substr( 0, 9 );
						
						$(this).val( first + '-' + lastfour );
					}
				});		
			});
			*/
			window.onload = function () {
				document.getElementById("clientPassword").onchange = validatePassword;
				document.getElementById("clientConfirmPassword").onchange = validatePassword;		
			}
			
			function validatePassword(){
				var pass2=document.getElementById("clientPassword").value;
				var pass1=document.getElementById("clientConfirmPassword").value;
				if(pass1!=pass2)
					document.getElementById("clientConfirmPassword").setCustomValidity("Confirm password does not match!");
				else
					document.getElementById("clientConfirmPassword").setCustomValidity('');	 
					//empty string means no validation error
			}	
			
		</script>
    </body>
</html>						
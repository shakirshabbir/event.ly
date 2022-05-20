<div class="container">
	<div class="row">
		<div class="heading-section col-md-12 text-center">
				<h2>Dear <?php echo $clientName . ( $clientName!="Client"? "" : "," ); ?></h2>
				<?php
					if ( $clientName == "Client" ) { 
						//which means no user is loggedIn, so then continue to show the default page contents
						if ( !isset($_GET['authFailed']) )
						echo "
						<p>Login with your registered email address and password</p>";
						else if ( $_GET['authFailed'] == 1 )
						echo "
						<p style=\"color: red;\">Your credentials doesn't match. Please try again!</p>";
						?>
						<form name="clientForm" id="clientForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<p><input name="clientEmailAddress" id="clientEmailAddress" type="email" placeholder="Email Address"/></p>
							<p><input name="clientPassword" id="clientPassword" type="password" placeholder="Case-sensitive password"/></p>
							<p><input name="clientFormSubmit" id="clientFormSubmit" type="submit" class="mainBtn" value="LOGIN"></p>
						</form>
						<?php
					}
					else {
						//else means there is a user and its loggedIn and its either an admin or a client
						//then simply direct the user to go to dashboard.
						if ( $thisUser != null && $thisUser->usertypeId == 1) //it an admin
							echo "
							<p></p>
							<p> Please go to Admin Dashboard. </p><a href=\"./admin.php\">CLICK HERE</a>
							<p></p>						
							";						
						else if ( $thisUser != null && ( $thisUser->usertypeId == 2 || $thisUser->usertypeId == 3 || $thisUser->usertypeId == 4)) //it a client
							echo "
							<p></p>
							<p> Please go to Client Dashboard. </p><a href=\"./client.php\">CLICK HERE</a>
							<p></p>						
							";
					}
				?>
				<p>OR</p>						
					<div class="col-md-4"></div>
					<div class="col-md-4 contact-form">
						<form name="clientRegisterForm" id="clientRegisterForm" method="post" action="./client_register.php">
						<?php if ( $clientName == "Client" ) { ?>
							<input name="newClientRegisterFormSubmit" id="newClientRegisterFormSubmit" type="submit" class="mainBtn" value="REGISTER BY CLICKING HERE" />
						<?php } else { ?>
							<input name="newClientRegisterFormSubmit" id="newClientRegisterFormSubmit" type="submit" class="mainBtn" value="REGISTER NEW CLIENT BY CLICKING HERE" />
						<?php } ?>
						</form>
					</div>
					<div class="col-md-4"></div>
		</div> <!-- /.heading-section -->
	</div> <!-- /.row -->
</div> <!-- /.container -->
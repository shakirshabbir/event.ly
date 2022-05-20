<div class="container">
	<div class="row">
		<div class="heading-section col-md-12 text-center">
				<h2>Dear Attendee,</h2>
				<p>Enter here with your Invitee Reference Code</p>
				<form name="attendeeForm" id="attendeeForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<p><input pattern=".{10,10}" type="text" name="attendeeRefCode" id="attendeeRefCode" placeholder="10-digits Invitee Ref Code" required />
					<input name="attendeeRefCodeSubmit" id="submit13" type="submit" class="mainBtn" value="ENTER"></p>
				</form>
				<?php
						if ( $attendeeLoginFailed ){
							echo "<p id=\"refcodefailed\" style=\"color: red;\">Your invitee reference code does not match our record!</p>";
						?>
						<?php	    echo '<script src="https://code.jquery.com/jquery-1.10.2.js"></script>'; ?>
						<script>

							var offset = 20; //Offset of 20px

							$('html, body').animate({
								scrollTop: $("#refcodefailed").offset().top + offset
							}, 1000);

						</script>						
						<?php } ?>
				<p>OR</p>
				<p>Enter here with your registered email address</p>
				<p><input type="email" id="registeredEmailAddress" placeholder="Email address" required />
				<input name="submitEmail" id="submitEmail" type="submit" class="mainBtn" value="ENTER"></p>						
				<!--<p>!Sorry we cannot find an attendee with the above email address</p>-->
				<!--<p>Please re-check your email address and try again!</p>-->
			</form>
		</div> <!-- /.heading-section -->
	</div>
</div> <!-- /.container -->
<div class="col-md-2">
	<form name="redirectDashboardForm" method="post" action="client.php">
		<p><input style="min-width:120px;" name="redirectDashboardSubmit" id="redirectDashboardSubmit" type="submit" class="mainBtn" value="DASHBOARD"></p>
	</form>
	<br />
		<form name="logoutClientForm" method="post" action="logout_script.php">
		<p><input style="min-width:120px;" name="logoutClientSubmit" id="logoutClientSubmit" type="submit" class="mainBtn" value="LOGOUT"></p>
	</form>			
	<br />
</div> <!-- /.col-md-2 -->

<div class="col-md-2">						
	<!--BLANK-->
</div> <!-- /.col-md-2 -->

<div class="col-md-4">
	<div class="heading-section text-center">
		<h2><?php if($thisUser->usertypeId==3) echo 'ORGANIZER'; else echo 'CLIENT'; ?></h2>
		<p><?php echo $thisUser->userLname; ?>, <?php echo " ". $thisUser->userFname ;?></p>
		<p><?php echo $thisUser->userContactNumber; ?></p>
		<?php if($thisUser->usertypeId==3) echo '<p>COMPANY: '.$thisUser->userOwnerName.'</p>'; ?>
	</div>					
</div> <!-- /.col-md-4 -->

<div class="col-md-4">
	<!--BLANK-->
</div> <!-- /.col-md-4 -->
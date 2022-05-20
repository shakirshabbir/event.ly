<?php
/*
	Grid shows:
		 Last Name
		,First Name
		,Email Address
		,Contact Number
		,Client Type
		,Update
		,Remove
*/
	$buttonText = "Add User";
	$fetchUsertypeId = 0; //Default: fetch all users
	
	switch ($fetchUsertypeId){
		case 0: $buttonText = "Add User"; break;
		case 2: $buttonText = "Add Company"; break;
		case 4: $buttonText = "Add Individual"; break;		
		default: 
		$buttonText = "Add User";
	}
?>
<table class="rwd-table col-md-12">
  <tr>
	<th>Full Name</th>
	<!--<th>First Name</th>-->
	<th>Email Address</th>
	<th>Contact Number</th>
	<th>Client Type</th>
	<th></th>	
	<?php //if ( $thisUser!=null && ( $thisUser->usertypeId==1 || $thisUser->usertypeId==4) ) { ?>
	<?php if ( $thisUser!=null && ( $thisUser->usertypeId==1) ) { ?>
	<?php 	if ( $fetchUsertypeId!=3 ) { //3 is an organizer fetch, so dont want to display Add User/Organizer since an organizer can only be added by company ?>
	<th colspan="2">
		<form method="post" action="./client_register.php" name="clientRegisterRedirectForm" id="clientRegisterRedirectForm">
			<input name="clientRegisterRedirectSubmit" id="clientRegisterRedirectSubmit" type="submit" class="mainBtn" value="<?php echo $buttonText; ?>" />
		</form>
	</th>			
	<?php 	} ?>	
	<?php } else {?>
	<th></th><th></th>
	<?php } ?>
  </tr>
  
	<?php
		//Get All events
		
		$errorMessage = '';
		$results = User::getAllUsers($fetchUsertypeId, $errorMessage);
		if ( $errorMessage!='' ) {//means some exception occured while fetching
			echo '<tr>';
			echo '<td data-th="Full Name" colspan="5">'.$errorMessage.'</td>';
			echo '</tr>';
		} else if (count($results) <= 0){
			$zeroRowsMessage = "No records found in the database!";
			echo '<tr>';
			echo '<td data-th="Full Name" colspan="5">'.$zeroRowsMessage.'</td>';
			echo '</tr>';			
		} else { // count !<= 0 so there are rows
			foreach($results as $row) {
				echo '<tr>';
				echo '<td data-th="Full Name">'.$row['userFullName'].'</td>';
				//echo '<td data-th="First Name">'.$row['userFname'].'</td>';
				echo '<td data-th="Email Address">'.$row['userEmailAddress'].'</td>';
				echo '<td data-th="Contact Number">'.$row['userContactNumber'].'</td>';
				echo '<td data-th="Client Type">'.$row['usertype'].'</td>';
				//LINK
				echo '<td data-th=""><a href="client.php?userId='.$row['userId'].'">Link</a></td>';
				//UPDATE USER
				echo '<td data-th=""><a href="client_update.php?userId='.$row['userId'].'">Update</a></td>';
				//REMOVE USER
				echo '<td data-th="">';
				echo 	'<form action="" method="post">';
				echo 		'<input type="hidden" name="userIdDelete" id="userIdDelete" value="'.$row['userId'].'" />';
				echo 		'<input type="submit" name="userDeleteFormSubmit" id="userDeleteFormSubmit" class="tblButton" value="Remove" />';
				echo 	'</form>';
				echo '</td>';												
				
				echo '</tr>';
			}
		}	
	?>
</table>
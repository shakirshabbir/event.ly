<table class="rwd-table col-md-12">
  <tr>
	<th>Invitee Name</th>
	<th>Inivitation Ref</th>
	<th>Invitee Email</th>
	<th>Event</th>
	<th>Invitation Status</th>
	<th>Checkin Status</th>
	<th></th>
	<th></th>
  </tr>
  
	<?php
		//Get All events
		$results = Invitee::getUserCheckins($adminAccess? $adminAccessUser->userId: $thisUser->userId);
		if (count($results) <= 0){
			$zeroRowsMessage = "No records found in the database!";
			echo '<tr>';
			echo '<td data-th="Invitee Name" colspan="5">'.$zeroRowsMessage.'</td>';
			echo '</tr>';			
		} else { // count !<= 0 so there are rows				
			if (count($results) > 0){
				foreach($results as $row) {
					echo '<tr>';
					echo '<td data-th="Invitee Name">'. $row['attendeeName'].'</td>';
					echo '<td data-th="Inivitation Ref">'. $row['attendeeRefCode'].'</td>';
					echo '<td data-th="Invitee Email">'. $row['attendeeEmailAddress'].'</td>';									
					echo '<td data-th="Event"><a href="event.php?eventId='.$row['eventId'].'">'.$row['eventTitle'].'</a></td>';														
					echo '<td data-th="Invitation Status">'.$row['invitationStatus'].'</td>';
					//CHECKIN STATUS
					echo '<td data-th="Checkin Status">'.($row['checkInStatus']!="NotCheckedIn" ? "Checked in" : "Not checked in");
					echo ' ('.($row['checkInStatus']!="NotCheckedIn" ? $row['checkInTime'] : "!").')';
					echo '</td>';
					//UPDATE RESPONE
					echo '<td data-th="">';
					if ($row['checkInStatus']=="NotCheckedIn")
					echo 	'<a href="rsvp.php?attendeeId='.$row['attendeeId'].'">Update Response</a>';
					echo '</td>';
					
					echo '<td data-th="">';
					if ($row['checkInStatus']=="NotCheckedIn") {									
					echo 	'<form action="" method="post">';
					echo 		'<input type="hidden" name="attendeeIdDelete" id="attendeeIdDelete" value="'.$row['attendeeId'].'" />';
					echo 		'<input class="tblButton" type="submit" name="attendeeDeleteFormSubmit" id="attendeeDeleteFormSubmit" value="Remove" />';
					echo 	'</form>';
					}
					echo '</td>';
					echo '</tr>';
				}
				?>
				<?php
			}	
		}
	?>
</table>
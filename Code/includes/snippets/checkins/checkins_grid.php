<table class="rwd-table col-md-12">
  <tr>
	<th><input type="checkbox" onclick="albuwi(this);" />&nbsp;Checkin All</th>
	<!--<th>Attendee Ref</th>-->
	<th>Attendee Email</th>
	<th>Event</th>
	<th>Invitation Status</th>
	
	<th>Checkin Status</th>
	<th>Checkin time</th>
	<th></th>
	<!--<th></th>-->
  </tr>
  
	<?php
		//Get All events
		if (count($results) > 0){
			?>
			<form name="checkinSubmitForm" id="checkinSubmitForm" method="post" action="">
			<?php
			foreach($results as $row) {
				echo '<tr>';
				echo '<td><input type="checkbox" name="checkins[]" id="checkins" value="'.$row['attendeeId'].'"';
				if ( $row['checkInStatus'] != "NotCheckedIn") echo ' checked="checked" disabled="true"';
				echo ' />&nbsp;';
				echo '<a href="attendee.php?attendeeId='.$row['attendeeId'].'">'. $row['attendeeRefCode'].'</a>';
				echo '</td>';
				?>									
				<?php
				//echo '<td data-th="Attendee Ref"><a href="attendee.php?attendeeId='.$row['attendeeId'].'">'. $row['attendeeRefCode'].'</a></td>';				
				echo '<td data-th="Attendee Email">'. $row['attendeeEmailAddress'].'</td>';
				echo '<td data-th="Event"><a href="event.php?eventId='.$row['eventId'].'">'.$row['eventTitle'].'</a></td>';																		
				echo '<td data-th="Invitation Status">'.$row['invitationStatus'].'</td>';
				echo '<td data-th="Checkin Status">'.($row['checkInStatus']!="NotCheckedIn" ? "Checked in" : "Not checked in!").'</td>';
				echo '<td data-th="Checkin time">'.($row['checkInStatus']!="NotCheckedIn" ? $row['checkInTime'] : "None!").'</td>';									
				echo '<td data-th="">';
				if ($row['checkInStatus']=="NotCheckedIn")
				echo 	'<a href="rsvp.php?attendeeId='.$row['attendeeId'].'">Update Response</a>';
				else
				echo	'';
				echo '</td>';
				/*echo '<td data-th="">';
				echo 	'<form action="" method="post">';
				echo 		'<input type="hidden" name="attendeeId" id="attendeeId" value="'.$row['attendeeId'].'" />';
				echo 		'<input class="tblButton" type="submit" name="attendeeDeleteFormSubmit" id="attendeeDeleteFormSubmit" value="Remove" />';
				echo 	'</form>';
				echo '</td>';
				*/
				echo '</tr>';
			}
			?>
			<?php
		}	
	?>
</table>
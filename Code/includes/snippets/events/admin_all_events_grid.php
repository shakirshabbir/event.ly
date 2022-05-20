<table class="rwd-table col-md-12">
  <tr>
	<th>Event</th>
	<th>Owner Name</th>
	<th>Owner Type</th>
	<th>Date</th>
	<th>Start Time</th>
	<th>End Time</th>
	<th>Organizer</th>				
	<th></th>
	<th></th>
	<th></th>						
  </tr>
  
	<?php
		//Get All events
		$results = Event::getEventsForOwner();
		if (count($results) > 0){
			foreach($results as $row) {
				echo '<tr>';
				echo '<td data-th="Event">'.$row['eventTitle'].'</td>';
				echo '<td data-th="Owner Name">'.$row['ownerName'].'</td>';
				echo '<td data-th="Owner Type">'.$row['ownerUserType'].'</td>';								
				echo '<td data-th="Date">'. $row['eventDate'].'</td>';
				echo '<td data-th="Start Time">'.$row['eventStartTime'].'</td>';
				echo '<td data-th="End Time">'.$row['eventEndTime'].'</td>';
				echo '<td data-th="Organizer">'.$row['organizerName'].'</td>';
				//LINK
				echo '<td data-th=""><a href="event.php?eventId='.$row['eventId'].'">Link</a></td>';
				//UPDATE
				echo '<td data-th=""><a href="event_update.php?eventId='.$row['eventId'].'">Update</a></td>';
				//REMOVE
				echo '<td data-th="">';
				echo 	'<form action="" method="post">';
				echo 		'<input type="hidden" name="eventIdDelete" id="eventIdDelete" value="'.$row['eventId'].'" />';
				echo 		'<input type="submit" name="eventDeleteFormSubmit" id="eventDeleteFormSubmit" value="Remove" />';
				echo 	'</form>';
				echo '</td>';												
				echo '</tr>';
			}
		}	
	?>
</table>
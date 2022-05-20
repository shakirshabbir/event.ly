<?php if ($thisUser!=null && $event!=null && $thisUser->authenticateEventModifier($event->eventId) ) {?>
<div class="content-section level-2-pages content-level-2" id="event-checkins">
	<div class="container">
		<div class="row">
			<div class="heading-section">
				<h2>Checkins</h2>
				<?php if ($checkinSubmitSuccess) { ?>
				<p>Checkins have been posted successfully!</p>
				<?php } ?>
				<?php /*if ($errorMessageLog == "" && !$checkinSubmitSuccess) { ?>
				<p>All checked attendees were already posted!</p>						
				<?php }*/ ?>		
			</div>
			<div style="max-height:270px; overflow-y:scroll;">					
			<table class="rwd-table col-md-12">
			  <tr>
				<th><input type="checkbox" onclick="albuwi(this);" />&nbsp;Checkin All</th>
				<th>Attendee Email</th>
				<th>Invitation Status</th>
				<th>Checkin Status</th>
				<th>Checkin time</th>
				<th></th>
				<!--<th></th>-->
			  </tr>
			  
				<?php
					//Get All events
					$results = Invitee::getEventCheckins($event->eventId);
					if (count($results) > 0){
						?>
						<form name="checkinSubmitForm" id="checkinSubmitForm" method="post" action="">
						<?php
						foreach($results as $row) {
							echo '<tr>';
							echo '<td><input type="checkbox" name="checkins[]" id="checkins" value="'.$row['attendeeId'].'"';
							if ( $row['checkInStatus'] != "NotCheckedIn") echo ' checked="checked" disabled="true"';
								echo ' />';
							//echo '<td/>';
							?>									
							<?php
							echo '<td data-th="Attendee Email">'. $row['attendeeEmailAddress'].'</td>';
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
			</div>
		</div> <!-- /.row -->
		
		<?php if (count($results) > 0) { ?>
		<div class="row">
			<br />
			<input type="hidden" name="eventId" id="eventId" value="<?php echo $event->eventId; ?>" />
			<input name="checkinSubmit" id="checkinSubmit" type="submit" class="mainBtn" value="Submit Checkins" />
			</form>					
			<!--<input name="btnCheckinSubmit" id="btnCheckinSubmit" type="button" class="mainBtn" value="Submit Checkins" />-->
		</div> <!-- /.row -->	
		<?php } ?>
		
	</div> <!-- /.container -->
</div> <!-- /.content-section -->
<?php } ?>		
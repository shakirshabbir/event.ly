<?php	require_once ('./includes/classes/event.php');	?>

<div class="container">
	
	<div class="row">
		<div class="heading-section col-md-12 text-center">
			<h2>Events</h2>
			<p>Exciting events through Evently</p>
		</div> <!-- /.heading-section -->
	</div> <!-- /.row -->
	
	<div class="row">
		<div class="heading-section col-md-12">
			<?php
				//Get All events
				$results = Event::getEventsForOwner();
				if (count($results) > 0){
					foreach($results as $row) {
						echo '<p><h2 class="tableCaptionHeading"><a href="event.php?eventId='.$row['eventId'].'">'.$row['eventTitle'].'</a></h2></p>';
						//echo '<p><input type="button" onclick="window.location.href = \'event.php?eventId='.$row['eventId'].'\';" value="'.$row['eventTitle'].'" />';
						echo ' '.$row['eventDate']. ' '. $row['eventStartTime']. ' - '. $row['eventEndTime'] .'</p>';
					}
				}	
			?>			
		</div>									
	</div> <!-- /.row -->
	
</div> <!-- /.container -->
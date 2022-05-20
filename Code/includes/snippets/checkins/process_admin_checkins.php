<?php
	$results = Invitee::getEventCheckins();
?>
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
				<?php require_once('./includes/snippets/checkins/checkins_grid.php'); ?>
			</div>
		</div> <!-- /.row -->
		
		<?php if (count($results) > 0) { ?>
		<div class="row">
			<br />
			<!--<input type="hidden" name="eventId" id="eventId" value="<?php echo $event->eventId; ?>" />-->
			<input name="checkinSubmit" id="checkinSubmit" type="submit" class="mainBtn" value="Submit Checkins" />
			</form>					
			<!--<input name="btnCheckinSubmit" id="btnCheckinSubmit" type="button" class="mainBtn" value="Submit Checkins" />-->
		</div> <!-- /.row -->	
		<?php } ?>
		
	</div> <!-- /.container -->
</div> <!-- /.content-section -->

<script type="text/javascript">
	function albuwi(obj){
		var checkboxes = document.getElementsByName("checkins[]");
		var length = checkboxes.length;
		for (var i=0; i<length; i++) {
			if(!checkboxes[i].disabled) checkboxes[i].checked = obj.checked;
		}	
	}			
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" />

<script>
	$(function() {
		$( "#eventDate" ).datepicker();
	});
</script>	

<script>
	$('#eventStartTime').timepicker({
		'showDuration': true,
		'timeFormat': 'g:ia'
	});
	$('#eventEndTime').timepicker({
		'showDuration': true,
		'timeFormat': 'g:ia'
	});	
</script>			
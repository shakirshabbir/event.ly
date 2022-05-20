<?
	/*
		REPORT ID = 5
		REPORT: Attendee Count Report per Event
	*/
	
?>
<?php
	$results = Statistics::getAttendeeCount();
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

	var data = google.visualization.arrayToDataTable([
	  ['Event Title', 'Attendance']	  
	 //,['Event Title', 'Attendance']	  
<?php

	if ( ($results!=null) && count($results>0) ) {
		foreach($results as $row){
			$string = addslashes($row['eventTitle']);
			echo ",['{$string}',{$row['attendeeCount']}]";
		}
	}

?>	  
	]);

	var options = {
	  title: '<?php echo $reportCaption; ?>'
	};

	var chart = new google.visualization.PieChart(document.getElementById('<?php echo 'report'.$reportId; ?>'));

	chart.draw(data, options);
  }
</script>
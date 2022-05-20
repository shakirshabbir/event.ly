<?
	/*
		REPORT ID = 2
		REPORT: Organizer wise Events Report
	*/
	
?>
<?php
	$results = Statistics::getOrganizerEventsStatistics();
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

	var data = google.visualization.arrayToDataTable([
	  ['Company', 'Number of events']	  
<?php

	if ( ($results!=null) && count($results>0) ) {
		foreach($results as $row){
			echo ",['{$row['organizerName']}',{$row['eventCount']}]";
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
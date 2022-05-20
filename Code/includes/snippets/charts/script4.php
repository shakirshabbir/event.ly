<?
	/*
		REPORT ID = 4
		REPORT: User Count Report
	*/
	
?>
<?php
	$results = Statistics::getUserTypeStatistics();
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['corechart', 'bar']});
  google.setOnLoadCallback(drawChart);
  
  function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['User Type', 'Count',]
<?php

	if ( ($results!=null) && count($results>0) ) {
		foreach($results as $row){
			echo ",['{$row['usertype']}',{$row['usertypeCount']}]";
		}
	}
?>	  
	]);
	
	var options = {
		title: '<?php echo $reportCaption; ?>',
		chartArea: {width: '40%'},
		
		hAxis: {
		  title: 'User Types',
		  minValue: 0
		},
		vAxis: {
		  title: 'Count'
		}
	};	

	var chart = new google.visualization.ColumnChart(document.getElementById('<?php echo 'report'.$reportId; ?>'));

	chart.draw(data, options);
  }
</script>
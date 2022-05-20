<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart', 'timeline']}]}"></script>
   
    <div id="chart_div"></div>

	 
google.load('visualization', '1', {packages: ['corechart', 'line']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
  var data = google.visualization.arrayToDataTable([
	 ['Time', 'Audience']
	,[new Date(2014, 10, 15, 19, 33), 1]
	,[new Date(2014, 10, 15, 19, 35), 2]
	,[new Date(2014, 10, 15, 19, 36), 3]	
	,[new Date(2014, 10, 15, 19, 38), 4]		
	,[new Date(2014, 10, 15, 19, 39), 5]			
  ]);

      var options = {
        height: 450,
curveType: 'function',          
      };

var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

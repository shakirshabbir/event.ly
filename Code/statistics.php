<?php	require_once ('./includes/classes/user.php');	?>
<?php	require_once ('./includes/snippets/check_loggedin_client.php');	?>

<?php	require_once ('./includes/classes/statistics.php');	?>

<?php
	$reportId = isset($_REQUEST['reportId']) ? $_REQUEST['reportId'] : 0;
	$showReport = ( isset($reportId) && $reportId!=0 ) ? true : false;
	
	$reportTitle = "Default Title";
	switch($reportId)
	{
		case 1: $reportTitle = "REPORT: Company wise Events Statistics"; break;
		case 2: $reportTitle = "REPORT: Organizer wise Events Statistics"; break;
		case 3: $reportTitle = "REPORT: Individual wise Events Statistics"; break;		
		case 4: $reportTitle = "Report: User Type Statistics"; break;				
		case 5: $reportTitle = "Report: Event wise Attendance/Checkins Statistics"; break;			
		default: break;
	}
	
	$reportCaption = "Default Caption";
	switch($reportId)
	{
		case 1: $reportCaption = "Number of Events Per Company Statistics"; break;
		case 2: $reportCaption = "Number of Events Per Organizer Statistics"; break;
		case 3: $reportCaption = "Number of Events Per Individual Statistics"; break;		
		case 4: $reportCaption = "Number of Users Per User Type Statistics"; break;				
		case 5: $reportCaption = "Total Attendance/Checkins Per Event Statistics"; break;			
		default: break;
	}	
	
	$scriptLocation = "index.php";
	switch($reportId)
	{
		case 1: $scriptLocation = "./includes/snippets/charts/script1.php"; break;
		case 2: $scriptLocation = "./includes/snippets/charts/script2.php"; break;
		case 3: $scriptLocation = "./includes/snippets/charts/script3.php"; break;		
		case 4: $scriptLocation = "./includes/snippets/charts/script4.php"; break;				
		case 5: $scriptLocation = "./includes/snippets/charts/script5.php"; break;			
		default: break;
	}
	
?>
<?php
	$navigationMenu = '
	<ul class="menu-first">
	<li><a href="index.php">Home</a></li>
	<li><a href="attendee.php">Attendee</a></li>
	<li><a href="client.php">Client</a></li>
	<li><a href="event.php">Events</a></li>
	<li><a href="index.php#contact">Contact</a></li>
	</ul>';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<?php	require_once ('./includes/head_info.php');	?>
		<?php
				if ($showReport){
					require_once ($scriptLocation);
				}
		?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <div class="site-main" id="sTop">
            <div class="site-header">
				<?php	require_once ('./includes/site_header.php');	?>				
			</div> <!-- /.site-header -->
        </div> <!-- /.site-main -->
		
		<?php	if ($showReport) {	?>
		<div class="content-section level-2-pages" id="report_div">
			<div class="container">
			
				<div class="row">
					<div class="heading-section text-center">
						<h2>Statistics</h2><br /><br />
						<h2 class="tableCaptionHeading"><a href="statistics.php">Back to All Reports</a></h2><br />
						<p><h2><a><?php echo $reportTitle; ?></a></h2></p>
					</div>
				</div><!-- /.row -->
						
				<?php	require_once ('./includes/snippets/statistics/report_container.php');	?>			

			</div> <!-- /.container -->
		</div> <!-- /#report_div -->
		<?php	}	?>

		<?php	if (!$showReport) {	?>
		<div class="content-section level-2-pages" id="list_all_reports">
				<?php	require_once ('./includes/snippets/statistics/list_all_statistics.php');	?>				        
		</div> <!-- /#portfolio -->
		<?php	}	?>		
            
        <div id="footer">
			<?php	require_once ('./includes/footer.php');	?>		
        </div> <!-- /#footer -->
        
			<?php	require_once ('./includes/footer_script.php');	?>	
					
    </body>
	
</html>	
<div class="main-header">
	<div class="container">
		<div id="menu-wrapper" <?php if (isset($navigationMenu) && $navigationMenu != '') echo 'class="level-2-pages"'; ?>>
			<div class="row">
				<div class="logo-wrapper col-md-2 col-sm-2">
					<h1>
						<a href="index.php">Evently</a>
					</h1>
				</div> <!-- /.logo-wrapper -->
				<div class="col-md-10 col-sm-10 main-menu text-right">
					<div class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></div>
					
					<?php
						if (isset($navigationMenu) && $navigationMenu != ''){
							echo $navigationMenu;
						}
						else {
					?>
						<ul class="menu-first">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#attendee">Attendee</a></li>
							<li><a href="#client">Client</a></li>
							<li><a href="event.php">Events</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					<?php
						}
					?>
				</div> <!-- /.main-menu -->
			</div> <!-- /.row -->
		</div> <!-- /#menu-wrapper -->                        
	</div> <!-- /.container -->
</div> <!-- /.main-header -->
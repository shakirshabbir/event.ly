<!-- Google Map -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="./js/vendor/jquery.gmap3.min.js"></script>

<!-- Google Map Init-->
<script type="text/javascript">
	jQuery(function($){
		$('#map_canvas').gmap3({
			marker:{
			
				address: '5500 N St Louis Ave, Chicago, IL 60625, United States' 
			},
				map:{
				options:{
				zoom: 15,
				scrollwheel: false,
				streetViewControl : true
				}
			}
		});
	});
</script>
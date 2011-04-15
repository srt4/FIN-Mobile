<?php
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$cat = $_REQUEST['cat'];
?>
 <!DOCTYPE html> 
<html> 
	<head> 
	<title>Page Title</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
       <style type="text/css">
        body { background: #dddddd;} 
		.gmap { height: 330px; width: 100%; margin: 0px; padding: 0px }
	</style>

</head> 
<body> 

<div data-role="page" id="page-map1">

	<div data-role="header">
		<h1>FindItNow > <?=$cat_readable?></h1>
	</div><!-- /header -->

	<div data-role="content">	
    
    <div id="map1" class="gmap"></div>
	
	<script type="text/javascript">
	    var map1, latlng1, options1, infowindow1, marker1, contentString1;
	    function initialize() {

	        latlng1 = new google.maps.LatLng(37.4219955, -122.0860484);
	        options1 = { zoom: 12, center: latlng1, mapTypeId: google.maps.MapTypeId.ROADMAP };
	        map1 = new google.maps.Map(document.getElementById("map1"), options1);

	    }
	    $('#page-map1').live('pagecreate', function () {

	        //console.log("pagecreate");
            initialize();
	    });

	    $('#page-map1').live('pageshow', function () {

	        //console.log("pageshow");
            google.maps.event.trigger(map1, 'resize');
	        map1.setOptions(options1);

             contentString1 = '<div>'+
                '<p><b>Google</b><br />1600 Amphitheatre Parkway<br />' +
                'Mountain View, CA 94043</p>'+
                '</div>';

            infowindow1 = new google.maps.InfoWindow({
                content: contentString1
            });

            marker1 = new google.maps.Marker({
                position: latlng1, 
                map: map1
            });

            google.maps.event.addListener(marker1, 'click', function() {
                infowindow1.open(map1, marker1);
            });   

            infowindow1.open(map1, marker1);
	    });

        $('#page-map1').live('pagehide', function () {

            //console.log("pagehide");
            infowindow1.close();
	    });
		
	</script> 
	</div><!-- /content -->

	<? include('r/footer.php'); ?><!-- /footer -->
</div><!-- /page -->

</body>
</html><!-- /page -->
</body>
</html>

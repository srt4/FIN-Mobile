<?php
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$name = $_REQUEST['name'];

// todo: I want to fix this
$map_id = rand(10e16, 10e20);
echo base_convert($n, 10, 36);

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
		.gmap { width: 100%; margin: 0px; padding: 0px }
		.command-no-cache { padding: 0px !important }
	</style>

</head> 
<body>  

<div data-role="page" id="page-map<?=$map_id?>" style="width:100%; height:100%">

	<div data-role="header">
		<h1>FindItNow > <?php $title=explode("<br />", $name); print $title[0]; ?></h1>
	</div><!-- /header -->

<div data-role="content" class="command-no-cache">	
    
    <div id="map<?=$map_id?>" class="gmap"></div>
	
	<script type="text/javascript">
	    var map<?=$map_id?>, latlng<?=$map_id?>, options<?=$map_id?>, infowindow<?=$map_id?>, marker<?=$map_id?>, contentString<?=$map_id?>;
	    function initialize() {

	        latlng<?=$map_id?> = new google.maps.LatLng(<?=$lat/1000000?>, <?=$lon/1000000?>);
	        options<?=$map_id?> = { zoom: 17, center: latlng<?=$map_id?>, mapTypeId: google.maps.MapTypeId.ROADMAP };
	        map<?=$map_id?> = new google.maps.Map(document.getElementById("map<?=$map_id?>"), options<?=$map_id?>);

	    }
	    $('#page-map<?=$map_id?>').live('pagecreate', function () {

	        //console.log("pagecreate");
            initialize();
	    });

	    $('#page-map<?=$map_id?>').live('pageshow', function () {

	        //console.log("pageshow");
            google.maps.event.trigger(map<?=$map_id?>, 'resize');
	        map<?=$map_id?>.setOptions(options<?=$map_id?>);

             contentString<?=$map_id?> =
                '<?=addslashes($name)?>';

            infowindow<?=$map_id?> = new google.maps.InfoWindow({
                content: contentString<?=$map_id?>
            });

            marker<?=$map_id?> = new google.maps.Marker({
                position: latlng<?=$map_id?>, 
                map: map<?=$map_id?>
            });

            google.maps.event.addListener(marker<?=$map_id?>, 'click', function() {
                infowindow<?=$map_id?>.open(map<?=$map_id?>, marker<?=$map_id?>);
            });   

            infowindow<?=$map_id?>.open(map<?=$map_id?>, marker<?=$map_id?>);
	    });

        $('#page-map<?=$map_id?>').live('pagehide', function () {

            //console.log("pagehide");
            infowindow<?=$map_id?>.close();
	    });
$('[data-role=content]')
  .height(
    $(window).height() - 
    (5 + $('[data-role=header]').last().height() 
    + $('[data-role=footer]').last().height())
  );
// tell google to resize the map
google.maps.event.trigger(map<?=$map_id?>, 'resize');		
	</script> 
	</div><!-- /content -->

	<? include('r/footer.php'); ?><!-- /footer -->
</div><!-- /page -->

</body>
</html><!-- /page -->
</body>
</html>

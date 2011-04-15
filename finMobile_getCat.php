<?php
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$cat = $_REQUEST['cat'];
// Maybe this should change in the future
$cat_readable = $cat == "atms" ? "ATMs" : ucwords(str_replace("_", " ", $cat)); 
// find stuff for the UW
$jsonurl = "http://fincdn.org/getAllLocations.php?lat=47654799&long=-122307776&rad=6020";
$jsonurl .= "&cat=" . $cat; 

$json = file_get_contents($jsonurl,0,null,null);
$json_output = json_decode($json);

?>


<?php

//make the map of geopoints to buildings
class GeoPoint {
	public $lat;
	public $lon;
	
	function __construct($lat, $lon) {
		$this->lat = $lat;
		$this->lon = $lon;
	}
}

// building class, this may be a useful datatype 
class Building {
	public $lat;
	public $lon;
	
	function __construct($lat, $lon, $name) {
		$this->lat = $lat;
		$this->lon = $lon;
		$this->name = $name;
	}  
}

// **NOTE** in PHP, === compares if objects are the same instance; == compares if they are the same based on values

$jsonurl = "http://fincdn.org/getBuildings.php?lat=47654799&long=-122307776";
$json = file_get_contents($jsonurl,0,null,null);
$building_json = json_decode($json);
$building_array = array();
echo "<pre>";

// Build the map of building lat/lon pairs, to building name
foreach ($building_json as $index=>$item) {
	$geopoint = new GeoPoint($item->lat, $item->long);
	$building = new Building($item->lat, $item->long, $item->name);
	$building_array[(string)$geopoint->lat][(string)$geopoint->lon] = $building;
}
?>
 <!DOCTYPE html> 
<html> 
	<head> 
	<title>Page Title</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.js"></script>
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>FindItNow > <?=$cat_readable?></h1>
	</div><!-- /header -->

	<div data-role="content">	
		<ul id="itemList" data-role="listview" data-theme="c"> 
			<?php
				foreach($json_output as $index=>$item) {
					echo "<li> <h2>" . $building_array[(string)$item->lat][(string)$item->long]->name . "</h2>";
					echo  str_replace('\n', "<br />", $item->info) . "</li>";
				}
			?>
        </ul> 
        <?php /*
				$('<li></li>')
			.hide()
			.append('<h1><em><a href="' + gmapsLink + '">'+ item.building + '</a></em></h1><h3>'+ item.info + '</h3><span class="ui-li-aside" style="margin-right:-75px; width:75px; font-size:12px; color:' + distColor + '"><span style="font-size:18px">' + item.distance + '</span> mi <br /> <span style="font-size:12px; color: #222">' + item.walking + ' min</span></span>')
			.appendTo('#wikiList')
			.show();	
			*/ ?>	
	</div><!-- /content -->

	<? include('r/footer.php'); ?><!-- /footer -->
</div><!-- /page -->

</body>
</html>
div><!-- /page -->

</body>
</html>

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

// item class.
class Item {
	public $lat;
	public $lon;
	public $info;
	public $distance;
	public $floor;
	
	function __construct($latItem, $lonItem, $info, $floor=-9) {
		$this->lat = $latItem;
		$this->lon = $lonItem;
		$this->info = $info;
		$this->floor = $floor;
	}
}

// building class, this may be a useful datatype 
class Building {
	public $lat;
	public $lon;
	public $name;
	public $items;
	public $distance; 
	
	function __construct($latItem, $lonItem, $name) {
		$this->lat = $latItem;
		$this->lon = $lonItem;
		$this->name = $name;
		$this->items = array();
		global $lat; global $lon;
		$this->distance = $this->distance($lat, $lon);
	}  
	
	// 
	function distance($lat1, $lon1, $unit = "m") { 
		// reassign the variables to work with this existing code without making it confusing
		$lat2 = $this->lat;
		$lon2 = $this->lon;

		// now let's convert it to actual lat/lons
		$lat2 /= 1000000;
		$lon2 /= 1000000;
			
		// Actual calculations here.
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K")
			return ($miles * 1.609344); 
		else if ($unit == "N")
			return ($miles * 0.8684);
		else
			return $miles;
	}
	
	// compare distances, helpful for sorting buildings
	function _cmpDist($buildA, $buildB) {
		if ($buildA->distance == $buildB->distance) {
			return 0;
		}
			return ($buildA->distance < $buildB->distance) ? -1 : 1;
	}
}

$jsonurl = "http://fincdn.org/getBuildings.php?lat=47654799&long=-122307776";
$json = file_get_contents($jsonurl,0,null,null);
$building_json = json_decode($json);
$building_array = array();

// Build the map of building lat/lon pairs, to building name
foreach ($building_json as $index=>$item) {
	$geopoint = new GeoPoint($item->lat, $item->long);
	$building = new Building($item->lat, $item->long, $item->name);
	$building_array[(string)$geopoint->lat][(string)$geopoint->lon] = $building;
}

$overall_array = array();
// Go through the items, and add them to the appropriate buildings
foreach ($json_output as $index=>$item) {
	
	if (!isset($building_array[(string)$item->lat][(string)$item->long]))
		$building_array[(string)$item->lat][(string)$item->long] = new Building($item->lat, $item->long, "Outdoor Location");
	
	$building = $building_array[(string)$item->lat][(string)$item->long];
	
	$item = new Item($item->lat, $item->long, $item->info);
	
	array_push($building->items, $item);
	
	array_push($overall_array, $building);
}

usort($overall_array, array("Building", "_cmpDist"));
echo ("<!--");
print_r($overall_array);
echo("-->");
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>FindItNow</title> 
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
				foreach($overall_array as $building) {
					?>
					<li> 
						<h2>
							<?php
								$item = $building->items[0];
								$itemName = explode('\n', $item->info);
								$mapUrl = "getMap.php?lat=" . $item->lat . "&lon=" . $item->long . "&name=" . $itemName[0];
								$distColor = $building->distance > 0.5 ? "red" : "green";
							?>
							<a href="<?=$mapUrl?>"><?=$building->name?></a>
						</h2>
						<?php echo str_replace('\n', "<br />", $item->info); ?>
						
						<span class="ui-li-aside" style="margin-right:-75px; width:75px; font-size:12px; color:<?=$distColor?>">
						<span style="font-size:18px"><?=round($building->distance,2)?></span> mi <br /> <span style="font-size:12px; color: #222"><?=round($building->distance*25, 0)?> min</span></span>
					</li>
				<?php } ?>
        </ul> 
	</div><!-- /content -->

	<? include('r/footer.php'); ?><!-- /footer -->
</div><!-- /page -->

</body>
</html>
div><!-- /page -->

</body>
</html>

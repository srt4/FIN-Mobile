<?php
// Get the user's location, if they're providing it
$lat = isset($_REQUEST['lat']) ? $_REQUEST['lat'] : -1;
$lon = isset($_REQUEST['lon']) ? $_REQUEST['lon'] : -1;
$cat = $_REQUEST['cat'];

// Maybe this should change in the future
$cat_readable = $cat == "atms" ? "ATMs" : ucwords(str_replace("_", " ", $cat)); 
// find stuff for the UW
$jsonurl = "http://fincdn.org/getLocations.php?lat=47654799&long=-122307776&rad=6020";
if ($cat == "school_supplies")
    $jsonurl = "http://fincdn.org/getAllLocations.php?lat=47654799&long=-122307776&rad=6020";
$jsonurl .= "&cat=" . $cat; 


$json = file_get_contents($jsonurl,0,null,null);
$json_output = json_decode($json);

include('getCat.classes.php');

// JSON stuff for the buildings
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


// Taken from php.net ... goes through an array and tests if there's an object
// with a certain property
function property_in_array($array, $property, $value) {
    $flag = false;

    foreach($array as $index=>$object) {
        if(!is_object($object) || !property_exists($object, $property)) {
            return false;        
        }

        if($object->$property == $value) {
            $flag = $index;
        }
    }
    
    return $flag;
}


// This is where the final list of items will be stored
$overall_array = array();
// Go through the items, and add them to the appropriate buildings
foreach ($json_output as $index=>$item) {
	// Check if there's already an instantiated building object; if not, it's probably outdoors
	if (!isset($building_array[(string)$item->lat][(string)$item->long]))
		$building_array[(string)$item->lat][(string)$item->long] = new Building($item->lat, $item->long, "Outdoor Location");
	$building = $building_array[(string)$item->lat][(string)$item->long];
	$item = new Item($item->lat, $item->long, $item->info);
	array_push($building->items, $item);
	// Commented out because this pushes duplicate buildings; need ONE more foreach-loop
	//array_push($overall_array, $building);
}

// Although these are nested for-loops, this shouldn't add much runtime,
// because the second for-loop only has one iteration
foreach ($building_array as $subarray) {
    foreach ($subarray as $building) {
        if ($building->items != null) {
            array_push($overall_array, $building);
        }
    }
}

usort($overall_array, array("Building", "_cmpDist"));
/*echo ("<!--");
print_r($overall_array);
echo("-->");*/
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
		<ul id="itemList" data-role="listview" data-filter="true" data-theme="c"> 
			<?php
				foreach($overall_array as $building) {
					?>
					<li> 
						<?php
							$item = $building->items[0];
							$info = preg_replace( '/\n|\r/', '<br />', $item->info );
							$itemName = explode('\n', $item->info);
							$mapUrl = "getMap.php?lat=" . $item->lat . "&lon=" . $item->lon . "&name=" . urlencode($info);
							$distColor = $building->distance > 0.5 ? "red" : "green";
						?>
						<a href="<?=$mapUrl?>">
						<span style="font-size:13px">
							<u><?=$building->name?></u>
						</span>
						<br />
						<span style="font-size:12px">
						<?= $info ?>
						</span>
						<?php if (($building->distance != -1)) { ?>
						   <span class="ui-li-count" style="font-size:14px;color:<?=$distColor?>"><?=round($building->distance,2)?> mi</span>
						<?php } ?>
						</a>
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

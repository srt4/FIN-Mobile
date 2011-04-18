<?php

// This file contains the classes used by getCat.php - they are mostly just data storage, with
// some simple computations as well

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
		if ($lat == -1) $this->distance = -1;
		else $this->distance = $this->distance($lat, $lon);
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

?>

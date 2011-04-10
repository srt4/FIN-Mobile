// very hacky, I should narrow the scope of this variable ...
var cat = "stuff";
var currLoc = { lat: -1 , lon: -1};

$(document).ready(function(){
	// Add a click listener on the button to get the location data
	$('#getLocation').click(function(){
		// check if the location has been queried already
		if (currLoc.lat == -1 || currLoc.lon == -1) {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(onSuccess, onError);
			} else {
				// If location is not supported on this platform, disable it
				$('#getLocation').value = "Geolocation not supported";
				$('#getLocation').unbind('click');
			}
		}
	});

	// add listener for coffee... I don't want to have to do this for
	// every. freaking. category.
	$("#coffee").click(function() {
		if (navigator.geolocation) {
			cat = "coffee";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#coffee').value = "Geolocation not supported";
			$('#coffee').unbind('click');
		}		
	});
	$("#dining").click(function() {
		if (navigator.geolocation) {
			cat = "dining";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#dining').value = "Geolocation not supported";
			$('#dining').unbind('click');
		}		
	});
	$("#vending").click(function() {
		if (navigator.geolocation) {
			cat = "vending";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#vending').value = "Geolocation not supported";
			$('#vending').unbind('click');
		}		
	});
	$("#mailboxes").click(function() {
		if (navigator.geolocation) {
			cat = "mailboxes";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#mailboxes').value = "Geolocation not supported";
			$('#mailboxes').unbind('click');
		}		
	});
	$("#school_supplies").click(function() {
		if (navigator.geolocation) {
			cat = "school_supplies";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#school_supplies').value = "Geolocation not supported";
			$('#school_supplies').unbind('click');
		}		
	});
	$("#restrooms").click(function() {
		if (navigator.geolocation) {
			cat = "restrooms";
			navigator.geolocation.getCurrentPosition(onSuccess, onError);
		} else {
			// If location is not supported on this platform, disable it
			$('#restrooms').value = "Geolocation not supported";
			$('#restrooms').unbind('click');
		}		
	});
	buildingsArray = new Array();
	var buildingsJsonUrl = "http://fincdn.org/getBuildings.php";
	$.getJSON(buildingsJsonUrl, 
		function(json) {
			$.each(json, function(index, item){
				var array = new Array();
				array["LONG" + item.long + ""] = item.name;
				buildingsArray["LAT" + item.lat + ""] = array;
			});
		}
	);
	
});

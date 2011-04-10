// Useful little function
// http://stackoverflow.com/questions/1026069/capitalize-first-letter-of-string-in-javascript
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

var buildingsArray = new Array();
var itemsArray = new Array();
getBuildings();

function getBuildings() {
	var jsonUrl = "http://fincdn.org/getBuildings.php";
	$.getJSON(jsonUrl, 
		function(json) {
			$.each(json, function(index, item){
				var array = new Array();
				array["LONG" + item.long + ""] = item.name;
				buildingsArray["LAT" + item.lat + ""] = array;
			});
		}
	);
}
var jsonRequest;
function getCategory() {
	var jsonSuccess = false; 
	document.getElementById("loading").style.display = "block";
	if (jsonRequest != null) jsonRequest.abort();
	cat = document.getElementById("cat").value;
	jsonRequest = $.getJSON("http://fincdn.org/getAllLocations.php?lat=47654799&long=-122307776&cat=" + cat.toLowerCase() + "&rad=6020", 
		function(json) {
			document.getElementById("results").style.display = "block";
			$.each(json, function(index, item) {
				var geoConst = 1000000;
				building = buildingsArray["LAT" + item.lat]["LONG" + item.long];
				var googleMapsUrl = "http://maps.google.com/maps?z=17&q=" + building + "@" + item.lat / geoConst + 
				",+" + item.long / geoConst;
				var googleMapsLink = "<a href='" + googleMapsUrl + "'>Map</a> ";

				$('#buildings').prepend($('<li/>').html(googleMapsLink + building + " | " + item.info.replace(/(\\n|\\)/g, " ")
				 + (cat == "restrooms" ? "Restroom" : "") ));
			});	
			$('#buildings').prepend($('<h1/>').html( cat.capitalize() ));
			jsonSuccess = true;
			document.getElementById("loading").style.display = "none";
		}
	);
	setTimeout(	
		function() { 
			if(!jsonSuccess) { 
					document.getElementById("buildings").innerHTML = "<li>Could not query the specified category, " + cat + ".</li>";	
					document.getElementById("buildings").style.display = "block";
					document.getElementById("loading").style.display = "none";	
			 }
	   }, 3000);
}
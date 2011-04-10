// create the geonames namespace for calling the API
var geonames = {};
geonames.search = function(lat,lng) {	
	//TODO: change this so that it accepts category names ... (FIXED)
	// also, we want to search outside, soon.
	
	//TODO: Why can't I JSON-parse coffee with getLocations.php? need to use
	// getAllLocations for coffee ...
	if (cat == "coffee")
		jsonUrl = "http://fincdn.org/getAllLocations.php?lat=47654799&long=-122307776&cat=" + cat.toLowerCase() + "&rad=6020";
	else 
		jsonUrl = "http://fincdn.org/getLocations.php?lat=47654799&long=-122307776&cat=" + cat.toLowerCase() + "&rad=6020";
		
	$.getJSON(jsonUrl , function(data){
		// This foreach is O(N) where N is number of items
		var finItems = new Array();
		
		$.each(data, function(index, item) {
			// need to create "geopoints" for the item location and current location
			var geo1 = { lat: lat , lon: lng };
			//DEBUG: geopoint for Everett, WA var geo1 = { lat: 47.989922, lon: -122.188568};
			var geo2 = { lat: item.lat / 1000000 , lon: item.long / 1000000 };
			var dist = Math.round(calcDist(geo1, geo2) * 100)/100;
			if (item.floor_names.length == 0) 
				building = "Outdoor Location";
			else 
				building = buildingsArray["LAT" + item.lat]["LONG" + item.long];
			var finItem = {
				distance: dist,
				building: building,
				walking: Math.round(dist * 25),
				info: item.info.replace(/(\\n|\\)/g, " | "),
				geo: geo2
			};
			// hack to stop duplicate restrooms from showing up
			if(!finItems.contains(finItem)) finItems.push(finItem);
		});
		
		// O(?) Not sure how JS sorts
		finItems.sort(finSort);
		
		// Sorting by distance, farther distances are lower in priority
		function finSort(placeA, placeB) {
			if (placeA.distance > placeB.distance) return 1;
			else if (placeA.distance < placeB.distance) return -1;
			else return 0;
		}
		
		// make sure the page is empty before adding to it.
		$("#wikiList").empty();
		// O(N) - iterate through each FIN item
		$.each(finItems, function(index, item) {
			// generate a google maps link
			var gmapsLink = 'http://maps.google.com/maps?z=17&q=' + item.building + '@' + item.geo.lat +',+' + item.geo.lon;
			// is it far away? color it red
			var distColor = item.distance > 0.5 ? "#800000" : "green";
			// append everything to the dom
			$('<li></li>')
			.hide()
			.append('<h1><em><a href="' + gmapsLink + '">'+ item.building + '</a></em></h1><h3>'+ item.info + '</h3><span class="ui-li-aside" style="margin-right:-75px; width:75px; font-size:12px; color:' + distColor + '"><span style="font-size:18px">' + item.distance + '</span> mi <br /> <span style="font-size:12px; color: #222">' + item.walking + ' min</span></span>')
			.appendTo('#wikiList')
			.show();
		});
		
		// Once the data is added to the DOM, make the transition
		$.mobile.changePage('#dashboard',"slide",false,true);
	
		// refresh the list to make sure the theme applies properly
		$('#wikiList').listview('refresh');
	});
};
 
// Success function for Geolocation call
function onSuccess(position) {
	currLoc = { lat: position.coords.latitude, lon: position.coords.longitude };
	geonames.search(position.coords.latitude,position.coords.longitude);
}
 
// Error function for Geolocation call
function onError(msg) {
	alert(msg);
}

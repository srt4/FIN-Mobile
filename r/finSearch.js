// Success function for Geolocation call
function onSuccess(position) {
	currLoc = { lat: position.coords.latitude, lon: position.coords.longitude };
    $('a').attr("href", function(i, href) {
        return href + "&lat=" + currLoc.lat + "&lon=" + currLoc.lon;
    });	
}
 
// Error function for Geolocation call
function onError(msg) {
    $('a').attr("href", function(i, href) {
        return href + "&lat=" + currLoc.lat + "&lon=" + currLoc.lon;
    });		
}

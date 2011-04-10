// some joyful maths to calculate the distance between two lat/long pairs
// code adapted from
// http://pietschsoft.com/post/2008/02/01/Calculate-Distance-Between-Geocodes-in-C-and-JavaScript.aspx
// helper method
function calcDist(geoPoint1, geoPoint2) {
	var lat1 = geoPoint1.lat;
	var lat2 = geoPoint2.lat;
	var lon1 = geoPoint1.lon;
	var lon2 = geoPoint2.lon;
	return GeoCodeCalc.CalcDistance(lat1, lon1, lat2, lon2 , GeoCodeCalc.EarthRadiusInMiles); 
}

var GeoCodeCalc = {};

GeoCodeCalc.EarthRadiusInMiles = 3956.0;
GeoCodeCalc.EarthRadiusInKilometers = 6367.0;

GeoCodeCalc.ToRadian = function(v) { return v * (Math.PI / 180);};
	GeoCodeCalc.DiffRadian = function(v1, v2) { 
	return GeoCodeCalc.ToRadian(v2) - GeoCodeCalc.ToRadian(v1);
};

GeoCodeCalc.CalcDistance = function(lat1, lng1, lat2, lng2, radius) { 
	return radius * 2 * Math.asin( Math.min(1, Math.sqrt( ( Math.pow(Math.sin((GeoCodeCalc.DiffRadian(lat1, lat2)) / 2.0), 2.0) + Math.cos(GeoCodeCalc.ToRadian(lat1)) * Math.cos(GeoCodeCalc.ToRadian(lat2)) * Math.pow(Math.sin((GeoCodeCalc.DiffRadian(lng1, lng2)) / 2.0), 2.0) ) ) ) );
};

// Horrible way to suppress duplicate building listings for category "restrooms"
Array.prototype.contains = function(obj) {
  var i = this.length;
  while (i--) {
	// compare on the object building, also not a good practice ... but it works for now
	// breaks if there's two things listed at one lat and are outdoor
	// TODO: fix
    if (this[i].building== obj.building && this[i].geo.lat == obj.geo.lat) {
      return true;
    }
  }
  return false;
}

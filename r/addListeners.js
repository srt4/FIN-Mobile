// very hacky, I should narrow the scope of this variable ...
var cat = "stuff";
var currLoc = { lat: -1 , lon: -1};

$(document).ready(function(){
     // stop the map pages from caching
     $("div[data-role*='page']").live('pagehide', function(event, ui) {
            if ($(this).children("div[data-role*='content']").is(".command-no-cache")) {
                $(this).remove();
                $('[data-role=content]').height();
            }
    });
    // add some placeholder links; hopefully these get amended later
    $('content-home').find('a').attr("href", function(i, href) {
        return "finMobile_getCat.php?cat=" + href;
    });	
    // let's query location on pageload.
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(onSuccess, onError);
	} else {
		// If location is not supported on this platform, disable it
		$('#getLocation').value = "Geolocation not supported";
		$('#getLocation').unbind('click');
	}
});


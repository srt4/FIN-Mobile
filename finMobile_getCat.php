<?php
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$cat = $_REQUEST['cat'];

$jsonurl = "http://fincdn.org/getAllLocations.php?lat=47654799&long=-122307776&rad=6020";
$jsonurl .= "&cat=" . $cat; 

$json = file_get_contents($jsonurl,0,null,null);
$json_output = json_decode($json);

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
		<h1>Page Title</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<ul id="wikiList" data-role="listview" data-theme="c"> 
			<?php
				$lat = 42953;
				$lon = 43923;
				foreach($json_output as $index=>$item) {
					echo "<li>" . $_REQUEST['long'] . " " . $item->info . "</li>";
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

	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page -->

</body>
</html>

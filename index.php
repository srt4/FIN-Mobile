<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>findItNow UW</title> 
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.css" />
<link rel="stylesheet" href="r/finterface.css" />
<script src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.js"></script>
<script src="r/addListeners.js"></script>
<script src="r/helperMethods.js"></script>
<script src="r/finSearch.js"></script>
</head> 
<body> 
<div data-role="page" data-theme="a"> 
	<div data-role="header"> 
    	<h1>FindItNow</h1>
	</div> 
    <div data-role="content">
		<h2 style="text-align:center">Select a category</h2>
		<ul data-role="listview" data-inset="true" data-split-theme="a" data-split-icon="arrow-r"> 
			<li><a href="coffee"> 
				<img src="drawable/coffee.png" height="60" /> 
				<h1 style="valign:middle">Coffee</h1>
				</a> 
			</li> 
			<li><a href="vending"> 
				<img src="drawable/vending.png" height="60" /> 
				<h1>Vending</h1> 
				</a> 
			</li> 
			<li><a href="dining"> 
				<img src="drawable/dining.png" height="60" /> 
				<h1>Dining</h1> 
				</a> 
			</li> 
			<li><a href="mailboxes"> 
				<img src="drawable/mailboxes.png" height="60" /> 
				<h1>Mailboxes</h1> 
				</a> 
			</li> 
			<li><a href="school_supplies"> 
				<img src="drawable/school_supplies.png" height="60" /> 
				<h1>Not working-School Supplies</h1> 
				</a> 
			</li> 
			<li><a href="restrooms"> 
				<img src="drawable/restrooms.png" height="60" /> 
				<h1>Restrooms</h1> 
				</a> 
			</li> 
		</ul> 
		<div data-role="fieldcontain">
			<input type="search"  id="search" value="Search not implemented yet" data-theme="c" />
		</div>
    </div> 
    <div data-role="footer"> 
    	<h4>Project FIN <img src="drawable/icon_with_stroke.png" style="height:30px;vertical-align:middle;line-height:30px" /></h4>
    </div> 
</div> 
<div data-role="page" id="dashboard"> 
	<div data-role="header"> 
    	<h1>Placemarks</h1> 
    </div> 
    <div data-role="content"> 
    	<ul id="wikiList" data-role="listview" data-theme="c"> 
        </ul> 
    </div> 
    <div data-role="footer"> 
    	<h4>Project FIN <img src="drawable/icon_with_stroke.png" style="height:30px;vertical-align:middle;line-height:30px" /></h4>
    </div> 
</div> 
</body> 
</html> 

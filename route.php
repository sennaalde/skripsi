<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<title>Simple Polylines</title>
		<style>
			html, body, #map-canvas {
				height: 100%;
				margin: 0px;
				padding: 0px
			}
		</style>
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script>
			function initialize() {
var mapOptions = {
zoom: 12,
center: new google.maps.LatLng(-7.9773296, 112.6328767),
mapTypeId: google.maps.MapTypeId.TERRAIN
};

var map = new google.maps.Map(document.getElementById('map-canvas'),
mapOptions);

var flightPlanCoordinates = [<?php //If konesi.php outputs ANYTHING, the map will fail to load. However, you should
	//change the connection variable to $connection = mysqli_connect("HOST","USERNAME","PASSWORD","DATABASE");
	include ('admin/koneksi.php');

	//switch to correct database
	$connection = mysqli_connect("localhost","","hotel");
	mysqli_select_db($connection, "hotel");

	//Query the user for start and ending location. Store locations in variables
	$query = mysqli_query($connection, "SELECT latitude1, longitude1, latitude2, longitude2 FROM location");
	$row = mysqli_fetch_assoc($query);
	$lat = $row['latitude1'];
	$lon = $row['longitude1'];
	$lat2 = $row['latitude2'];
	$lon2 = $row['longitude2'];

	//Echo out the users start location
	echo 'new google.maps.LatLng(' . $lat . ', ' . $lon . '),';

	//Assuming route that lat and long coordinates are in multiple records and not in a array within a single record
	//Loop through all records and echo out the positions
	$query = mysqli_query($connection, "SELECT latitude, longitude FROM data_jalan");
	while ($row = mysqli_fetch_assoc($query)) {
		$lat = $row['latitude'];
		$lon = $row['longitude'];
		echo 'new google.maps.LatLng(' . $lat . ', ' . $lon . '),';
	}

	//echo users ending position
	echo 'new google.maps.LatLng(' . $lat2 . ', ' . $lon2 . ')';
?>
	];

	var flightPath = new google.maps.Polyline({
		path : flightPlanCoordinates,
		geodesic : true,
		strokeColor : '#FF0000',
		strokeOpacity : 1.0,
		strokeWeight : 2
	});
	flightPath.setMap(map);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</head>
	<body>
		<div id="map-canvas"></div>
	</body>
</html>


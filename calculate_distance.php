<?php
include 'koneksi.php';
?>

<?php $connexion = mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("hotel", $connexion) or die(mysql_error());

if (isset($_POST['submit'])) {
	$id_hotel_asal = $_POST['id_hotel_asal_maps'];
	$id_hotel_tujuan = $_POST['id_hotel_tujuan_maps'];
	$result = mysql_query("SELECT hotel.id, hotel.nama_hotel, 
     rute.hotel_asal, rute.hotel_tujuan, rute.kode_persimpangan AS kode_persimpangan,
	simpang.latitude AS latitude, simpang.longitude AS longitude FROM 
	data_hotel hotel LEFT JOIN rute rute ON hotel.nama_hotel = rute.hotel_asal   
	LEFT JOIN data_jalan simpang ON 
	rute.kode_persimpangan = simpang.kode_persimpangan WHERE 
	(hotel.id = $id_hotel_asal OR hotel.id = $id_hotel_tujuan) AND rute.nama_rute = 'Rute 2'");

	$listeDesPoints = '';
	while ($row = mysql_fetch_array($result)) {
		if ($listeDesPoints != '')
			$listeDesPoints .= ',';
		$listeDesPoints .= '[' . $row['latitude'] . ',' . $row['longitude'] . ']';
	}

	$result1 = mysql_query("SELECT hotel.id, hotel.nama_hotel, 
     rute.hotel_asal, rute.hotel_tujuan, rute.kode_persimpangan AS kode_persimpangan,
	simpang.latitude AS latitude, simpang.longitude AS longitude FROM 
	data_hotel hotel LEFT JOIN rute rute ON hotel.nama_hotel = rute.hotel_asal   
	LEFT JOIN data_jalan simpang ON 
	rute.kode_persimpangan = simpang.kode_persimpangan WHERE 
	(hotel.id = $id_hotel_asal OR hotel.id = $id_hotel_tujuan) AND rute.nama_rute = 'Rute 1'");

	$listeDesPoints1 = '';
	while ($row1 = mysql_fetch_array($result1)) {
		if ($listeDesPoints1 != '')
			$listeDesPoints1 .= ',';
		$listeDesPoints1 .= '[' . $row1['latitude'] . ',' . $row1['longitude'] . ']';
	}
}
mysql_close($connexion);
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title></title>
		<script src="js/jquery.js"></script>
		<!--<script src="js/jquery-1.6.4.js"></script>
		<script src="js/jquery.mobile-1.1.0.js"></script>
		<link href="css/jquery.mobile.structure-1.1.0.css" rel="stylesheet"/>
		<link href="css/jquery.mobile.theme-1.1.0.css" rel="stylesheet" />-->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

		<script>

			function initialize() {
var optionsCarte = {
center: new google.maps.LatLng(-7.9773296,112.6328767),
zoom: 12,
mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementById("map_canvas"),
optionsCarte);

var liste_des_points=[<?php echo $listeDesPoints; ?>];

var i=0,li=liste_des_points.length;
while(i<li){
new google.maps.Marker({
position: new google.maps.LatLng(liste_des_points[i][0], liste_des_points[i][1]),
map: map,
icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
});
i++;
}

var liste_des_points1=[<?php echo $listeDesPoints1; ?>
	];

	var x = 0, lx = liste_des_points1.length;
	while (x < lx) {
		new google.maps.Marker({
			position : new google.maps.LatLng(liste_des_points1[x][0], liste_des_points1[x][1]),
			map : map,
			icon : 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
		});
		x++;
	}

	}
		</script>
		<script>
			$(document).ready(function() {

				//Hotel Asal
				$("#hotel_asal").load("suggest_hotel.php", "op=ambiloption");
				$("#hotel_asal").change(function() {
					nama = $("#hotel_asal").val();
					$.ajax({
						url : "suggest_hotel.php",
						//method : 'POST',
						data : "op=ambildata&nama=" + nama,
						cache : false,
						success : function(msg) {
							data = msg.split("|");
							$("#id_hotel_asal").val(data[0]);
							$("#nama_hotel_asal").val(data[1]);
							$("#lat_hotel_asal").val(data[2]);
							$("#long_hotel_asal").val(data[3]);
							$("#id_hotel_asal_maps").val(data[4]);
						}
					});
				});

				//Hotel Asal
				$("#hotel_tujuan").load("suggest_hotel.php", "op=ambiloption");
				$("#hotel_tujuan").change(function() {
					nama = $("#hotel_tujuan").val();
					$.ajax({
						url : "suggest_hotel.php",
						//method : 'POST',
						data : "op=ambildata&nama=" + nama,
						cache : false,
						success : function(msg) {
							data = msg.split("|");
							$("#id_hotel_tujuan").val(data[0]);
							$("#nama_hotel_tujuan").val(data[1]);
							$("#lat_hotel_tujuan").val(data[2]);
							$("#long_hotel_tujuan").val(data[3]);
							$("#id_hotel_tujuan_maps").val(data[4]);
						}
					});
				});

				//Tampil Rute
				$("#rute").click(function() {
					nama_hotel_asal = $("#nama_hotel_asal").val();
					nama_hotel_tujuan = $("#nama_hotel_tujuan").val();
					if (id_hotel_asal != 0 && id_hotel_tujuan != 0) {
						data = "&nama_hotel_asal=" + nama_hotel_asal + "&nama_hotel_tujuan=" + nama_hotel_tujuan;
						$.ajax({
							url : "get_route.php",
							//method : 'POST',
							data : "op=dapat_rute" + data,
							cache : false,
							success : function(msg) {
								$("#data-rute").html(msg);
							}
						});
					}
				});

				//Pilih Rute
				//Tampil Rute
				$("#certain_route").click(function() {
					nama_hotel_asal = $("#nama_hotel_asal").val();
					nama_hotel_tujuan = $("#nama_hotel_tujuan").val();
					if (id_hotel_asal != 0 && id_hotel_tujuan != 0) {
						data = "&nama_hotel_asal=" + nama_hotel_asal + "&nama_hotel_tujuan=" + nama_hotel_tujuan;
						$.ajax({
							url : "get_route.php",
							//method : 'POST',
							data : "op=pilih_rute" + data,
							cache : false,
							success : function(msg) {
								$("#route_floyd_warshall").show();
								$("#map_canvas").show();
								data = msg.split("|");
								$("#result_certain_route1").html(data[0]);
								$("#distance_route1").html(data[1]);
								$("#result_certain_route2").html(data[2]);
								$("#distance_route2").html(data[3]);
								$("#best_route").html(data[4]);
								$("#crossroad_best_route").html(data[5]);
								$("#distance_best_route").html(data[6]);
							}
						});
					}
				});

			});
		</script>
		<script>
			//Menghitung Jarak
			function distance(lat1, lon1, lat2, lon2, unit) {
				var radlat1 = Math.PI * lat1 / 180
				var radlat2 = Math.PI * lat2 / 180
				var radlon1 = Math.PI * lon1 / 180
				var radlon2 = Math.PI * lon2 / 180
				var theta = lon1 - lon2
				var radtheta = Math.PI * theta / 180
				var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
				dist = Math.acos(dist)
				dist = dist * 180 / Math.PI
				dist = dist * 60 * 1.1515
				if (unit == "K") {
					dist = dist * 1.609344
				}
				if (unit == "N") {
					dist = dist * 0.8684
				}
				return dist
			}

			var lati1, long1, lati2, long2;
			var lati1Float, long1Float, lati2Float, long2Float;
			function getdist() {
				lati1 = document.getElementById('lat_hotel_asal').value;
				lati1Float = parseFloat(lati1);
				long1 = document.getElementById('long_hotel_asal').value;
				long1Float = parseFloat(long1);
				lati2 = document.getElementById('lat_hotel_tujuan').value;
				lati2Float = parseFloat(lati2);
				long2 = document.getElementById('long_hotel_tujuan').value;
				long2Float = parseFloat(long2);
				var distance_num = distance(lati1Float, long1Float, lati2Float, long2Float);
				var dist = distance_num.toFixed(2);
				document.getElementById('distance').innerHTML = dist + " Km";
			}
		</script>
	</head>
	<body onload="initialize()">
		<div data-role="page" data-theme="d">
			<div data-role="header" data-theme="d">
				<div data-role="navbar">
					<ul>
						<li>
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="navigasi.php">Navigasi</a>
						</li>
						<li>
							<a href="lokasi.php">Daftar Hotel</a>
						</li>
					</ul>
				</div>
			</div>

			<h3>HOTEL AWAL</h3>
			<br />
			<select id="hotel_asal"></select>
			<input type="text" id="id_hotel_asal" name="id_hotel_asal" />
			<input type="text" id="nama_hotel_asal" name="nama_hotel_asal" />
			<input type="text" id="lat_hotel_asal" name="lat_hotel_asal" />
			<input type="text" id="long_hotel_asal" name="long_hotel_asal" />

			<br />

			<h3>HOTEL TUJUAN</h3>
			<br />
			<select id="hotel_tujuan"></select>
			<input type="text" id="id_hotel_tujuan" name="id_hotel_tujuan" />
			<input type="text" id="nama_hotel_tujuan" name="nama_hotel_tujuan" />
			<input type="text" id="lat_hotel_tujuan" name="lat_hotel_tujuan" />
			<input type="text" id="long_hotel_tujuan" name="long_hotel_tujuan" />

			<br />
			<input type="button" id="jarak" value="Hitung Jarak" onclick="getdist()" />
			<p id="distance"></p>

			<br />
			<input type="button" id="rute" value="Tampil Rute" />

			<table border="0">
				<thead>
					<tr>
						<th>NAMA RUTE</th>
						<th>NAMA PERSIMPANGAN</th>
						<th>ARAH</th>
						<th>LATITUDE</th>
						<th>LONGITUDE</th>
						<th>JARAK</th>
					</tr>
				</thead>
				<tbody id="data-rute"></tbody>
			</table>

			<button id="certain_route">
				Tentukan Rute
			</button>
			<br />

			<div id="route_floyd_warshall" hidden="hidden">
				<strong><span style="text-decoration: underline;">RUTE 1 : </span></strong>
				<br />
				Jumlah Persimpangan : <span id="result_certain_route1"></span>
				<br />
				Total Jarak : <span id="distance_route1"></span><span> Km</span>
				<br />
				<br />
				<strong><span style="text-decoration: underline;">RUTE 2 : </span></strong>
				<br />
				Jumlah Persimpangan : <span id="result_certain_route2"></span>
				<br />
				Total Jarak : <span id="distance_route2"></span><span> Km</span>
				<br />
				<br />

				<strong>Pilihan rute menurut metode Floyd Warshall : </strong>
				<br />
				<span id="best_route"></span> dengan jumlah persimpangan : <span id="crossroad_best_route"></span> dan dengan jarak : <span id="distance_best_route"></span> Km.
			</div>
			<br />

			<form method="post" action="">
				<input type="text" id="id_hotel_asal_maps" name="id_hotel_asal_maps" />
				<input type="text" id="id_hotel_tujuan_maps" name="id_hotel_tujuan_maps" />
				<input type="submit" id="submit" name="submit" value="Tampilkan Peta" />
				
			</form>

			<div id="map_canvas" style="width:100%; height:100%"></div>
		</div>

	</body>
</html>
<html>
	<head>
		<title>GIS Hotel Kota Malang dan Kota Batu</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="js/jquery-1.6.4.js"></script>
		<script src="js/jquery.mobile-1.1.0.js"></script>
		<link href="css/jquery.mobile.structure-1.1.0.css" rel="stylesheet"/>
		<link href="css/jquery.mobile.theme-1.1.0.css" rel="stylesheet" />
		<!-- load googlemaps api dulu -->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

		<script type="text/javascript">
			//var peta;
			//var gambar_tanda;
			//gambar_tanda = 'img/hotelcilik.png';
			var dest;
			var directionsDisplay;

			// memanggil service Google Maps Direction
			var directionsService = new google.maps.DirectionsService();
			directionsDisplay = new google.maps.DirectionsRenderer();

			/*function peta_awal(){
			 // posisi default peta saat diload
			 var lokasibaru = new google.maps.LatLng(-7.9773296,112.6328767);
			 var petaoption = {
			 zoom: 13,
			 center: lokasibaru,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 };

			 peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);

			 // memanggil fungsi geocoder autocomplete
			 var autocomplete = new google.maps.places.Autocomplete((document.getElementById('dest')),{ types: ['geocode'] });

			 // ngasih fungsi marker buat generate koordinat latitude & longitude
			 tanda = new google.maps.Marker({
			 position: lokasibaru,
			 map: peta,
			 icon: gambar_tanda,
			 draggable : true
			 });

			 // ketika markernya didrag, koordinatnya langsung di selipin di textfield
			 google.maps.event.addListener(tanda, 'dragend', function(event){
			 document.getElementById('latitude').value = this.getPosition().lat();
			 document.getElementById('longitude').value = this.getPosition().lng();
			 });

			 if (navigator.geolocation) {
			 navigator.geolocation.getCurrentPosition(function(position) {
			 var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			 autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,geolocation));
			 });
			 }
			 }

			 function setpeta(x,y,id){
			 // mengambil koordinat dari database
			 var lokasibaru = new google.maps.LatLng(x, y);
			 var petaoption = {
			 zoom: 14,
			 center: lokasibaru,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 };

			 peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);

			 // ngasih fungsi marker buat generate koordinat latitude & longitude
			 tanda = new google.maps.Marker({
			 position: lokasibaru,
			 icon: gambar_tanda,
			 draggable : true,
			 map: peta
			 });

			 // ketika markernya didrag, koordinatnya langsung di selipin di textfield
			 google.maps.event.addListener(tanda, 'dragend', function(event){
			 document.getElementById('latitude').value = this.getPosition().lat();
			 document.getElementById('longitude').value = this.getPosition().lng();
			 });
			 }

			 function setdest(tx){
			 $("#dest").val(tx);
			 }*/

			function load_map(tx) {// ketika tombol cari di klik, maka proses pencarian rute dimulai
				dest = tx;
				var defaultLatLng = new google.maps.LatLng(-2.548926, 118.0148634);

				/*
				 nah, pada fungsi geolocation disini adalah
				 ketika koordinat user berhasil didapat maka peta koordinat yang digunakan
				 adalah koordinat user, namun jika tidak berhasil maka koordinat yang digunakan
				 adalah koordinat default (pada variable defaultLatLng)
				 */
				if (navigator.geolocation) {
					function success(pos) {
						drawMap(pos.coords.latitude, pos.coords.longitude);
					}

					function fail(error) {
						drawMap(defaultLatLng);
					}


					navigator.geolocation.getCurrentPosition(success, fail, {
						maximumAge : 500000,
						enableHighAccuracy : true,
						timeout : 6000
					});

				} else {
					drawMap(defaultLatLng);
				}

				function drawMap(lat, lng) {

					var myOptions = {
						zoom : 15,
						center : new google.maps.LatLng(lat, lng),
						mapTypeId : google.maps.MapTypeId.ROADMAP
					};

					var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

					// kita bikin marker untuk asal dengan koordinat user hasil dari geolocation
					var markerorigin = new google.maps.Marker({
						position : new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
						map : map,
						title : "Origin",
						visible : false // kita ga perlu menampilkan markernya, jadi visibilitasnya kita set false
					});

					// membuat request ke Direction Service
					var request = {
						origin : markerorigin.getPosition(), // untuk daerah asal, kita ambil posisi user
						destination : dest, // untuk daerah tujuan, kita ambil value dari textbox tujuan
						provideRouteAlternatives : true, // set true, karena kita ingin menampilkan rute alternatif

						/**
						 * kamu bisa tambahkan opsi yang lain seperti
						 * avoidHighways:true (set true untuk menghindari jalan raya, set false untuk menonantifkan opsi ini)
						 * atau kamu bisa juga menambahkan opsi seperti
						 * avoidTolls:true (set true untuk menghindari jalan tol, set false untuk menonantifkan opsi ini)
						 */
						travelMode : google.maps.TravelMode.DRIVING // set mode DRIVING (mode berkendara / kendaraan pribadi)
						/**
						 * kamu bisa ganti dengan
						 * google.maps.TravelMode.BICYCLING (mode bersepeda)
						 * google.maps.TravelMode.WALKING (mode berjalan)
						 * google.maps.TravelMode.TRANSIT (mode kendaraan / transportasi umum)
						 */
					};

					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
						}
					});
					// menampiklkan rute pada peta dan juga direction panel sebagai petunjuk text
					directionsDisplay.setMap(map);
					directionsDisplay.setPanel(document.getElementById('directions-panel'));

					// menampilkan layer traffic atau lalu-lintas pada peta
					var trafficLayer = new google.maps.TrafficLayer();
					trafficLayer.setMap(map);

				}

			};
		</script>
	</head>
	<body>
		<div data-role="page" data-theme="d">
			<div data-role="header" data-theme="d">
				<div data-role="navbar">
					<ul>
						<li>
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="calculate_distance.php">Lokasi</a>
						</li>
						<li>
							<a href="lokasi.php">Daftar Hotel</a>
						</li>
					</ul>
				</div>
			</div>
			<div data-role="content">
				<ul class="ui-listview-outer" data-role="listview" data-inste="true">
					<li data-role="collapsible" data-icon-pos="left">
						<h2>Daftar Hotel</h2>
						<ul data-role="listview" data-filter="true" data-input="#hotelfilter" data-autodividers="true" data-inset="true">
							<?php
							require ('koneksi.php');
							// mengambil data dari database
							$lokasi = mysql_query("select * from `data_hotel`");

							while ($l = mysql_fetch_array($lokasi)) {
								// membuat fungsi javascript untuk nantinya diolah dan ditampilkan dalam peta

								echo "<li data-icon='location'><a href=\"javascript:load_map('" . $l['alamat'] . "')\">" . $l['nama_hotel'];
							}
							?>
						</ul>
					</li>
				</ul>

				<div id="map-canvas" style="width:100%; height:500px;"></div>
				<div id="directions-panel" style="width:100%; height:300px; overflow:auto;"></div>
			</div>
			<div data-role="footer" data-theme="a" data-position="fixed">
				<h2>tes tes ts</h2>
			</div>
		</div>

		<!--<input type="text" id="dest" style="width:500px;">
		<button type="button" id="cari">Cari Rute</button>-->
		<br>
		<br>

	</body>
</html>
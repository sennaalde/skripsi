<html>
	<head>
		<title>GIS Hotel Kota Malang dan Kota Batu</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script src="js/jquery-1.6.4.js"></script>
		<script src="js/jquery.mobile-1.1.0.js"></script>
		<link href="css/jquery.mobile.structure-1.1.0.css" rel="stylesheet"/>
		<link href="css/jquery.mobile.theme-1.1.0.css" rel="stylesheet" />

		<!-- load googlemaps api dulu -->
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

		<script type="text/javascript">
			var peta;
			var gambar_tanda;
			gambar_tanda = 'images/hotelcilik.png';

			function peta_awal() {
				// posisi default peta saat diload
				var lokasibaru = new google.maps.LatLng(-6.912889, 107.609787);
				var petaoption = {
					zoom : 13,
					center : lokasibaru,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				};

				peta = new google.maps.Map(document.getElementById("map_canvas"), petaoption);

				// ngasih fungsi marker buat generate koordinat latitude & longitude
				tanda = new google.maps.Marker({
					position : lokasibaru,
					map : peta,
					icon : gambar_tanda,
					draggable : true
				});

				// ketika markernya didrag, koordinatnya langsung di selipin di textfield
				google.maps.event.addListener(tanda, 'dragend', function(event) {
					document.getElementById('latitude').value = this.getPosition().lat();
					document.getElementById('longitude').value = this.getPosition().lng();
				});
			}

			function setpeta(x, y, id) {
				// mengambil koordinat dari database
				var lokasibaru = new google.maps.LatLng(x, y);
				var petaoption = {
					zoom : 14,
					center : lokasibaru,
					mapTypeId : google.maps.MapTypeId.ROADMAP
				};

				peta = new google.maps.Map(document.getElementById("map_canvas"), petaoption);

				// ngasih fungsi marker buat generate koordinat latitude & longitude
				tanda = new google.maps.Marker({
					position : lokasibaru,
					icon : gambar_tanda,
					draggable : true,
					map : peta
				});

				// ketika markernya didrag, koordinatnya langsung di selipin di textfield
				google.maps.event.addListener(tanda, 'dragend', function(event) {
					document.getElementById('latitude').value = this.getPosition().lat();
					document.getElementById('longitude').value = this.getPosition().lng();
				});
			}
		</script>
		<body>
			<div data-role="page"  data-theme="d">
				<div data-role="header" data-theme="d">
					<h1>GIS Hotel Kota Malang dan Kota Batu</h1>
				</div>
				<ul class="ui-listview-outer" data-role="listview" data-inste="true">
					<li data-role="collapsible" data-icon-pos="left">
						<h2>Daftar Hotel</h2>
						<ul data-role="listview" data-autodividers="true" data-inset="true">
							<?php
							require ('admin/koneksi.php');
							// mengambil data dari database
							$lokasi = mysql_query("select * from `data_hotel`");

							while ($l = mysql_fetch_array($lokasi)) {
								// membuat fungsi javascript untuk nantinya diolah dan ditampilkan dalam peta

								echo "<li><a href=\"javascript:setpeta(" . $l['latitude'] . "," . $l['longitude'] . "," . $l['id'] . ")\">" ."<img src='images/navigasi.jpg'>". $l['nama_hotel'] . "<p> ". $l['alamat'] ."</a></li>";
							}
							?>
						</ul>
					</li>
				</ul>
				<div id="map_canvas" style="width:100%; height:500px"></div>
			</div>
		</body>
	</head>
</html>
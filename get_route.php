<?php
mysql_connect("localhost","root",""); 
mysql_select_db("hotel");

$op = $_REQUEST['op']; 
$error = "No Data Available";

/*$query = mysql_query("SELECT * FROM `data_hotel`");
$latitudes = array();
$id = array();
while ($latitude =  mysql_fetch_assoc($query)){
	$latitudes[] = $latitude;
}
foreach ($latitudes as $key => $value){
	echo $value['latitude']. " and " . $value['longitude'] . " in " . $key. ", ";	
	echo array_sum($value);
	echo "<br />";
}*/

if($op=="dapat_rute") {
	$nama_hotel_asal = $_GET['nama_hotel_asal'];
	$nama_hotel_tujuan = $_GET['nama_hotel_tujuan'];
	$query = "SELECT rute.hotel_asal, rute.hotel_tujuan, 
	rute.nama_rute AS nama_rute, rute.kode_persimpangan AS kode_persimpangan, rute.arah AS arah, rute.jarak AS jarak,
	simpang.latitude AS latitude, simpang.longitude AS longitude FROM 
	rute rute LEFT JOIN data_jalan simpang ON 
	rute.kode_persimpangan = simpang.kode_persimpangan WHERE 
	(rute.hotel_asal = '$nama_hotel_asal' AND rute.hotel_tujuan = '$nama_hotel_tujuan') ORDER BY rute.id";
	//$query = "SELECT * FROM rute WHERE hotel_asal = '$nama_hotel_asal' AND hotel_tujuan = '$nama_hotel_tujuan'";
	$result = mysql_query($query);
	if ((mysql_num_rows($result)) != 0) {
		while ($row = mysql_fetch_array($result)) {
			echo "<tr><td>" . $row['nama_rute'] . "</td><td>" . $row['kode_persimpangan'] . "</td><td>" . $row['arah'] . "</td>
			<td><input type='text' value='" . $row['latitude'] . "' id='' />"."</td>
			<td><input type='text' value='" . $row['longitude'] . "' id='' />"."</td>
			<td>" . $row['jarak'] . " Km </td>\n";
			
		$counter++;
		}
	} else {
		echo $error;
	}
	
} else if($op=="pilih_rute") {
	//rute 1
	$nama_hotel_asal = $_GET['nama_hotel_asal'];
	$nama_hotel_tujuan = $_GET['nama_hotel_tujuan'];
	$query_route1 = "SELECT * FROM rute WHERE 
	(hotel_asal = '$nama_hotel_asal' AND hotel_tujuan = '$nama_hotel_tujuan') AND nama_rute = 'Rute 1'";
	$result_route1 = mysql_query($query_route1);
	$route1 = mysql_num_rows($result_route1);
	$distances_route1 = array();
	while($distance_route1 =  mysql_fetch_assoc($result_route1)){
		$distances_route1[] = $distance_route1['jarak'];
	}
	$dist_route1 = array_sum($distances_route1);
	
	
	//rute 2
	$query_route2 = "SELECT * FROM rute WHERE 
	(hotel_asal = '$nama_hotel_asal' AND hotel_tujuan = '$nama_hotel_tujuan') AND nama_rute = 'Rute 2'";
	$result_route2 = mysql_query($query_route2);
	$route2 = mysql_num_rows($result_route2);
	$distances_route2 = array();
	while($distance_route2 =  mysql_fetch_assoc($result_route2)){
		$distances_route2[] = $distance_route2['jarak'];
	}
	$dist_route2 = array_sum($distances_route2);
	
	if($route1 < $route2){
		$best_route = "RUTE 1";
		$cross_best_route = $route1;
		$dist_best_route = $dist_route1;
	} else {
		$best_route = "RUTE 2";
		$cross_best_route = $route2;
		$dist_best_route = $dist_route2;
	}
	
	echo $route1."|".$dist_route1."|".$route2."|".$dist_route2."|".$best_route."|".$cross_best_route."|".$dist_best_route;
}
?>
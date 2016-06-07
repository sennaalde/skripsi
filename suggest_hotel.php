<?php
mysql_connect("localhost","root",""); 
mysql_select_db("hotel");

$op = $_REQUEST['op'];
if ($op == "ambiloption") {
	$option = mysql_query("SELECT * FROM data_hotel");
	echo "<option>Pilih Nama Hotel</option>\n";
	while ($op = mysql_fetch_array($option)) {
		echo "<option>" . $op['nama_hotel'] . "</option>\n";
	}
}else if ($op == "ambildata"){ 
    $nama = $_GET['nama']; 
    $data = mysql_query("SELECT * FROM data_hotel WHERE nama_hotel = '$nama'"); 
    $d = mysql_fetch_array($data); 
    echo $d['id']."|".$d['nama_hotel']."|".$d['latitude']."|".$d['longitude']."|".$d['id'];
}
?>
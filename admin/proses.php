<html>
	<head>
		<title>Halaman Admin</title>
		<link href="../css/bootstrap.css" rel="stylesheet">
		<style>
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>
		<link href="../css/bootstrap-responsive.css" rel="stylesheet">
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap-alert.js"></script>
		<body>
			<div class="container">
				<div class="navbar navbar-fixed-top">
					<div class="navbar-inner">
						<div class="container">
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
							<a class="brand" href="#">Halaman Admin GIS Hotel</a>
							<div class="btn-group pull-right">

							</div><!--/.nav-collapse -->
						</div>
					</div>
				</div>
			
				<?php $o = "";

					if (isset($_GET['success']) && ($_GET['success'] == "1")) {

						$o .= '<div class="alert alert-success">
<a class="close" data-dismiss="alert" href="#">x</a>
Proses tambah hotel berhasil
</div>';

					} elseif (isset($_GET['success']) && ($_GET['success'] == "0")) {

						$o .= '
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">x</a>
					Proses tambah hotel gagal
				</div>';
					} elseif (isset($_GET['remove']) && ($_GET['remove'] == "1")) {

						$o .= '
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">x</a>
					Proses hapus cabang berhasil
				</div>';

					} elseif (isset($_GET['remove']) && ($_GET['remove'] == "0")) {

						$o .= '
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">x</a>
					Proses hapus cabang gagal
				</div>';
					}

					echo $o;
				?>

				<form action="?action=add" method="POST" enctype="multipart/form-data">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="input01">Nama Hotel</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="nama_hotel" name="nama_hotel" rel="popover" data-content="Masukkan nama hotel." data-original-title="Hotel">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input01">Alamat</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="alamat" name="alamat">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input01">Bintang</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="bintang" name="bintang">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input01">Harga</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="harga" name="harga">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input01">Latitude</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="latitude" name="latitude">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="input01">Longitude</label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="longitude" name="longitude" >
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="input01">Gambar 1</label>
							<div class="controls">
								<input type="file" name="gambar_upload" accept="images/jpeg" >
							</div>
						</div>


						<div class="control-group">
							<label class="control-label" for="input01"></label>
							<div class="controls">
								<button type="submit" class="btn btn-success">
									Tambah Hotel
								</button>

							</div>
						</div>
						
						
				</form>
				<div>
					<ol>
						<?php
								require ('koneksi.php');
								// mengambil data dari database
								$lokasi = mysql_query("select * from `data_hotel`");

								while ($l = mysql_fetch_array($lokasi)) {
									// membuat fungsi javascript untuk nantinya diolah dan ditampilkan dalam peta

									echo "<li>".$l['nama_hotel']." | ".$l['alamat']." | ".$l['bintang']." | ".$l['harga']." | ".$l['latitude']." | ".$l['longitude']." | <a href='?action=remove&id=" . $l['id'] . "'>Hapus</a></li>";
								}
								?>
					</ol>
				</div>
		</body>
</html>

<?php

if ($_GET['action'] == "add") {

//require ('koneksi.php');
$nama_hotel	= htmlentities(mysql_real_escape_string($_POST['nama_hotel']));
$alamat		= htmlentities(mysql_real_escape_string($_POST['alamat']));
$bintang	= htmlentities(mysql_real_escape_string($_POST['bintang']));
$harga		= htmlentities(mysql_real_escape_string($_POST['harga']));
$latitude		= htmlentities(mysql_real_escape_string($_POST['latitude']));
$longitude		= htmlentities(mysql_real_escape_string($_POST['longitude']));

$gambar = $_FILES['gambar_upload'] ['name'];

if(is_uploaded_file($FILES['gambar_upload']['tmp_name']))
{
	move_uploaded_file($FILES['gambar_upload'] ['tmp_name'], "images/".$gambar);
}

// input data ke database
$link = mysqli_connect("localhost","root","","hotel");
$query= "insert into `data_hotel` (`nama_hotel`,`alamat`,`bintang`,`harga`,`latitude`,`longitude`) values ('$nama_hotel','$alamat','$bintang','$harga','$latitude','$longitude'); insert into `gambar`(`gambar1`)values('$gambar')";
$input_hotel = mysqli_multi_query($link,$query);

if ($input_hotel) {
?>
<script language="javascript">document.location = "?success=1";</script>
<?php } else { ?>
<script language="javascript">document.location = "?success=0";</script>
<?php
}

} elseif ($_GET['action'] == "remove") {
$id = htmlentities(mysql_real_escape_string($_GET['id']));
// hapus data dari database
$hapus_hotel = mysql_query("DELETE FROM `data_hotel` WHERE `id` = '".$id."'");

if ($hapus_hotel) {
?>
<script language="javascript">document.location = "?remove=1";</script>
<?php } else { ?>
<script language="javascript">document.location = "?remove=0";</script>
<?php
}
}
?>

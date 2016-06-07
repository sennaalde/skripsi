<html>
	<head>
		<title>GIS Hotel Kota Malang dan Kota Batu</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
		
		<script type="text/javascript">
			var daftar;
 
$('#daftarhotellist').bind('pageinit', function(event) {
    getdaftarhotellist();
});
 
function getEmployeeList() {
     function(data) {
        $('#daftarhotel li').remove();
        employees = data.items;
        $.each(employees, function(index, employee) {
            $('#daftarhotel').append('<li><a href="employeedetails.html?id=' + employee.id + '">' +
                    '<img src="pics/' + employee.picture + '"/>' +
                    '<h4>' + employee.firstName + ' ' + employee.lastName + '</h4>' +
                    '<p>' + employee.title + '</p>' +
                    '<span class="ui-li-count">' + employee.reportCount + '</span></a></li>');
        });
        $('#daftarhotel').listview('refresh');
    });
}
		</script>
	</head>
	<body>
		<div data-role="page" data-theme="a">
			<div data-role="header" data-theme="a">
				<div data-role="navbar">
					<ul>
						<li>
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="lokasi.php">Lokasi</a>
						</li>
						<li>
							<a href="navigasi.php">Navigasi</a>
						</li>
						<li>
							<a href="#">Gallery</a>
						</li>
					</ul>
				</div>
			</div>
			<div data-role="content">
				<ul data-role="listview" data-filter="true" data-input="#hotelfilter" data-autodividers="true" data-inset="true">
					
				</ul>

				<div id="map-canvas" style="width:100%; height:500px;"></div>
				<div id="directions-panel" style="width:100%; height:300px; overflow:auto;"></div>
			</div>
			<div data-role="footer" data-theme="a" data-position="fixed">
				<h2>tes tes ts</h2>
			</div>
		</div>

	</body>
</html>
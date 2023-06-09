<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$navigasi = "";
$navigasi = "user";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - Online User</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<div class="container py-3 mb-5">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header text-white bg-primary font-weight-bold d-flex justify-content-between">
						<span class="pt-1">DATA AKUN ONLINE</span>
						<div class="btn-group">
							<button class="btn btn-sm btn-primary" type="button" id="btn-reload" title="Reload data"><i class="fas fa-sync-alt fa-fw"></i></button>
							<button class="btn btn-sm btn-danger" type="button" id="btn-deleteOnline" title="Hapus semua"><i class="fas fa-trash-alt fa-fw"></i></button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover w-100" id="datatables">
								<thead style="background-color: #004C94; color: white;">
									<tr class="text-center">
										<th class="align-middle">ID</th>
										<th class="align-middle">Username</th>
										<th class="align-middle">Name</th>
										<th class="align-middle">Division</th>
										<th class="align-middle">IP<br>Address</th>
										<th class="align-middle">Mac<br>Address</th>
										<th class="align-middle">Start<br>Time</th>
										<th class="align-middle">Up<br>Time</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/datatables.min.js"></script>
	<script src="js/dataTables.bootstrap4.min.js"></script>
	<script src="js/responsive.bootstrap4.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			var table = $('#datatables').DataTable({
				responsive: true,
				lengthMenu: [
					[5, 10, 25, 50, -1],
					[5, 10, 25, 50, 'All'],
				],
				language: {
					url: 'js/id.json',
				},
				ajax: {
					url: 'ajax/getUserOnline.php',
					dataSrc: '',
					type: 'POST'
				},
				columns: [{
						data: 'no'
					},
					{
						data: 'username'
					},
					{
						data: 'name'
					},
					{
						data: 'division'
					},
					{
						data: 'ip'
					},
					{
						data: 'mac'
					},
					{
						data: 'startTime'
					},
					{
						data: 'upTime'
					},
				],
				columnDefs: [{
					className: "text-center",
					targets: [0, 1, 3, 4, 5, 6, 7]
				}, {
					searchable: false,
					targets: [0, 5, 6, 7]
				}, ]
			});

			$('#btn-deleteOnline').click(function() {
				if (confirm('Hapus seluruh data log akun online?')) {
					$.post('ajax/deleteOnline.php').then(r => alert(r + ' data berhasil dihapus permanen!')).then(() => table.ajax.reload(null, false));
				}
			});

			$('#btn-reload').click(() => table.ajax.reload(null, false));
		});
	</script>
</body>

</html>
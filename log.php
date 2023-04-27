<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$log = query("SELECT 
	radpostauth.username AS auth_username, 
	radpostauth.reply AS reply, 
	radpostauth.authdate AS authdate, 
	organization.username AS org_username, 
	organization.name AS nama, 
	organization.division AS division,
	radacct.framedipaddress AS framedipaddress,
	radacct.callingstationid AS callingstationid
	FROM radpostauth 
	LEFT JOIN organization ON radpostauth.username = organization.username 
	LEFT JOIN radacct ON radpostauth.username = radacct.username
	ORDER BY authdate DESC");

$navigasi = "";
$navigasi = "log";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - Logs</title>
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
					<div class="card-header text-white bg-primary font-weight-bold">LOGS AKSES</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover w-100" id="datatables">
								<thead style="background-color: #004C94; color: white;">
									<tr class="text-center">
										<th class="align-middle" style="width: 10px;">No</th>
										<th class="align-middle">Username</th>
										<th class="align-middle">Name</th>
										<th class="align-middle">Divisin</th>
										<th class="align-middle">IP<br>Address</th>
										<th class="align-middle">Mac<br>Address</th>
										<th class="align-middle">Reply<br>Status</th>
										<th class="align-middle">Auth<br>Date</th>
									</tr>
								</thead>
								<tbody style="background-color: white">
									<?php $i = 1; ?>
									<?php foreach ($log as $row) : ?>
										<tr>
											<td class="text-center"><?= $i; ?></td>
											<td><?= $row["username"]; ?></td>
											<td><?= $row["name"]; ?></td>
											<td class="text-center"><?= $row["division"]; ?></td>
											<td class="text-center"><?= $row["framedipaddress"] ?></td>
											<td class="text-center"><?= $row["callingstationid"] ?></td>
											<td class="text-center"><?= $row["reply"]; ?></td>
											<td class="text-center"><?= $row["authdate"]; ?></td>
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
								</tbody>
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
			$('#datatables').DataTable({
				responsive: true,
				lengthMenu: [
					[5, 10, 25, 50, -1],
					[5, 10, 25, 50, 'All'],
				],
			});
		});
	</script>

</body>

</html>
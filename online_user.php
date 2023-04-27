<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$online = query("SELECT * FROM radacct LEFT JOIN organization ON radacct.username = organization.username ORDER BY radacct.acctstarttime DESC");

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
					<div class="card-header text-white bg-primary font-weight-bold">DATA AKUN ONLINE</div>
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
								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($online as $row) : ?>
										<?php $username = $row["username"];
										$detik = $row["acctsessiontime"];
										$jam = floor($row["acctsessiontime"] / 3600);
										$sisaJam = $detik - ($jam * 3600);
										$menit = floor($sisaJam / 60);
										$sisaMenit = $sisaJam - ($menit * 60);
										$sisaDetik = $detik - ($jam * 3600) - ($menit * 60);

										?>
										<tr>
											<td class="text-center"><?= $i; ?></td>
											<td><?= $row["username"]; ?></td>
											<td><?= $row["name"]; ?></td>
											<td><?= $row["division"]; ?></td>
											<td class="text-center"><?= $row["framedipaddress"]; ?></td>
											<td class="text-center"><?= $row["callingstationid"]; ?></td>
											<td class="text-center"><?= $row["acctstarttime"]; ?></td>

											<td class="text-center">
												<?= ($jam == "0") ? "" : "$jam jam"; ?>
												<?= ($menit == "0") ? "" : " $menit menit"; ?>
												<?= ($sisaDetik == "0") ? "" : "$sisaDetik detik"; ?>
											</td>
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
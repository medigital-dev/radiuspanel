<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$online = query("SELECT * FROM radacct ORDER BY acctstarttime DESC");

$navigasi = "";
$navigasi = "user";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel</title>
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/datatables.min.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<div class="container pt-3" style="padding-bottom: 5rem;">

		<div style="position: absolute; left: 50%; transform: translate(-50%, 0%); width: 1200px; margin-bottom: 30px">
			<table class="table table-bordered table-striped table-hover" id="datatables">
				<thead style="background-color: #004C94; color: white;">
					<tr align="center">
						<th>ID</th>
						<th>Username</th>
						<th>IP Address</th>
						<th>Mac Address</th>
						<th>Start Time</th>
						<th>Up Time</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($online as $row) : ?>
						<?php $username = $row["username"];
						//					$result = mysqli_query($conn, "SELECT * FROM radcheck WHERE username = '$username'");
						//					$user = mysqli_fetch_assoc($result);

						$detik = $row["acctsessiontime"];
						$jam = floor($row["acctsessiontime"] / 3600);
						$sisaJam = $detik - ($jam * 3600);
						$menit = floor($sisaJam / 60);
						$sisaMenit = $sisaJam - ($menit * 60);
						$sisaDetik = $detik - ($jam * 3600) - ($menit * 60);

						?>
						<tr>
							<td align="center"><?= $i; ?></td>
							<td><?= $row["username"]; ?></td>
							<td align="center"><?= $row["framedipaddress"]; ?></td>
							<td align="center"><?= $row["callingstationid"]; ?></td>
							<td align="center"><?= $row["acctstarttime"]; ?></td>

							<td align="center">
								<?php
								if ($jam == "0") {
									echo "";
								} else {
									echo "$jam jam";
								}
								?>
								<?php
								if ($menit == "0") {
									echo "";
								} else {
									echo " $menit menit";
								}
								?>
								<?php
								if ($sisaDetik == "0") {
									echo "";
								} else {
									echo "$sisaDetik detik";
								}
								?>
							</td>
						</tr>
						<?php $i++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#datatables').DataTable();
		});
	</script>
</body>

</html>
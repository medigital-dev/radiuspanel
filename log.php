<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$log = query("SELECT * FROM radpostauth ORDER BY authdate DESC");

$navigasi = "";
$navigasi = "log";

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
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header text-white bg-primary font-weight-bold">LOGS AKSES</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover" id="datatables">
								<thead style="background-color: #004C94; color: white;">
									<tr align="center">
										<th style="width: 10px;">No</th>
										<th>Username</th>
										<th>IP Address</th>
										<th>Mac Address</th>
										<th>Reply Status</th>
										<th>Auth Date</th>
									</tr>
								</thead>
								<tbody style="background-color: white">
									<?php $i = 1; ?>
									<?php foreach ($log as $row) : ?>
										<?php
										$username = $row["username"];
										$result = mysqli_query($conn, "SELECT * FROM radcheck WHERE username = '$username'");
										$user = mysqli_fetch_assoc($result);
										$ipMac = mysqli_query($conn, "SELECT * FROM radacct WHERE username ='$username'");
										$ip = mysqli_fetch_assoc($ipMac);
										?>
										<tr>
											<td align="center"><?= $i; ?></td>
											<td><?= $row["username"]; ?></td>
											<td align="center"><?= $ip["framedipaddress"] ?></td>
											<td align="center"><?= $ip["callingstationid"] ?></td>
											<td align="center"><?= $row["reply"]; ?></td>
											<td align="center"><?= $row["authdate"]; ?></td>
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
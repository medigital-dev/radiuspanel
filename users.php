<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$user = query("SELECT radcheck.id AS radcheck_id, radcheck.value AS passwd, radcheck.username AS radcheck_username, organization.username AS org_username, organization.name AS nama, organization.division AS division, organization.class AS class, organization.registered_at as registered_at FROM radcheck LEFT JOIN organization ON radcheck.username = organization.username");

$navigasi = "";
$navigasi = "user";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - User</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel-white.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<div class="container pt-3" style="padding-bottom: 5rem;">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header bg-primary text-white font-weight-bold">DATA AKUN</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover w-100" id="datatables">
								<thead>
									<tr align="center" style="color: white; background-color: #004C94">
										<th style="width: 30px">NO</th>
										<th>USERNAME</th>
										<th>NAME</th>
										<th>DIVISION</th>
										<th>CLASS</th>
										<th>REG DATE</th>
										<th style="width: 150px">PASSWORD</th>
										<th style="width: 100px">ACTION</th>
									</tr>
								</thead>

								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($user as $row) : ?>
										<?php $username = $row['radcheck_username']; ?>
										<tr>
											<td align="center"><?= $i; ?></td>
											<td align="center"><?= $row["radcheck_username"]; ?></td>
											<td align="center"><?= $row["nama"]; ?></td>
											<td align="center"><?= $row["division"]; ?></td>
											<td align="center"><?= $row["class"]; ?></td>
											<td align="center"><?= $row["registered_at"]; ?></td>
											<td align="center"><?= $row["passwd"]; ?></td>
											<td align="center">
												<div class="d-flex justify-content-center">
													<a class="btn btn-warning btn-sm" href="edit.php?id=<?= $row["radcheck_id"]; ?>">Edit</a>&nbsp;
													<a class="btn btn-danger btn-sm" href="delete.php?id=<?= $row["radcheck_id"]; ?>" onclick="return confirm('yakin hapus <?= $username; ?>?');">Delete</a>
												</div>
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
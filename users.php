<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$user = query("SELECT * FROM radcheck");

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
							<table class="table table-bordered table-striped table-hover" id="datatables">
								<thead>
									<tr align="center" style="color: white; background-color: #004C94">
										<th style="width: 30px">NO</th>
										<th>USERNAME</th>
										<th style="width: 150px">PASSWORD</th>
										<th style="width: 100px">ACTION</th>
									</tr>
								</thead>

								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($user as $row) : ?>

										<tr>
											<td align="center"><?php echo $i; ?></td>
											<td align="center"><?php echo $row["username"]; ?></td>
											<td align="center"><?php echo $row["value"]; ?></td>
											<td align="center">
												<a class="btn btn-warning btn-sm" href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>&nbsp;
												<a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('yakin hapus <?= $row["username"]; ?>?');">Delete</a>
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
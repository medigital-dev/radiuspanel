<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$id = $_GET["id"];

$user = query("SELECT radcheck.id AS radcheck_id, radcheck.value AS passwd, radcheck.username AS radcheck_username, organization.username AS org_username, organization.name AS nama, organization.division AS division, organization.class AS class, organization.registered_at as registered_at FROM radcheck LEFT JOIN organization ON radcheck.username = organization.username WHERE radcheck.id = '$id'")[0];

if (isset($_POST["submit"])) {

	if (edit($_POST) > 0) {
		echo "
			<script>
				alert('Data Berhasil diedit');
				document.location.href = 'users.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal diedit');
				document.location.href = 'users.php';
			</script>
			";
	}
}

// navigasi
$navigasi = "";
$navigasi = "user";
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>RadiusPanel - Edit User</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>

<body>

	<?php include 'navigasi.html'; ?>

	<div class="container py-3 mb-5">
		<div class="row">
			<div class="col-lg-4 mx-auto">
				<div class="card shadow">
					<div class="card-header bg-primary text-white font-weight-bold">
						EDIT USER
					</div>
					<div class="card-body">
						<form action="" method="POST">
							<input type="hidden" name="id" value="<?= $user["radcheck_id"]; ?>">
							<div class="form-group">
								<label for="username">Username</label>
								<input name="username" type="text" class="form-control" id="username" aria-describedby="nisHelp" placeholder="Enter Username" value="<?= $user["radcheck_username"]; ?>" required>
							</div>
							<div class="form-group">
								<label for="name">Nama</label>
								<input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Input name" value="<?= $user["nama"]; ?>" required>
							</div>
							<div class="form-group">
								<label for="division">Division</label>
								<input name="division" type="text" class="form-control" id="division" aria-describedby="divisionHelp" placeholder="Input division" value="<?= $user["division"]; ?>" required>
							</div>
							<div class="form-group">
								<label for="class">Class</label>
								<input name="class" type="text" class="form-control" id="class" aria-describedby="classHelp" placeholder="Input class" value="<?= $user["class"]; ?>" required>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input name="password" type="password" class="form-control" id="password" aria-describedby="PasswordHelp" placeholder="Enter Password" value="<?= $user["passwd"]; ?>" required>
							</div>
							<div class="d-flex justify-content-between">
								<a class="btn btn-warning" href="users.php" title="Kembali">Kembali</a>
								<button class="btn btn-primary" type="submit" name="submit">Edit User</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/popper.min.js"></script>

</body>

</html>
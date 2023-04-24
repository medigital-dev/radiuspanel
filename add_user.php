<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

$navigasi = "";
$navigasi = "user";

require "functions.php";

if (isset($_POST["submit"])) {
	if (tambah($_POST) > 0) {
		echo "
			<script>
				alert('Data Berhasil ditambahkan');
				document.location.href = 'add_user.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal ditambahkan');
				document.location.href = 'add_user.php';
			</script>
			";
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - Tambah User</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel-white.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<form action="" method="POST">
		<div class="container py-4">
			<div class="row">
				<div class="col-lg-4 mx-auto">
					<div class="card shadow">
						<div class="card-header bg-primary text-white font-weight-bold">
							TAMBAH USER
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="username">Username</label>
								<input name="username" type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Input username" required>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input name="value" type="text" class="form-control" id="password" aria-describedby="PasswordHelp" placeholder="Input password" required>
							</div>
							<button class="btn btn-primary" type="submit" name="submit">
								<i class="fas fa-plus"></i>
								Tambah User
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<?php include 'footer.html'; ?>

	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
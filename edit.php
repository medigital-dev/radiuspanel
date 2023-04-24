<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$id = $_GET["id"];

$user = query("SELECT * FROM radcheck WHERE id = $id")[0];

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
	<link rel="shortcut icon" href="img/icon_RadiusPanel-white.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>

<body>

	<?php include 'navigasi.html'; ?>

	<div class="container" style="margin-top: 80px; min-height: 510px;">

		<form action="" method="POST">
			<input type="hidden" name="id" value="<?php echo $user["id"]; ?>">

			<div style="width: 400px; height: 400px; border-radius: 10px; position: absolute; left: 50%; transform: translate(-50%, 0); border: 2px solid darkblue; background-color: white">
				<div align="center" style="width: 100%">
					<div style="width: 100%; background-color: darkblue; color: white; text-align: center; height: 50px; border-radius: 7px 7px 0 0; padding: 14px; font-weight: bold;">
						EDIT USER
					</div>
				</div>
				<div style="margin: 17px; width: 90%">
					<div class="form-group">
						<label for="username">Username</label>
						<input name="username" type="text" class="form-control" id="username" aria-describedby="nisHelp" placeholder="Enter NIS" value="<?php echo $user["username"]; ?>" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="value" type="text" class="form-control" id="password" aria-describedby="PasswordHelp" placeholder="Enter Password" value="<?php echo $user["value"]; ?>" required>
					</div>
				</div>
				<div style="position: fixed; left: 20px; bottom: 20px">
					<a class="btn btn-warning" href="/" title="Kembali">Kembali</a>
				</div>
				<div align="center" style="position: fixed;right: 20px; bottom: 20px;">
					<button class="btn btn-primary" type="submit" name="submit">Edit User</button>
				</div>
			</div>
		</form>

	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>

</html>
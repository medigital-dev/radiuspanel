<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$admin = query("SELECT * FROM admin WHERE username = 'admin'")[0];

if (isset($_POST["submit"])) {

	if (changepassword($_POST) > 0) {
		echo "
			<script>
				alert('Data Berhasil diedit');
				document.location.href = 'admin.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal diedit');
			</script>
			";
	}
}

$navigasi = "";
$navigasi = "system";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - Administrator</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel-white.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<div class="container pt-3" style="padding-bottom: 5rem">
		<div class="row">
			<div class="col-lg-4 mx-auto">
				<div class="card shadow">
					<div class="card-header text-white bg-primary font-weight-bold">GANTI PASSWORD</div>
					<div class="card-body">
						<form action="" method="POST">
							<input type="hidden" name="id" value="<?php echo $admin["id"]; ?>">
							<input type="hidden" name="username" value="<?php echo $admin["username"]; ?>">
							<fieldset disabled>
								<div class="form-group">
									<label for="username">Username</label>
									<input name="username" type="text" class="form-control" id="username" aria-describedby="nisHelp" placeholder="Enter NIS" value="<?php echo $admin["username"]; ?>" required>
								</div>
							</fieldset>
							<div class="form-group">
								<label for="oldpassword">Password lama</label>
								<input name="oldpassword" type="password" class="form-control" id="oldpassword" aria-describedby="oldpasswordHelp" placeholder="Input password lama" required>
							</div>
							<div class="form-group">
								<label for="newpassword">Password baru</label>
								<input name="newpassword" type="password" class="form-control" id="newpassword" aria-describedby="newpasswordHelp" placeholder="Input password baru" required>
							</div>
							<div class="form-group">
								<label for="newpassword2">Konfirmasi password baru</label>
								<input name="newpassword2" type="password" class="form-control" id="newpassword2" aria-describedby="newpassword2Help" placeholder="Input lagi password baru" required>
							</div>
							<button class="btn btn-danger" type="submit" name="submit">Ganti Password</button>

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
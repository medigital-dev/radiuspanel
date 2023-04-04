<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
 	header("Location: login.php");
 	exit;
}

$navigasi = "";
$navigasi = "user";

require "functions.php";

if( isset($_POST["submit"]) ) {
	if( tambah($_POST) > 0 ) {
		echo "
			<script>
				alert('Data Berhasil ditambahkan');
				document.location.href = 'add_user.php';
			</script>
		";
		}
		else {
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
	<title>RadiusPanel</title>
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>
<body>
	<?php include 'navigasi.html'; ?>
	
	<form action="" method="POST">
	<div class="container" style="margin-top: 80px; min-height: 510px;">
		<div style="width: 400px; height: 400px; border-radius: 10px; position: absolute; left: 50%; transform: translate(-50%, 0); border: 2px solid darkblue; background-color: white">
			<div align="center" style="width: 100%">
				<div style="width: 100%; background-color: darkblue; color: white; text-align: center; height: 50px; border-radius: 7px 7px 0 0; padding: 14px; font-weight: bold;">
				<i class="fas fa-user-plus"></i>
				&nbsp;TAMBAH USER
				</div>
			</div>
			<div style="margin: 17px; width: 90%">
				<div class="form-group">
					<label for="username">Username</label>
					<input name="username" type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Input username" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input name="value" type="text" class="form-control" id="password" aria-describedby="PasswordHelp" placeholder="Input password" required>
				</div>
			</div>
			<!--
			<div style="position: fixed; left: 20px; bottom: 20px">
				<a class="btn btn-warning" href="add_user.php" title="Kembali">Kembali</a>
			</div>
			-->
			<div align="center" style="position: fixed;right: 20px; bottom: 20px;">
				<button class="btn btn-primary" type="submit" name="submit">
				<i class="fas fa-plus"></i>	
				Tambah User</button>
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
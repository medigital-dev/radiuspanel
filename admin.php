<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
 	header("Location: login.php");
 	exit;
}

require 'functions.php';

$admin = query("SELECT * FROM admin WHERE username = 'admin'")[0];

	if( isset($_POST["submit"]) ) {

	if( changepassword($_POST) > 0 ) {
		echo "
			<script>
				alert('Data Berhasil diedit');
				document.location.href = 'admin.php';
			</script>
		";
		}
		else {
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
	<title>RadiusPanel</title>
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
</head>
<body>
	<?php include 'navigasi.html'; ?>
	
	<div class="container" style="margin-top: 80px; min-height: 510px;">

	<form action="" method="POST">
	<input type="hidden" name="id" value="<?php echo $admin["id"]; ?>">
	<input type="hidden" name="username" value="<?php echo $admin["username"]; ?>">

		<div style="width: 400px; height: 500px; border-radius: 10px; position: absolute; left: 50%; transform: translate(-50%, 0); border: 2px solid darkred">
			<div align="center" style="width: 100%">
				<div style="background-color: darkred; color: white; text-align: center; height: 50px; border-radius: 7px 7px 0 0; padding: 14px; font-weight: bold;">
					GANTI PASSWORD
				</div>
			</div>
			<div style="margin: 17px; width: 90%; margin-bottom: 80px">
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
			</div>
			
			<div style="position: fixed; right: 20px; bottom: 20px;">
				<button class="btn btn-danger" type="submit" name="submit">Ganti Password</button>
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
<?php

session_start();

if( !isset($_SESSION["login"]) ) {
 	header("Location: login.php");
 	exit;
}

require 'functions.php';

$user = query("SELECT * FROM radcheck");

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
	
	<div class="container" style="margin-top: 80px; min-height: 700px;">

    <div style="position: absolute; left: 50%; transform: translate(-50%, 0%); width: 960px; margin-bottom: 30px">
	<table class="table table-bordered table-striped table-hover" id="datatables" style="background-color: white;">
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
		<?php foreach( $user as $row ) : ?>

		<tr>			
			<td align="center"><?php echo $i; ?></td>
			<td align="center"><?php echo $row["username"]; ?></td>
			<td align="center"><?php echo $row["value"]; ?></td>
			<td align="center">
				<a class="btn btn-warning btn-sm" href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>&nbsp;
				<a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $row["id"]; ?>" 
					onclick="return confirm('yakin hapus <?= $row["username"]; ?>?');">Delete</a>
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
		$(document).ready( function () {
    	$('#datatables').DataTable();
		} );
	</script>

</body>
</html>
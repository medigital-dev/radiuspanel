<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

// mysql connect
include 'functions.php';

// navigasi
$navigasi = "";
$navigasi = "home";

// jumlah
$jmlUser = count(query("SELECT * FROM radcheck"));
$jmlOnline = count(query("SELECT * FROM radacct WHERE acctstoptime = NULL"));
$jmlLog = count(query("SELECT * FROM radpostauth"));

// run
$radver = exec("sudo freeradius -v | grep 'Version' | awk 'FNR == 2 {print $3}'");
$radstat = exec("/etc/init.d/freeradius status | grep 'Active:' | awk '{print $2}'");
$os = exec("lsb_release -d | awk '{print $2,$3,$4,$5}'");
$processor = exec("cat /proc/cpuinfo | grep 'model name' | cut -d: -f2");
$hdd = exec("df -h | grep sda | awk '{print $2}'");
$ram = exec("free -h | grep Mem | awk '{print $2}'");
$ramused = exec("free -h | grep Mem | awk '{print $3}'");

if (isset($_POST["rad_restart"])) {
	exec("sudo /etc/init.d/freeradius restart");
	header("location: /");
}

if (isset($_POST["rad_stop"])) {
	exec("sudo /etc/init.d/freeradius stop");
	header("location: /");
}

if (isset($_POST["rad_start"])) {
	exec("sudo /etc/init.d/freeradius start");
	header("location: /");
}

if (isset($_POST["sys_reboot"])) {
	header("location: /");
	exit(0);
	exec("sudo reboot");
}

if (isset($_POST["sys_off"])) {
	header("location: /");
	exec("sudo shutdown -h now");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - Home</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">

</head>

<body>
	<!-- Navigasi -->
	<?php include 'navigasi.html'; ?>
	<!-- end Navigasi -->

	<div class="container py-3 mb-5">
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<div class="col mb-4">
				<div class="card shadow text-white bg-primary">
					<div class="card-header">
						<i class="fas fa-users" aria-hidden="true"></i>
						User
					</div>
					<div class="card-body">
						<p class="card-text" style="font-size: 40px;"><?= $jmlUser; ?><span style="font-size: 20px;"> user</span></p>
					</div>
					<div class="card-footer bg-transparent">
						<a href="users.php" style="color: white; text-decoration: none;">
							Selengkapnya <i class="fas fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col mb-4">
				<div class="card shadow text-white bg-secondary">
					<div class="card-header">
						<i class="fas fa-circle" aria-hidden="true" style="color: lime;"></i>
						Online User
					</div>
					<div class="card-body">
						<p class="card-text" style="font-size: 40px;"><?= $jmlOnline; ?><span style="font-size: 20px;"> user</span></p>
					</div>
					<div class="card-footer bg-transparent"><a href="online_user.php" style="color: white; text-decoration: none;">
							Selengkapnya <i class="fas fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col mb-4">
				<div class="card shadow text-white bg-warning">
					<div class="card-header">
						<i class="fas fa-clipboard-check"></i>
						Akses Log
					</div>
					<div class="card-body">
						<p class="card-text" style="font-size: 40px;"><?= $jmlLog; ?><span style="font-size: 20px;"> list</span></p>
					</div>
					<div class="card-footer bg-transparent"><a href="log.php" style="color: white; text-decoration: none;">
							Selengkapnya <i class="fas fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<form action="" method="POST">
			<div class="row row-cols-1 row-cols-md-2">
				<div class="col mb-4">
					<div class="card shadow h-100">
						<div class="card-header bg-success text-white">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
							Informasi FreeRadius
						</div>
						<div class="card-body">
							<table style="width: 70%;">
								<tr>
									<td style="width: 150px;">FreeRadius Versi</td>
									<td style="width: 15px;">:</td>
									<td><?= $radver; ?></td>
								</tr>
								<tr>
									<td>FreeRadius Status</td>
									<td>:</td>
									<td>
										<?php if ($radstat == "active") : ?>
											<div class="spinner-grow spinner-grow-sm text-success" role="status">
												<span class="sr-only">Loading... </span>
											</div>
											Aktif
										<?php elseif ($radstat == "inactive") : ?>
											<div class="spinner-grow spinner-grow-sm text-danger" role="status">
												<span class="sr-only">Loading... </span>
											</div>
											Inactive
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td>RadiusPanel Versi</td>
									<td>:</td>
									<td>v<?= appsVar()['appsVers']; ?></td>
								</tr>
								<tr>
									<td>Database Versi</td>
									<td>:</td>
									<td>v<?= appsVar()['dbVers']; ?></td>
								</tr>
							</table>
						</div>
						<div class="card-footer bg-transparent text-center">
							<div class="btn-group btn-group-sm">
								<button class="btn btn-sm btn-success" title="Start Freeradius" type="submit" name="rad_start">
									<i class="fas fa-play"></i>
								</button>
								<button class="btn btn-sm btn-success" title="Stop Freeradius" type="submit" name="rad_stop">
									<i class="fas fa-stop"></i>
								</button>
								<button class="btn btn-sm btn-success" title="Restart Freeradius" type="submit" name="rad_restart">
									<i class="fas fa-redo-alt"></i>
								</button>
								<button class="btn btn-sm btn-success" title="Cek Update" type="button" id="btn-update">
									<i class="fas fa-sync-alt mr-1"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col mb-4">
					<div class="card shadow h-100">
						<div class="card-header bg-danger text-white">
							<i class="fas fa-server" aria-hidden="true"></i>
							Informasi System
						</div>
						<div class="card-body">
							<table style="width: 100%;">
								<tr>
									<td style="width: 150px;">Sistem Operasi</td>
									<td style="width: 15px;">:</td>
									<td><?= $os; ?></td>
								</tr>
								<tr>
									<td>Prosessor</td>
									<td>:</td>
									<td><?= $processor; ?></td>
								</tr>
								<tr>
									<td>Hardisk</td>
									<td>:</td>
									<td><?= $hdd; ?></td>
								</tr>
								<tr>
									<td>RAM</td>
									<td>:</td>
									<td><?= $ramused; ?> of <?= $ram; ?></td>
								</tr>
							</table>
						</div>
						<div class="card-footer bg-transparent text-center">
							<div class="btn-group">
								<button class="btn btn-sm btn-danger" title="Reboot Server" type="submit" name="sys_reboot">
									<i class="fas fa-sync-alt"></i>
								</button>
								<button class="btn btn-sm btn-danger" title="Shutdown Server" type="submit" name="sys_off">
									<i class="fas fa-power-off"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Updating RadiusPanel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="d-flex align-items-center">
						<strong>Loading...</strong>
						<div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/popper.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#btn-update').click(async function() {
				const currentVersion = <?= appsVar()['appsVers']; ?>;
				$(this).children('i').toggleClass('fa-spin');
				const radiuspanel = await fetch('https://api.github.com/repos/medigital-dev/radiuspanel/releases/latest').then(response => response.json()).catch(response => console.log(response));

				const cloudVersion = radiuspanel.tag_name;
				if (cloudVersion > currentVersion) {
					if (confirm('Update RadiusPanel v' + cloudVersion + ' tersedia! Update sekarang?')) {
						$.post('script/update.php', response => {
							$('#updateModal').modal('show');
							if (response == true) {
								window.open('logout.php', '_self');
							}
						});
						// $(this).children('i').toggleClass('fa-spin');
						// window.open('https://github.com/medigital-dev/radiuspanel', '_blank');
					} else {
						return;
					}
				} else {
					alert('Update RadiusPanel belum tersedia!');
				}
				$(this).children('i').toggleClass('fa-spin');
			});
		});
	</script>
</body>

</html>
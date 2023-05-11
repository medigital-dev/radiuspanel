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
$jmlOnline = count(query("SELECT * FROM radacct WHERE acctstoptime = ''"));
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
	header("location: logout.php");
	exec("sudo reboot");
}

if (isset($_POST["sys_off"])) {
	header("location: logout.php");
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
					<div class="card shadow bg-success text-white h-100">
						<div class="card-header">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
							Informasi FreeRadius
						</div>
						<div class="card-body">
							<div class="row pb-2 px-2">
								<div class="col-lg-5 py-2">Freeradius Version</div>
								<div class="col py-2 bg-light rounded text-success"><?= $radver; ?></div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-5 py-2">Freeradius Status</div>
								<div class="col py-2 bg-light rounded text-success">
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
								</div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-5 py-2">RadiusPanel Version</div>
								<div class="col py-2 bg-light rounded text-success">v<?= appsVar()['appsVers']; ?></div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-5 py-2">Database Version</div>
								<div class="col py-2 bg-light rounded text-success">v<?= appsVar()['dbVers']; ?></div>
							</div>
						</div>
						<div class="card-footer bg-transparent text-center">
							<div class="btn-toolbar justify-content-center">
								<div class="btn-group btn-group-sm">
									<button class="btn btn-sm btn-success" title="Start Freeradius" type="submit" name="rad_start">
										<i class="fas fa-fw fa-play"></i>
										Start
									</button>
									<button class="btn btn-sm btn-success" title="Stop Freeradius" type="submit" name="rad_stop">
										<i class="fas fa-fw fa-stop"></i>
										Stop
									</button>
									<button class="btn btn-sm btn-success" title="Restart Freeradius" type="submit" name="rad_restart">
										<i class="fas fa-fw fa-redo-alt"></i>
										Restart
									</button>
								</div>
								<div class="btn-group btn-group-sm">
									<button class="btn btn-sm btn-success" title="Cek Update" type="button" id="btn-update">
										<i class="fas fa-fw fa-sync-alt mr-1"></i>
										Cek Update
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col mb-4">
					<div class="card shadow bg-danger text-white h-100">
						<div class="card-header">
							<i class="fas fa-server" aria-hidden="true"></i>
							Informasi System
						</div>
						<div class="card-body">
							<div class="row pb-2 px-2">
								<div class="col-lg-4 py-2">Sistem Operasi</div>
								<div class="col py-2 bg-light rounded text-danger"><?= $os; ?></div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-4 py-2">Processor</div>
								<div class="col py-2 bg-light rounded text-danger"><?= $processor; ?></div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-4 py-2">Hardisk</div>
								<div class="col py-2 bg-light rounded text-danger"><?= $hdd; ?></div>
							</div>
							<div class="row pb-2 px-2">
								<div class="col-lg-4 py-2">RAM</div>
								<div class="col py-2 bg-light rounded text-danger"><?= $ramused; ?> of <?= $ram; ?></div>
							</div>
						</div>
						<div class="card-footer bg-transparent text-center">
							<div class="btn-group">
								<button class="btn btn-sm btn-danger" title="Reboot Server" type="submit" name="sys_reboot" onclick="return confirm('Server akan dihidupkan ulang, yakin?')">
									<i class="fas fa-fw fa-sync-alt"></i>
									Reboot System
								</button>
								<button class="btn btn-sm btn-danger" title="Shutdown Server" type="submit" name="sys_off" onclick="return confirm('Server akan dimatikan, yakin?')">
									<i class="fas fa-fw fa-power-off"></i>
									Shutdown System
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="modal fade" id="updateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						$('#updateModal').modal('show');
						$.post('script/update.php', response => {
							if (response == true) {
								if (confirm('Update berhasil! Logout sekarang?')) {
									window.open('logout.php', '_self');
								} else {
									$('#updateModal').modal('hide');
									$(this).children('i').toggleClass('fa-spin');
									return;
								}
							}
						});
					} else {
						$(this).children('i').toggleClass('fa-spin');
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
<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

$user = query("SELECT radcheck.id AS radcheck_id, radcheck.value AS passwd, radcheck.username AS radcheck_username, organization.username AS org_username, organization.name AS nama, organization.division AS division, organization.registered_at as registered_at FROM radcheck LEFT JOIN organization ON radcheck.username = organization.username");

$navigasi = "";
$navigasi = "user";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RadiusPanel - User</title>
	<link rel="shortcut icon" href="img/icon_RadiusPanel.png" type="image/x-icon">
	<link rel="stylesheet" href="css/fontawesome.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/default.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="css/responsive.bootstrap4.min.css">
</head>

<body>
	<?php include 'navigasi.html'; ?>

	<div class="container py-3 pb-5 mb-5">
		<div class="d-none" id="alert">
			<div class="alert alert-info alert-dismissible fade show" role="alert">
				<span id="alertMessage"></span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header bg-primary text-white font-weight-bold">DATA AKUN</div>
					<div class="card-body">
						<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
							<div class="btn-group shadow mr-2 mb-2" role="group">
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAccount"><i class="fas fa-plus-circle"></i></button>
								<button type="button" class="btn btn-danger btn-sm" title="Hapus Akun Terpilih" id="btn-deleteAccount"><i class="fas fa-trash-alt"></i></button>
							</div>
							<div class="btn-group shadow mr-2 mb-2" role="group">
								<button type="button" class="btn btn-info btn-sm" title="Pilih Semua/Balikkan pilihan" id="btn-select"><i class="fas fa-check-circle"></i></button>
								<button type="button" class="btn btn-info btn-sm" title="Hapus pilihan" id="btn-deselect"><i class="fas fa-minus-circle"></i></button>
							</div>
							<div class="btn-group shadow mr-2 mb-2" role="group">
								<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importAccount" title="Import Akun" id="btn-import"><i class="fas fa-upload"></i></button>
							</div>
							<div class="btn-group shadow mr-2 mb-2" role="group">
								<button type="button" class="btn btn-warning btn-sm" title="Reload Tabel" id="btn-reload"><i class="fas fa-sync-alt"></i></button>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-hover w-100" id="datatables" onmouseleave="hidePassword()">
								<thead>
									<tr class="text-center" style="color: white; background-color: #004C94">
										<th class="align-middle" style="width: 30px">NO</th>
										<th class="align-middle">USERNAME</th>
										<th class="align-middle">NAME</th>
										<th class="align-middle">DIVISION</th>
										<th class="align-middle">REG DATE</th>
										<th style="width: 20px;" class="align-middle">PASSWORD</th>
										<th class="align-middle">ACTION</th>
									</tr>
								</thead>

								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="addAccount" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tambah Akun</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" id="addAccountForm">
						<div class="container-fluid">
							<div class="form-group">
								<label for="username">Username</label>
								<input name="username" type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Input username" required>
							</div>
							<div class="form-group">
								<label for="name">Nama</label>
								<input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Input name" required>
							</div>
							<div class="form-group">
								<label for="division">Division</label>
								<input name="division" type="text" class="form-control" id="division" aria-describedby="divisionHelp" placeholder="Input division" required>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input name="password" type="password" class="form-control" id="password" aria-describedby="PasswordHelp" placeholder="Input password" required>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary" id="btn-saveAccount">Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="importAccount" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="post" enctype="multipart/form-data" action="import.php" id="importForm">
					<div class="modal-header">
						<h5 class="modal-title">Import Akun</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<label>Silahkan pilih file excel:</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
								</div>
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file" required accept="application/vnd.ms-excel">
									<label class="custom-file-label" for="inputGroupFile01">Pilih file</label>
								</div>
							</div>
							<div class="d-none" id="progress">
								<div class="progress mb-3">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
								</div>
							</div>
							<a href="template.xls">
								Download template Import
							</a>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary" id="btn-importAccount">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include 'footer.html'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/datatables.min.js"></script>
	<script src="js/dataTables.bootstrap4.min.js"></script>
	<script src="js/responsive.bootstrap4.min.js"></script>
	<script src="js/bs-custom-file-input.min.js"></script>

	<script>
		function showPassword(id) {
			var x = document.getElementById(id);
			if (x.type === 'password') {
				x.type = 'text';
			} else {
				x.type = 'password';
			}
		}

		function hidePassword() {
			const elm = $('tbody input');
			elm.each((i, e) => e.type = 'password');
		}

		function editUser(id) {
			if (!confirm('Edit user?')) {
				return;
			}
			document.location.href = 'edit.php?id=' + id;
		}

		function deleteUser(id) {
			if (!confirm('Hapus user?')) {
				return;
			}
			document.location.href = 'delete.php?id=' + id;
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			bsCustomFileInput.init();

			const usertable = $('#datatables').DataTable({
				responsive: true,
				lengthMenu: [
					[5, 10, 25, 50, 100, -1],
					[5, 10, 25, 50, 100, 'All'],
				],
				language: {
					url: 'js/id.json',
				},
				ajax: {
					url: 'ajax/getUser.php',
					dataSrc: '',
					type: 'POST'
				},
				columns: [{
						data: 'no'
					},
					{
						data: 'username'
					},
					{
						data: 'name'
					},
					{
						data: 'division'
					},
					{
						data: 'regdate'
					},
					{
						data: 'password'
					},
					{
						data: 'action'
					},
				],
				columnDefs: [{
						className: "text-center",
						targets: [0, 1, 3, 4, 5, 6]
					}, {
						searchable: false,
						targets: [0, 5, 6]
					},
					{
						orderable: false,
						targets: [5, 6]
					}
				]
			});

			$('#importForm').on('submit', function(e) {
				e.preventDefault();
				$('#progress').toggleClass('d-none');
				var formData = new FormData(this);
				let file = $('#inputGroupFile01').prop('files');
				formData.append('file', file[0]);
				$.ajax({
					url: 'import.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					dataType: 'json',
					success: function(response) {
						$('#alert').toggleClass('d-none');
						$('#alertMessage').text(response.s + ' dari ' + response.t + ' user berhasil diimport!');
						usertable.ajax.reload(null, false);
						$('#importAccount').modal('hide');
					},
					error: function(xhr, status, error) {
						console.log(xhr.responseText);
						$('#progress').toggleClass('d-none');
					}
				});
			});

			$('#addAccount').on('hidden.bs.modal', () => $('#addAccountForm')[0].reset());
			$('#importAccount').on('hidden.bs.modal', () => {
				$('#inputGroupFile01').val('');
				$('#progress').addClass('d-none');
			});

			$('#btn-deleteAccount').click(function() {
				$(this).html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>').prop('disabled', true);
				const selected = $('.table-success');
				if (selected.length == 0) {
					alert('Pilih user yang akan dihapus terlebih dahulu!');
					$(this).html('<i class="fas fa-trash-alt"></i>').prop('disabled', false);
					return;
				}
				if (confirm('Hapus permanen username sejumlah ' + selected.length + '?')) {
					selected.each((i, elm) => {
						const data = {
							username: elm.querySelector('code').innerText
						};
						$.post('ajax/deleteUser.php', data);
					});
					usertable.ajax.reload(null, false);
					$(this).html('<i class="fas fa-trash-alt"></i>').prop('disabled', false);
				}
			});

			$('#btn-saveAccount').click(() => {
				const form = $('#addAccountForm');
				const dataRaw = form.serializeArray();
				const dataSet = {
					username: dataRaw[0].value,
					name: dataRaw[1].value,
					division: dataRaw[2].value,
					password: dataRaw[3].value,
				}
				$.post('ajax/addUser.php', {
					dataAccount: dataSet
				}, response => {
					alert(response.message);
					usertable.ajax.reload(null, false);
					$('#addAccount').modal('hide');
				}, 'json');
			});

			$('table tbody').on('click', 'tr td:not(:last-child)', function() {
				$(this).parent('tr').toggleClass('table-success');
			});

			$('#btn-deselect').click(function() {
				const data = $('#datatables tbody tr');
				data.each(function() {
					$(this).removeClass('table-success');
				});
			});

			$('#btn-select').click(function() {
				const data = $('#datatables tbody tr.odd, #datatables tbody tr.even');
				data.each(function(i, elm) {
					$(this).toggleClass('table-success');
				})
			});

			$('#btn-reload').click(() => usertable.ajax.reload(null, false));
		});
	</script>

</body>

</html>
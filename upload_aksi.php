<?php

include 'dbconn.php';
include "excel-reader/excel_reader2.php";

$target = basename($_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'], $target);

chmod($_FILES['file']['name'], 0777);

$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'], false);
$jumlah_baris = $data->rowcount($sheet_index = 0);

$berhasil = 0;
for ($i = 2; $i <= $jumlah_baris; $i++) {
	$username = $data->val($i, 1);
	$name = str_replace("'", "", $data->val($i, 2));
	$division = $data->val($i, 3);
	$class = $data->val($i, 4);
	$registered = $data->val($i, 5);
	$password = $data->val($i, 6);

	if ($username != "" && $password != "") {
		mysqli_query($conn, "INSERT INTO radcheck VALUES (NULL, '$username', 'Cleartext-Password', ':=', '$password')");
		mysqli_query($conn, "INSERT INTO organization VALUES (NULL, '$username', '$name', '$division', '$class', '$registered')");
		$berhasil++;
	}
}

unlink($_FILES['file']['name']);

header("location: import_user.php?berhasil=$berhasil");

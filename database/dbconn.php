<?php
date_default_timezone_set('Asia/Jakarta');

$server   = "localhost";
$user     = "root";
$pass     = "radpass";
$database = "radius";

$conn = mysqli_connect($server, $user, $pass, $database);

<?php

require 'functions.php';

$id = $_GET["id"];

if( delete($id) > 0 ) {
echo "
	<script>
		alert('Data Berhasil dihapus!');
		document.location.href = 'users.php';
	</script>
	";
} else {
	echo "
	<script>
		alert('Data gagal dihapus');
		document.location.href = 'users.php';
	</script>
	";
}

?>
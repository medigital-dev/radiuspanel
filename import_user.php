<?php 

session_start();



$navigasi = "";
$navigasi = "user";

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
	
	<form method="post" enctype="multipart/form-data" action="upload_aksi.php">
        <div style="width: 400px; height: 400px; border-radius: 10px; position: absolute; left: 50%; transform: translate(-50%, 0); border: 2px solid darkblue; background-color: white;">
            <div align="center" style="width: 100%">
                <div style="width: 100%; background-color: darkblue; color: white; text-align: center; height: 50px; border-radius: 7px 7px 0 0; padding: 14px; font-weight: bold;">
                IMPORT USER
                </div>
            </div>
            <div style="margin: 17px; width: 90%">
                <label>Silahkan pilih file excel:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file" required accept=".xls">
                        <label class="custom-file-label" for="inputGroupFile01">Pilih file</label>
                    </div>
                </div>
                <a href="template.xls">
                    Download template Import
                </a>
                <br><br>
                <a style="color: green;">
                <?php 
                    if(isset($_GET['berhasil'])){
                        echo $_GET['berhasil'];
                        echo " data berhasil di import.";
                    }
                ?>
                </a>
			</div>
			<!--
            <div style="position: fixed; left: 20px; bottom: 20px">
                <a class="btn btn-warning" href="/" title="Kembali">Kembali</a>
			</div>
				-->
            <div align="center" style="position: fixed;right: 20px; bottom: 20px;">
                <input class="btn btn-primary" name="upload" type="submit" value="Import User">
            </div>
        
        </div>
    </form>

    </div>

    <?php include 'footer.html'; ?>

    <script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		// Add the following code if you want the name of the file appear on select
		$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	</script>
</body>
</html>
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
    <title>RadiusPanel - Import User</title>
    <link rel="shortcut icon" href="img/icon_RadiusPanel.png" type="image/x-icon">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/default.css">
</head>

<body>
    <?php include 'navigasi.html'; ?>

    <div class="container py-4 mb-5">
        <form method="post" enctype="multipart/form-data" action="upload_aksi.php">
            <div class="row">
                <div class="col-lg-4 mx-auto">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white font-weight-bold">
                            IMPORT USER
                        </div>
                        <div class="card-body">
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
                                if (isset($_GET['berhasil'])) {
                                    echo $_GET['berhasil'];
                                    echo " data berhasil di import.<br><br>";
                                }
                                ?>
                            </a>
                            <input class="btn btn-primary" name="upload" type="submit" value="Import User">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include 'footer.html'; ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>
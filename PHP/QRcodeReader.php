<!DOCTYPE html>
<html lang="en">
<?php

require 'config.php';

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
    
if(empty($_SESSION["typeID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
    $result = mysqli_query($conn, "SELECT typeID FROM lib_acc 
    WHERE librarianID = '$id'");
    $row = mysqli_fetch_assoc($result);
    $type = $row['typeID'];
    if(!$type == "3"){
        header("location: adminprofile.php");
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/qrcodereader.css">
    <link rel="icon" href="../Pictures/logo-header.png" type="image/ico">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../JavaScript/html5-qrcode-min.js"></script>
    <script defer src="../JavaScript/qrcodeReader.js"></script>
    <title>QR Reader</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row reader">
            <div class="reader-side col-lg-3">
            </div>
            <div class="reader-form col-lg-6 rounded-5 border-0 shadow">
                <div class="col-lg-8 reader-frame">
                    <div id="reader" width="600px"></div>
                    <div id="scannedName"><b>Name: 
                    </div>
                </div>
            </div>
            <div class="reader-side col-lg-3">
            </div>
        </div>
    </div>
</body>
</html>

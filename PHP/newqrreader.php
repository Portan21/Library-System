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
    if(!($type == "3")){
        header("location: adminprofile.php");
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/qrcodereader.css">
    <script defer src="../JavaScript/bootstrap.bundle.min.js"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../JavaScript/html5-qrcode-min.js"></script>
    <script defer src="../JavaScript/qrcodeReader.js"></script>
    
  <link rel="icon" href="../Pictures/logo-header.png" type="image/ico">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <title>QRReader</title>
</head>
<body>
      <!-- Navbar -->
  <nav class="main-header navbar navbar-expand">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
      <a href="adminprofile.php" class="nav-link">Home</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
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

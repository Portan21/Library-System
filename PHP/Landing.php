<?php

    require 'config.php';
    
    if(empty($_SESSION["accountID"])){
        header("Location: login.php");
    }

    if(empty($_SESSION["typeID"])){ 
      header("Location: patron_landing.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Landing</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Favicons
    ================================================== -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="../CSS/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/CSS/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css" href="../CSS/catalog.css">
<link rel="stylesheet" type="text/css" href="../CSS/nivo-lightbox/nivo-lightbox.css">
<link rel="stylesheet" type="text/css" href="../CSS/nivo-lightbox/default.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Catalog</title>
    <!-- Include necessary CSS and JavaScript files here -->
</head>
<body>
    <a href="logout.php">logout, <?php echo'$_SESSION["first_name"]';?></a>
    
    <!-- Navigation Bar -->
    <nav id="menu" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="..png" alt="Library Logo" style="float: left; margin-right: 10px;">
                <a class="navbar-brand page-scroll" href="#page-top">SCRIBE</a>
                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="catalogs.php" class="page-scroll">Catalog</a></li>
                    <li><a href="request.php" class="page-scroll">Request</a></li>
                    <li><a href="borrowed.php" class="page-scroll">Borrowed</a></li>
                    <li><a href="penalty.php" class="page-scroll">Penalty</a></li>
                    <li><a class='nav-link' href='librarianprofiles-records.php'>Records</a></li>
                    <li><a href="profile.php" class="page-scroll">Profile</a></li>
                    <li><a href="logout.php" class="page-scroll">Log Out</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>

    <!-- Body Content -->
<!-- Landing page Section -->
<div id="portfolio">
  <div class="container">
    <div class="section-title">
      <h2>Library Management System</h2>
    </div>
    <center>
    <div class="row">
      <div class="portfolio-items">
        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="createlib.php" title="Create Librarian Account" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Create Librarian Account</h4>
              </div>
              <img src="..//Pictures/landing/createlib.png"  class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="issuebook.php" title=" Issue Book" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Issue Book</h4>
              </div>
              <img src="../Pictures/landing/issue.png" class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="request.php" title="Borrow Request" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Borrow Request</h4>
              </div>
              <img src="..//Pictures/landing/borrow.png" class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="approval.php" title=" Account Approval" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Account Approval</h4>
              </div>
              <img src="..//Pictures/landing/accapp.png" class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="img/portfolio/09-large.png" title=" Manage Accounts" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>Manage Accounts</h4>
              </div>
              <img src="..//Pictures/landing/manageacc.png" class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="portfolio-item">
            <div class="hover-bg"> <a href="QRcodeReader.php" title=" Manage Accounts" data-lightbox-gallery="gallery1">
              <div class="hover-text">
                <h4>QR Scanner</h4>
              </div>
              <img src="..//Pictures/landing/scanqr.jpg" class="img-responsive" alt=" Title"> </a> </div>
          </div>
        </div>
      </div>
    </div>
    </center>
  </div>
</div>  



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../JavaScript/bootstrap.js"></script>
<script type="text/javascript" src="../JavaScript/SmoothScroll.js"></script>
<script type="text/javascript" src="../JavaScript/nivo-lightbox.js"></script>
<script type="text/javascript" src="../JavaScript/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="../JavaScript/main.js"></script>

</body>
</html>
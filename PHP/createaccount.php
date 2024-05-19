<!DOCTYPE html>
<html lang="en">
<?php 

require 'config.php';

if(empty($_SESSION["accountID"])){
  header("Location: login.php");
}
else{
  $id = $_SESSION["accountID"];
  $typeid = $_SESSION["typeID"];
}

if(empty($_SESSION["typeID"])){
  header("Location: login.php");
}


date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();

if(isset($_POST["submit"])){
    $email = trim($_POST["email"]);
    $course = $_POST["course"];
    $name = "";
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    
    // Verify the email ending
    if (substr($email,-15) == "@adamson.edu.ph") {
        // Extract the name part
        $namePart = substr($email, 0, -15);

        // Replace dots with spaces and capitalize the first letter of each word
        $name = ucwords(str_replace('.', ' ', $namePart));
    }
    else{
        $name = false;
    }

    if ($name != false) {

        $duplicateEmail = mysqli_query($conn, "SELECT email FROM patron_acc WHERE email = '$email'");
        if(mysqli_num_rows($duplicateEmail) > 0){
            echo "<script> alert('Email Has Already Been Taken'); </script>";
        }
        else{
            if($password == $confirmpassword){
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
                $insertquery = "INSERT INTO patron_acc (email, password, pt_name, course, status) VALUES ('$email', '$hashed_password', '$name', '$course', '1')";
    
                mysqli_query($conn,$insertquery);

                echo "<script> alert('Patron Registration Successful'); </script>";
            }
            else{
                echo "<script> alert('Password Does Not Match'); </script>";
            }
        }


    } else {
        echo "<script> alert('Use an Adamson Email for the registration.'); </script>";
    }


}

if(isset($_POST["regis"])){
    $fname = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $accounttype = $_POST["accountType"];

    $duplicateEmail = mysqli_query($conn, "SELECT email FROM lib_acc WHERE email = '$email'");
    if(mysqli_num_rows($duplicateEmail) > 0){
        echo "<script> alert('Email Has Already Been Taken'); </script>";
    }
    else{
        if($password == $confirmpassword){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insertquery = "INSERT INTO lib_acc (email, password, name, typeID) VALUES ('$email', '$hashed_password', '$fname', '$accounttype')";

            mysqli_query($conn,$insertquery);
            echo "<script> alert('Staff Registration Successful'); </script>";
        }
        else{
            echo "<script> alert('Password Does Not Match'); </script>";
        }
    }
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Issue Book</title>
  <link rel="stylesheet" href="../CSS/index.css">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 

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
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="adminprofile.php" class="nav-link">Profile</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link btn btn-light" href="logout.php">Logout</a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/scribeLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold text-wrap"><h6>Library Management System</h6></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <?php
            if(!empty($_SESSION["typeID"])){
                $id = $_SESSION["accountID"];
                $result = mysqli_query($conn, "SELECT name, nametype FROM lib_acc 
                INNER JOIN account_type ON typeId = type_ID
                WHERE librarianID = '$id'");
                $row = mysqli_fetch_assoc($result);
                $name = $row['name'];
                $nametype = $row['nametype'];
                echo" <a href='adminprofile.php' class='d-block font-weight-bold text-wrap'>$name</a>";
                echo" <a href='adminprofile.php' class='d-block font-weight-light'>$nametype</a>";
            }
          ?>
          </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <?php
          if(!empty($_SESSION["typeID"])){
            $id = $_SESSION["accountID"];
            $result = mysqli_query($conn, "SELECT typeID FROM lib_acc WHERE librarianID = '$id'");
            $row = mysqli_fetch_assoc($result);
            $type = $row['typeID'];
            if($type == "1"){
              echo'
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <p>
                    Account Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./librarianprofiles-admin.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Librarian Profiles</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./patronprofiles-admin.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Patron Profiles</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="createaccount.php" class="nav-link active">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add an Account</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>
                    Report Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./patronattendance-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Patron Attendance</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./returnrecords-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Returned Books</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./returnpenaltyrecords-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Returned Books (Penalty)</p>
                      </a>
                    </li>
                  </li>
                </ul>
              </li>';}
            else if($type == "2"){ //!!!!!!!!!! CANNOT DISPLAY ADMIN ACCOUNT AND PATRON ACCOUNT?????????????!!!!!!!!!!!!!!
              echo'
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>
                    Account Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="createaccount.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add an Account</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>
                    Report Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./patronattendance-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Patron Attendance</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./returnrecords-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Returned Books</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./returnpenaltyrecords-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Returned Books (Penalty)</p>
                      </a>
                    </li>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>
                    Cost Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="penaltycost.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Update Penalty Cost</p>
                    </a>
                  </li>
                </ul>
              </li>';}
            else {
              echo'
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>
                    Library Operation Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="NewCatalog.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Catalog</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="newbook.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Book</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./NewRequest.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Borrow Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="returnapproval.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Return Requests</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="QRcodeReader.php" class="nav-link">
                  <p>
                    QR Reader (Patron Attendance)
                  </p>
                </a>
              </li>';}
            }
          ?>
          
        </ul>
         
       
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content mx-2">
        
        <div class="container">
            <div class="row pt-3">
                <h1 class="mt-1 mb-3 text-uppercase">Account creation</h1>
            </div>

            <div class="row mt-1 mb-2">
                <div class="col mt-2">
                    <h2 class=" text-uppercase">Staff Account</h2>
                </div>
            </div>

            <div>
                <form action="" method="post" autocomplete="off">
                    <div class="row">
                        <form action="" method="post" autocomplete="off">
                        <div class="col-md-8 mb-3 pr-4">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control mb-2 mt-1" value="" name="name" placeholder="Full Name" required>

                            <label for="email">Email Address</label>
                            <input type="text" class="form-control mb-2 mt-1" value="" name="email" placeholder="Email Address" required>
                            
                            <label for="password">Password</label>
                            <input type="password" class="form-control mb-2 mt-1" value="" name="password" placeholder="Password" required>
                            
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" class="form-control mb-2 mt-1" value="" name="confirmpassword" placeholder="Confirm Password" required>

                        </div>

                        <div class="col-md-4 mb-5 ">
                            
                            <label class="input-text" for="accounttype">Account Type</label>
                                <div class="form-check">
                                    <?php
                                    if($typeid == 1){
                                        echo"
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType1' value='1'>
                                        <h4><label class='form-check-label' for='accountType1'> Admin</label></h4>
                                        </div>
                                        <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType2' value='2'>
                                        <h4><label class='form-check-label' for='accountType2'> Head Librarian</label></h4>
                                        </div>
                                        <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType3' value='3' checked>
                                        <h4><label class='form-check-label' for='accountType3'> Librarian</label></h4>";
                                    }
                                    else if($typeid == 2){
                                        echo"
                                        <input class='form-check-input' type='radio' name='accountType' id='accountType3' value='3' checked>
                                        <h4><label class='form-check-label' for='accountType3'> Librarian</label></h4>";
                                    }


                                    ?>
                                </div>

                            <button type="submit" class="btn btn-primary btn-lg mt-2" id="regis" name="regis" onclick='return confirmApprove()'><b>CREATE ACCOUNT</b></button>
                        </div>
                        </form>
                    </div>
                </form>
            </div>

            <!-- Patron Account -->
            
            <div class="row mt-2 mb-2">
                <div class="col mt-3">
                    <h2 class=" text-uppercase">Patron Account</h2>
                </div>
            </div>

            <div>
                <form action="" method="post" autocomplete="off">
                    <div class="row pb-5">
                        <div class="col-md-12 mb-3 pr-4">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control mb-2 mt-1" value="" name="email" placeholder="Email Address" required>

                            <label for="course">Course</label>
                            <input type="text" class="form-control mb-2 mt-1" value="" name="course" placeholder="Course" required>
                            
                            <label for="password">Password</label>
                            <input type="password" class="form-control mb-2 mt-1" value="" name="password" placeholder="Password" required>
                            
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" class="form-control mb-2 mt-1" value="" name="confirmpassword" placeholder="Confirm Password" required>

                        </div>

                        <div class="col-md-12 mb-5 ">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg mt-2"><b>CREATE ACCOUNT</b></button>
                        </div>
                    </div>
                </form>
            </div>

    </section>
        


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script>
    function confirmApprove() {
        return confirm('Press "OK" to proceed on creating the account. Press "Cancel" otherwise.');
    }
</script>
<script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/accountStatus - librarian.js"></script>
    <script src = "../JavaScript/changetype.js"></script>
    <script src = "../JavaScript/app2.js"></script>
    <!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>


</body>
</html>

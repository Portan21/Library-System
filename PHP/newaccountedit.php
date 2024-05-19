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

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
        if (isset($_POST['changePasswordCheckbox'])) {
            $current = mysqli_real_escape_string($conn, $_POST["current_password"]);
            $change = mysqli_real_escape_string($conn, $_POST["change_password"]);
            $confirm = mysqli_real_escape_string($conn, $_POST["confirm_password"]);
            if(!empty($current) & !empty($change) & !empty($confirm)){
                if(!empty($_SESSION["typeID"])){
                    $result = mysqli_query($conn, "SELECT password FROM lib_acc WHERE librarianID = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    
                    if(mysqli_num_rows($result) > 0){
                        if(password_verify($current, $row["password"])){
                            if($change == $confirm){
                                if($change == $current){
                                    echo "<script> alert('New Password Cannot Be Similar With the Current Password.'); </script>";
                                }
                                else{
                                    $hashed_new_password = password_hash($change, PASSWORD_DEFAULT);

                                    $updatequery = "UPDATE lib_acc SET 
                                    password = '$hashed_new_password'
                                    WHERE librarianID = '$id';
                                    ";
        
                                    if (mysqli_query($conn, $updatequery)) {
                                        echo "<script> alert('Account Update Successful'); </script>";
                                    }
                    
                                    //echo "<script> alert('New Password Match'); </script>";
                                }
                            }
                            else{
                                echo "<script> alert('New Password Does Not Match'); </script>";
                            }
                        }
                        else{
                            echo "<script> alert('Wrong Current Password'); </script>";
                        }
                    }

                }
                else{
                    $course = mysqli_real_escape_string($conn, $_POST["course"]);

                    $result = mysqli_query($conn, "SELECT password FROM patron_acc WHERE patronID = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    
                    if(mysqli_num_rows($result) > 0){
                        if(password_verify($current, $row["password"])){
                            if($change == $confirm){
                                if($change == $current){
                                    echo "<script> alert('New Password Cannot Be Similar With the Current Password.'); </script>";
                                }
                                else{
                                    $hashed_new_password = password_hash($change, PASSWORD_DEFAULT);

                                    $updatequery = "UPDATE patron_acc SET 
                                    course = '$course',
                                    password = '$hashed_new_password'
                                    WHERE patronID = '$id';
                                    ";
        
                                    if (mysqli_query($conn, $updatequery)) {
                                        echo "<script> alert('Account Update Successful'); </script>";
                                    }
                    
                                    //echo "<script> alert('New Password Match'); </script>";
                                }
                            }
                            else{
                                echo "<script> alert('New Password Does Not Match'); </script>";
                            }
                        }
                        else{
                            echo "<script> alert('Wrong Current Password'); </script>";
                        }
                    }

                }
            }
            else{
                echo "<script> alert('Fill All Information'); </script>";
            }
        }
        else{
            if(empty($_SESSION["typeID"])){
                $course = mysqli_real_escape_string($conn, $_POST["course"]);
                
                $updatequery = "UPDATE patron_acc SET 
                course = '$course'
                WHERE patronID = '$id';
                ";

                if (mysqli_query($conn, $updatequery)) {
                    echo "<script> alert('Course Update Successful'); </script>";
                }

                //echo "<script> alert('$course'); </script>";
            }
        }

    }
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catalog</title>
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <?php
          if(!empty($_SESSION["typeID"])){
            $id = $_SESSION["accountID"];
            $result = mysqli_query($conn, "SELECT typeID FROM lib_acc WHERE librarianID = '$id'");
            $row = mysqli_fetch_assoc($result);
            $type = $row['typeID'];
            if($type == "1"){
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
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add an Account</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Edit an Account</p>
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
                      <a href="./librarianattendance-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Librarian Attendance</p>
                      </a>
                    </li>
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
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add an Account</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Edit an Account</p>
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
                      <a href="./librarianattendance-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Librarian Attendance</p>
                      </a>
                    </li>
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
                    <a href="#" class="nav-link">
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
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Catalog</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Book</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./librarianprofiles-admin.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Borrow Requests</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./librarianprofiles-admin.php" class="nav-link">
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
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class = "container pb-4 px-4">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 pt-5 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-uppercase">Account Management</h1>
                        <form action="" method="post" autocomplete="off">
                            <div class="mb-2 mt-2">
                                <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['email']; ?>" disabled>
                            </div>

                            <div class="mb-2 mt-2">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="<?php echo $_SESSION['name']; ?>" disabled>
                            </div>
                            <?php
                            if(!empty($_SESSION["typeID"])){
                                if($_SESSION["typeID"] == 1){
                                echo"
                                <div class='mb-2 mt-2'>
                                    <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                    <input type='text' class='form-control' aria-describedby='emailHelp' value='Admin' disabled>
                                </div>";
                                }
                                else if($_SESSION["typeID"] == 2){
                                    echo"
                                    <div class='mb-2 mt-2'>
                                        <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value='Head Librarian' disabled>
                                    </div>";
                                }
                                else{
                                    echo"
                                    <div class='mb-2 mt-2'>
                                        <label for='exampleInputEmail1' class='form-label'>Account Type</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value='Librarian' disabled>
                                    </div>";
                                }
                            }
                            else{
                                $result = mysqli_query($conn, "SELECT course FROM patron_acc WHERE patronID = '$id'");
                
                                while($row = mysqli_fetch_assoc($result)){
                                    $acccourse = $row['course'];
                                }
                                echo"
                                <div class='mb-2 mt-2'>
                                    <label for='exampleInputEmail1' class='form-label'>Course</label>
                                    <input type='text' class='form-control' id='course' name='course' aria-describedby='emailHelp' value='$acccourse'  required>
                                </div>";
                            }
                            ?>

                            <!-- Existing form fields... -->
                            <div class=" form-check">
                                <input type="checkbox" class="form-check-input" id="changePasswordCheckbox" name="changePasswordCheckbox">
                                <label class="form-check-label" for="changePasswordCheckbox">Change Password</label>
                            </div>

                            <!-- Additional password fields initially hidden -->
                            <div id="passwordFields" style="display:none">
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="change_password" name="change_password">
                                </div>
                                <div class="mb-2 mt-2">
                                    <label for="exampleInputPassword2" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>

                            <button type="submit" name="submit" id="submit" class="btn btn-success mt-4">Update Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    </div>
</div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/accountStatus - librarian.js"></script>
    <script src = "../JavaScript/changetype.js"></script>
    <script src = "../JavaScript/app2.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script>
        // Use jQuery to handle checkbox change event
        $(document).ready(function () {
            $('#changePasswordCheckbox').change(function () {
                // Show/hide password fields based on checkbox state
                $('#passwordFields').toggle(this.checked);
            });
        });
    </script>

</body>
</html>

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

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

$result = mysqli_query($conn, "SELECT requestID, bookID FROM book_request WHERE deadline < '$currentDateTime'");
  while($row = mysqli_fetch_assoc($result)){
      $rejbook = $row['bookID'];
      $reqID = $row['requestID'];
      $updatequery = "UPDATE book SET availability = '1' WHERE bookID = '$rejbook'";
      if (mysqli_query($conn, $updatequery)) {
          $delquery = "DELETE FROM book_request WHERE requestID = $reqID";
          
          if(mysqli_query($conn, $delquery)){
              
          };
      }
  }
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catalog</title>
  <link rel="stylesheet" href="../CSS/index.css">
  <link rel="stylesheet" href="../CSS/approval.css">
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
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
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
                    <li class="nav-item menu-open">
                      <a href="./returnrecords-admin.php" class="nav-link active">
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
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
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
                      <a href="./returnpenaltyrecords-admin.php" class="nav-link active">
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
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
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
                    <a href="./NewRequest.php" class="nav-link active">
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
        <div class = "container py-4">
        <table id="example" class="table table-borderless" style="width:100%">
            <thead>
            <tr>
                <th class='text-uppercase'><h3>Borrow Request</h3></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT br.patronID, email, br.bookID, pt_name, duration, book_name, author FROM book_request br
            INNER JOIN book b on br.bookID = b.bookID
            INNER JOIN patron_acc a on br.patronID = a.patronID");
            while($row = mysqli_fetch_assoc($result)){
                echo 
                "<tr>
                    <td class='px-4 py-2'>
                        <div class='container'>
                            <div class='row border border-secondary rounded mt-1 mb-1'>
                                <div class='col-3 text-break mt-1 mb-1 '>
                                        <h3 class='text-uppercase mb-0'>$row[pt_name]</h3>
                                        <a>Borrow Duration: <b>$row[duration] Days</b></a><br>
                                </div>
                                
                                <div class='col-7 text-break mt-1 mb-1'>
                                        <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                        <a>$row[author]</b></a><br>
                                </div>

                                <div class='col-2 d-flex justify-content-end align-items-center'>
                                    <div>
                                        <a href='approvereq.php?appreq=$row[patronID]&appbook=$row[bookID]&duration=$row[duration]'><img id='imagebtn' class='logo' src='../Pictures/accept.png' alt='logo' onclick='return confirmApprove()'></a>
                                        <a href='rejectreq.php?rejreq=$row[patronID]&rejbook=$row[bookID]'><img id='imagebtn' class='logo' src='../Pictures/reject.png' alt='logo' onclick='return confirmReject()'></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
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

</body>
</html>
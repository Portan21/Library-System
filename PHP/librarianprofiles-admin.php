<!DOCTYPE html>
<html lang="en">
<?php 

require 'config.php';

if(empty($_SESSION["accountID"])){
  header("Location: login.php");
}
else{
  $id = $_SESSION["accountID"];
  $type = $_SESSION["typeID"];
}

$id = $_SESSION["accountID"];

if(empty($_SESSION["typeID"])){
  header("Location: login.php");
}
else{
  $id = $_SESSION["accountID"];
  $result = mysqli_query($conn, "SELECT typeID FROM lib_acc 
  WHERE librarianID = '$id'");
  $row = mysqli_fetch_assoc($result);
  $type = $row['typeID'];
  if($type == "3"){
    header("location: adminprofile.php");
  }
}


date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();

if(isset($_POST["reset"])){
  $librarianID = $_POST["librarianID"];
  $password = $_POST["newpass"];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $insquery = "UPDATE lib_acc SET password = '$hashed_password' WHERE librarianID = '$librarianID'";

  if(mysqli_query($conn, $insquery)){
     echo "<script>alert('Reset Password Successful.');</script>";
  }
  else{
      echo "<script>alert('Reset Password Unsuccessful.');</script>";
  }
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Librarian Accounts</title>
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
                    <a href="./librarianprofiles-admin.php" class="nav-link active">
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
                      <a href="./patronattendance-admin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Patron Attendance</p>
                      </a>
                    </li>
                  <li class="nav-item">
                    <a href="createaccount.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add an Account</p>
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
                        <a href="patronborrow-print.php" target="_blank" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Total Borrows of Patron</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="courseborrow-print.php" target="_blank" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Total Borrows Per Course</p>
                        </a>
                      </li>
                      <li class="nav-item">
                      <a href="bookborrow-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Borrows Per Book</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="patronvisit-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Visits of Patron</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="coursevisit-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Visits Per Course</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="totalborrow-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Book Request Approval Of Librarian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="totalreturn-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Book Return Approval Of Librarian</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="totalavailablebooks-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Available Books</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="totalarchivedbooks-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Archived Books</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="patronpenaltytotal-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Summary Of Penalty Per Patron</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="penaltytotal-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Summary Of Penalties</p>
                      </a>
                    </li>
                    </li>
                  </ul>
                </li>
                  </li>
                </ul>
              </li>';}
            else if($type == "2"){
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
                      <a href="patronborrow-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Borrows of Patron</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="courseborrow-print.php" target="_blank" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Borrows Per Course</p>
                      </a>
                    </li>
                    <li class="nav-item">
                    <a href="bookborrow-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Borrows Per Book</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="patronvisit-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Visits of Patron</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="coursevisit-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Visits Per Course</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="totalborrow-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Book Request Approval Of Librarian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="totalreturn-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Book Return Approval Of Librarian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="totalavailablebooks-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Available Books</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="totalarchivedbooks-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Total Archived Books</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="patronpenaltytotal-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Of Penalty Per Patron</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="penaltytotal-print.php" target="_blank" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Of Penalties</p>
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
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class = "container py-4 px-4">
    <div class ="row">
    <h3 class="mb-4 mt-3 text-uppercase">Librarian Accounts</h3>
    <table id="example" class="content-table" style="width:100%">
    <thead>
        <tr>
            <th class='px-4 py-2 text-center'>ID</th>
            <th class='px-4 py-2 text-center'>Name</th>
            <th class='px-4 py-2 text-center'>Email</th>
            <th class='px-4 py-2 text-center'>Account Type</th>
            <th class='px-4 py-2 text-center'>Status</th>
            <?php
              if($type == 1){
                echo"<th class='px-4 py-2 text-center'>Password</th>";
              }
            ?>
        </tr>
        </thead>
        <tbody>
            <?php  
            $accID = $_SESSION["accountID"];
            $result = mysqli_query($conn, "SELECT typeID
            FROM lib_acc
            WHERE librarianID = '$accID'");
            $row = mysqli_fetch_assoc($result);

            if($row['typeID'] == 2){
                $result = mysqli_query($conn, "SELECT librarianID, name, email, nametype, status
                FROM lib_acc acc
                INNER JOIN account_type acct ON acc.typeID = acct.type_ID;");
                while($row = mysqli_fetch_assoc($result)){
                    if($row['nametype'] != "Admin" && $row['status'] == 1 && $row['nametype'] != "Head Librarian"){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else if ($row['nametype'] != "Admin" && $row['status'] == 2 && $row['nametype'] != "Head Librarian"){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                    else if($row['nametype'] != "Admin" && $row['status'] == 1 && $row['nametype'] != "Head Librarian"){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else if($row['nametype'] != "Admin" && $row['status'] == 2 && $row['nametype'] != "Head Librarian"){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                    else if($row['nametype'] != "Admin"){
                        if($row['status'] == 1){
                            echo "<tr>
                                <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                                <td class='px-4 py-2 text-center'>$row[name]</td>
                                <td class='px-4 py-2 text-center'>$row[email]</td>
                                <td class='px-4 py-2 text-center'>$row[nametype]</td>
                                <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                            </tr>";
                        }
                        else{
                            echo "<tr>
                                <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                                <td class='px-4 py-2 text-center'>$row[name]</td>
                                <td class='px-4 py-2 text-center'>$row[email]</td>
                                <td class='px-4 py-2 text-center'>$row[nametype]</td>
                                <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-danger'>Disabled</button></td>
                            </tr>";
                        }
                    }
                }
            }     
            else if($row['typeID'] == 1){
                $result = mysqli_query($conn, "SELECT librarianID, name, email, nametype, status
                FROM lib_acc acc
                INNER JOIN account_type acct ON acc.typeID = acct.type_ID;");
                while($row = mysqli_fetch_assoc($result)){
                    if($row['status'] == 1  && $row['librarianID'] == $accID){
                        if($row['status'] == 1){
                            echo "<tr>
                                <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                                <td class='px-4 py-2 text-center'>$row[name]</td>
                                <td class='px-4 py-2 text-center'>$row[email]</td>
                                <td class='px-4 py-2 text-center'>$row[nametype]</td>
                                <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                                <td class='text-center'><button class='select btn btn-dark  type='button' data-bs-toggle='modal' data-bs-target='#exampleModal$row[librarianID]'><i class='fa fa-unlock-alt' aria-hidden='true'></i></button></td>
                            </tr>";
                        }
                        else{
                            echo "<tr>
                                <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                                <td class='px-4 py-2 text-center'>$row[name]</td>
                                <td class='px-4 py-2 text-center'>$row[email]</td>
                                <td class='px-4 py-2 text-center'>$row[nametype]</td>
                                <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-danger'>Disabled</button></td>
                                <td class='text-center'><button class='select btn btn-dark  type='button' data-bs-toggle='modal' data-bs-target='#exampleModal$row[librarianID]'><i class='fa fa-unlock-alt' aria-hidden='true'></i></button></td>
                            </tr>";
                        }
                    }
                    else if($row['status'] == 1){
                      if($row['librarianID'] == 4){
                        echo "<tr>
                              <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                              <td class='px-4 py-2 text-center'>$row[name]</td>
                              <td class='px-4 py-2 text-center'>$row[email]</td>
                              <td class='px-4 py-2 text-center'>$row[nametype]</td>
                              <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                              <td class='text-center'><button class='select btn btn-dark  type='button' data-bs-toggle='modal' data-bs-target='#exampleModal$row[librarianID]'><i class='fa fa-unlock-alt' aria-hidden='true'></i></button></td>
                          </tr>";
                      }
                        else{
                          echo "<tr>
                              <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                              <td class='px-4 py-2 text-center'>$row[name]</td>
                              <td class='px-4 py-2 text-center'>$row[email]</td>
                              <td class='px-4 py-2 text-center'><button id='typeButton$row[librarianID]' onmouseover='typehover($row[librarianID])' onmouseout='typehoverOut($row[librarianID])' onclick='changetype($row[librarianID])' class='select btn btn-warning'>$row[nametype]</td>
                              <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-success'>Enabled</button></td>
                              <td class='text-center'><button class='select btn btn-dark  type='button' data-bs-toggle='modal' data-bs-target='#exampleModal$row[librarianID]'><i class='fa fa-unlock-alt' aria-hidden='true'></i></button></td>
                          </tr>";
                        }
                    }
                    else{
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'><button id='typeButton$row[librarianID]' onmouseover='typehover($row[librarianID])' onmouseout='typehoverOut($row[librarianID])' onclick='changetype($row[librarianID])' class='select btn btn-warning'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-danger'>Disabled</button></td>
                            <td class='text-center'><button class='select btn btn-dark  type='button' data-bs-toggle='modal' data-bs-target='#exampleModal$row[librarianID]'><i class='fa fa-unlock-alt' aria-hidden='true'></i></button></td>
                        </tr>";
                    }
                  
                  echo"
                  <div class='modal fade' id='exampleModal$row[librarianID]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-dialog-centered'>
                          <div class='modal-content'>
                          <div class='modal-header'>
                              <h1 class='modal-title fs-5 text-uppercase mb-0' id='exampleModalLabel'>Reset Password - Staff</h1>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                          </div>
                          <div class='modal-body'>

                              <h3 class='text-uppercase mb-0'>$row[name]</h3>
                              <form id='reset$row[librarianID]' method='post' action=''  autocomplete='off'>
                                  <input type='hidden' name='librarianID' value='$row[librarianID]'>
                                  <div class='mb-4 mt-3'>
                                      <label for='newpass' class='form-label'>New Password:</label>
                                      <input type='text' class='form-control' id='newpass' name='newpass' value='adamson1932' required>
                                  </div>
                              </form>

                          </div>
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                              <button type='submit' form='reset$row[librarianID]' class='btn btn-primary' id='reset' name='reset'>Change Password</button>
                          </div>
                          </div>
                              
                      </div>
                  </div>";
                }
            }     
            else{
                $result = mysqli_query($conn, "SELECT librarianID, name, email, nametype, status
                FROM lib_acc acc
                INNER JOIN account_type acct ON acc.typeID = acct.type_ID;");
                
                while($row = mysqli_fetch_assoc($result)){
                    if($row['status'] == 1){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else{
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                }
              }

            ?>
        </tbody>
      </table>
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
    <!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<?php 

require 'config.php';

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
}

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();

if(isset($_POST["ret"])){
$borrowID = $_POST["borrowID"];

$bdateres = mysqli_query($conn, "SELECT borrow_date FROM borrowed_book WHERE borrowID = $borrowID");
while($rowbdate = mysqli_fetch_assoc($bdateres)){
    $borrowdate = new DateTime($rowbdate["borrow_date"]);

    $interval = $borrowdate->diff($currentDate);

    $months = $interval->y * 12 + $interval->m;
    // Access the difference in days, hours, minutes, and seconds
    $days = $interval->d;

    $totaldays = ($months * 30) + $days;
    $totalpenalty = $totaldays * 10;
    
    
    $insquery = "INSERT INTO returned_book (bookID, borrowerID, librarianID, borrow_date, return_date, penalty_paid)
    SELECT bookID, borrowerID, $id, borrow_date, '$currentDateTime', '$totalpenalty'
    FROM borrowed_book
    WHERE borrowID = $borrowID";
    if(mysqli_query($conn, $insquery)){
        $delquery = "DELETE FROM borrowed_book WHERE borrowID = $borrowID";
        if(mysqli_query($conn, $delquery)){
        }
        else{
            echo"<script>alert('DELETING ERROR');</script>";
        }
    }

    //echo"<script>alert('Total Penalty: ₱$totalpenalty.00');</script>";
}
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  <link rel="stylesheet" href="../CSS/index.css">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 

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
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/scribeLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><h6>Library Management</h6></span>
      <h6>System</h6>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/adminIcon.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
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
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Librarian
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
                <a href="./librarianattendance-admin.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Librarian Attendance</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Patron
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
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
                    if($row['nametype'] != "Admin" && $row['status'] == 1 && $row['librarianID'] != $accID){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else if ($row['nametype'] != "Admin" && $row['status'] == 2 && $row['librarianID'] != $accID){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                    else if($row['nametype'] == "Admin" && $row['status'] == 1 && $row['librarianID'] != $accID){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else if($row['nametype'] == "Admin" && $row['status'] == 2 && $row['librarianID'] != $accID){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
                    else{
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
                    else if($row['status'] == 1){
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'><button id='typeButton$row[librarianID]' onmouseover='typehover($row[librarianID])' onmouseout='typehoverOut($row[librarianID])' onclick='changetype($row[librarianID])' class='select btn btn-warning'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-success'>Enabled</button></td>
                        </tr>";
                    }
                    else{
                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[librarianID]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[email]</td>
                            <td class='px-4 py-2 text-center'><button id='typeButton$row[librarianID]' onmouseover='typehover($row[librarianID])' onmouseout='typehoverOut($row[librarianID])' onclick='changetype($row[librarianID])' class='select btn btn-warning'>$row[nametype]</td>
                            <td class='px-4 py-2 text-center'><button id='statusButton$row[librarianID]' onmouseover='hover($row[librarianID])' onmouseout='hoverOut($row[librarianID])' onclick='changeStatus($row[librarianID])' class='select btn btn-danger'>Disabled</button></td>
                        </tr>";
                    }
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


</body>
</html>

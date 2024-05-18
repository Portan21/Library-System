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

if(isset($_POST["upd"])){
    $cost = $_POST["cost"];

    date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
    $currentDateTime = date('Y-m-d H:i:s');
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upd"])) {
        $cost = mysqli_real_escape_string($conn, $_POST["cost"]);
    
        $insertquery = "INSERT INTO penalty_cost (cost, date, librarianID) VALUES ('$cost', NOW(), '$id')";
    
        if (mysqli_query($conn, $insertquery)) {
            echo "<script>alert('Penalty cost updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating penalty cost: " . mysqli_error($conn) . "');</script>";
        }
    }
}

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Penalty Cost</title>
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
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Return Form
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          
         
       
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
        
    <div class="container pt-5">

        <div class="row pt-3"></div>

        <div class="row mb-2">
            <div class="col">
                <h1 class="mt-2 mb-3 text-uppercase">Penalty cost</h1>
            </div>
        </div>

            <form action="" method="post" autocomplete="off">
        <div class="row">
            <div class="col-md-5 mb-3 pb-3 left-section">
                <h3 class="text-uppercase text-center">Current Penalty Cost Per Day</h3>
                <?php 
                    $currentcost = "SELECT cost 
                    FROM penalty_cost 
                    ORDER BY penaltyID DESC
                    LIMIT 1";

                    $costresult = mysqli_query($conn, $currentcost);

                    if ($costresult && mysqli_num_rows($costresult) > 0) {
                        $currow = mysqli_fetch_assoc($costresult);
                        $latestCost = $currow['cost'];
                    }

                    echo"<h2 class='text-center text-bold'>₱$latestCost</h2>";
                ?>

                <div class="col-md-5 pt-3">
                    <label for="title">Update Penalty Cost Per Day (₱)</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" class="form-control mb-2 mt-1" value="" name="cost" placeholder="00.00" min="0" step="0.01" required>
                    </div>
                    <div class="mt-2">
                        <button type='submit' class='btn btn-success py-2' onclick='return confirmReturn()' id='upd' name='upd'><b>UPDATE</b></button>
                    </div>
                </div>
            </div>
            </form>

                <div class="col-md-7 mb-5 right-section">
                    <h3 class="text-uppercase text-center">Cost History</h3>
                    <div class="row">
                        <div>
                            <?php
                            $result = mysqli_query($conn, "SELECT name, cost, date FROM penalty_cost pc
                            JOIN lib_acc la ON pc.librarianID = la.librarianID
                            ORDER BY penaltyID DESC
                            LIMIT 20;");

                            if (mysqli_num_rows($result) > 0) {
                                // Display the table if there are borrow records
                                echo '<table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Update Date</th>
                                                <th>Patron Name</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                            <td>' . $row['date'] . '</td>
                                            <td>' . $row['name'] . '</td>
                                            <td>' . $row['cost'] . '</td>
                                        </tr>';
                                }

                                echo '</tbody></table>';
                            } else {
                                // Display a message if there are no borrow records
                                echo '<p>No records available.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </div>

    </div>


    </section>
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

<script>
    function confirmReturn() {
        return confirm('Press "OK" to confirm penalty cost update. Press "Cancel" otherwise.');
    }
    </script>
<script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/accountStatus - librarian.js"></script>
    <script src = "../JavaScript/changetype.js"></script>
    <script src = "../JavaScript/app2.js"></script>
    <script src="dist/js/adminlte.js"></script>

</body>
</html>

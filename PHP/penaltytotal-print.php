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

if(empty($_SESSION["typeID"])){
  header("Location: login.php");
}


date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  <link rel="stylesheet" href="../CSS/print.css">
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

    <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class = "container py-4 px-4">
    <div class ="row">
    <div class="col-8">
    <h3 class="mb-4 mt-3 text-uppercase">Total Summary of Penalties<button class="select btn btn-primary" onClick="window.print()"><a class="nav-link" href="#">Print</a></button></h3>
    </div>
    <div class="col-4">
        <?php
            if (isset($_POST['filter-type'])) {
                $filterType = $_POST['filter-type'];
                $query = "SELECT course, count(bookID) AS total
                FROM patron_acc as pa
                INNER JOIN borrowed_book as bb
                ON pa.patronID = bb.patronID";
    
                if ($filterType == 'none') {
                    echo"$currentDateTime";
                } elseif ($filterType == 'week') {
                    echo"$currentDateTime (WEEK)";
                } elseif ($filterType == 'month') {
                    echo"$currentDateTime (MONTH)";
                } elseif ($filterType == 'custom') {
                    echo"$currentDateTime (CUSTOM)";
                }
            }
        ?>
    </div>
    <form method="POST" action="penaltytotal-print.php" class="form">
        <label for="filter-type">Filter by:</label>
        <select name="filter-type" id="filter-type" required>
            <option value="none" selected>None</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="custom">Custom Range</option>
        </select>

        <div id="custom-range" style="display: none;">
            <label for="start-date">Start Date:</label>
            <input type="date" name="start-date" id="start-date">
            
            <label for="end-date">End Date:</label>
            <input type="date" name="end-date" id="end-date">
        </div>

        <button type="submit">Filter</button>
    </form>
    <?php

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the filter-type field is set
        if (isset($_POST['filter-type'])) {
            $filterType = $_POST['filter-type'];
            $query = "SELECT sum(penalty_paid) as total FROM returned_book";

            if ($filterType == 'none') {
                $query .= "";
            } elseif ($filterType == 'week') {
                $query .= " WHERE YEARWEEK(return_date, 1) = YEARWEEK(CURDATE(), 1)";
            } elseif ($filterType == 'month') {
                $query .= " WHERE YEAR(return_date) = YEAR(CURDATE()) AND MONTH(return_date) = MONTH(CURDATE())";
            } elseif ($filterType == 'custom') {
                if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
                    $startDate = $_POST['start-date'];
                    $endDate = $_POST['end-date'];
                    if ($startDate && $endDate) {
                        $query .= " WHERE return_date BETWEEN '$startDate' AND '$endDate'";
                    } else {
                        echo "Please provide both start and end dates.";
                        exit;
                    }
                } else {
                    echo "Please provide both start and end dates.";
                    exit;
                }
            }

            // Execute the query and display the results
            $query .= "";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<table id='example' class='content-table' style='width:100%'>
                      <thead>
                          <tr>
                          <th class='px-4 py-2 text-center'></th>
                          <th class='px-4 py-2 text-center'>Total Penalty</th>
                      </tr>
                      </thead>
                      <tbody>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td class='px-4 py-2 text-center'>Total</td>
                            <td class='px-4 py-2 text-center'>$row[total]</td>
                        </tr>";
                }
                echo "</tbody> </table>";
            } else {
                echo "No results found.";
            }
        } else {
            echo "Filter type is not set.";
        }
    } else {
        $query = "SELECT sum(penalty_paid) as total FROM returned_book";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table id='example' class='content-table' style='width:100%'>
                      <thead>
                          <tr>
                          <th class='px-4 py-2 text-center'></th>
                          <th class='px-4 py-2 text-center'>Total</th>
                      </tr>
                      </thead>
                      <tbody>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td class='px-4 py-2 text-center'>Total Penalty</td>
                            <td class='px-4 py-2 text-center'>$row[total]</td>
                        </tr>";
                }
          }
    }
    ?>
    </div>



<script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/accountStatus - librarian.js"></script>
    <script src = "../JavaScript/changetype.js"></script>
    <script src = "../JavaScript/app3.js"></script>
    <!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<script>
        const filterTypeSelect = document.getElementById('filter-type');
        const customRangeDiv = document.getElementById('custom-range');

        filterTypeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customRangeDiv.style.display = 'block';
            } else {
                customRangeDiv.style.display = 'none';
            }
        });
    </script>


</body>
</html>

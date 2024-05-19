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
    <h3 class="mb-4 mt-3 text-uppercase">Total Archived Books<button class="select btn btn-primary" onClick="window.print()"><a class="nav-link" href="#">Print</a></button></h3>
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
    <?php

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the filter-type field is set
        if (isset($_POST['filter-type'])) {
            $filterType = $_POST['filter-type'];
            $query = "SELECT count(bookID) AS count
            FROM book";

            if ($filterType == 'none') {
                $query .= "";
            } elseif ($filterType == 'week') {
                $query .= "";
            } elseif ($filterType == 'month') {
                $query .= "";
            } elseif ($filterType == 'custom') {
                if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
                    $startDate = $_POST['start-date'];
                    $endDate = $_POST['end-date'];
                    if ($startDate && $endDate) {
                        $query .= "";
                    } else {
                        echo "";
                        exit;
                    }
                } else {
                    echo "";
                    exit;
                }
            }

            // Execute the query and display the results
            $query .= " WHERE availability != 1";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<table id='example' class='content-table' style='width:100%'>
                      <thead>
                          <tr>
                          <th class='px-4 py-2 text-center'>Penalty Count</th>
                          <th class='px-4 py-2 text-center'>Patron Name</th>
                          <th class='px-4 py-2 text-center'>Total Penalty</th>
                      </tr>
                      </thead>
                      <tbody>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[count]</td>
                            <td class='px-4 py-2 text-center'>$row[name]</td>
                            <td class='px-4 py-2 text-center'>$row[penalty]</td>
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
        $query = "SELECT count(bookID) AS count
        FROM book";
        $query .= " WHERE availability != 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table id='example' class='content-table' style='width:100%'>
                      <thead>
                          <tr>
                          <th class='px-4 py-2 text-center'></th>
                          <th class='px-4 py-2 text-center'>Archived Books</th>
                      </tr>
                      </thead>
                      <tbody>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td class='px-4 py-2 text-center'>Total</td>
                            <td class='px-4 py-2 text-center'>$row[count]</td>
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

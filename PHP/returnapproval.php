<!DOCTYPE html>
<html lang="en">
<?php 

require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
require 'PHPMailer\src\Exception.php';

if(empty($_SESSION["accountID"])){
  header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
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

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();


if(isset($_POST["ret"])){
  $mail = new PHPMailer(true);
  $borrowID = $_POST["borrowID"];

  $bdateres = mysqli_query($conn, "SELECT borrow_date FROM borrowed_book WHERE borrowID = $borrowID");
  while($rowbdate = mysqli_fetch_assoc($bdateres)){
      $borrowdate = new DateTime($rowbdate["borrow_date"]);
      
      $emailquery = "SELECT email, book_name, receipt_number FROM return_form rf
      INNER JOIN borrowed_book bb
      ON rf.borrowID = bb.borrowID
      INNER JOIN patron_acc pa
      ON pa.patronID = bb.patronID
      INNER JOIN book b
      ON bb.bookID = b.bookID
      WHERE rf.borrowID = $borrowID";

      if(mysqli_query($conn, $emailquery)){
        $emailresult = mysqli_query($conn, $emailquery);
        $emailrow = mysqli_fetch_assoc($emailresult);
        $email = trim($emailrow['email']);
        $book = $emailrow['book_name'];
        $receipt = $emailrow['receipt_number'];

        $message = "Your request to return the book <b>'$book'</b> has been approved.";

        //dtldbwzroixdlthq
        try {
          //Server settings
          $mail->isSMTP();                                            //Send using SMTP
          $mail->SMTPAuth   = true;
          $mail->SMTPSecure = 'ssl';
          $mail->Host       = 'smtp.gmail.com';
          $mail->Port       = 465;
          $mail->Username   = 'adamson.scribe@gmail.com';                     //SMTP username
          $mail->Password   = 'qfwzlywxozzclfun';                               //SMTP password

          //Recipients
          $mail->setFrom('adamson.scribe@gmail.com', 'Adamson SCRIBE');
          $mail->addAddress($email);     //Add a recipient


          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Book Return Successful | SCRIBE';
          $mail->Body    = $message;


          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();

          $insquery = "INSERT INTO returned_book (bookID, patronID, librarianID, borrow_date, return_date, penalty_paid)
          SELECT bookID, patronID, $id, borrow_date, '$currentDateTime', '0.00'
          FROM borrowed_book
          WHERE borrowID = $borrowID";

          if(mysqli_query($conn, $insquery)){
            // Insert was successful, now update the book availability
            $updatequery = "UPDATE book SET availability = '1' WHERE bookID IN (SELECT bookID FROM borrowed_book WHERE borrowID = $borrowID)";
            
            if (mysqli_query($conn, $updatequery)) {
                $delretquery = "DELETE FROM return_form WHERE borrowID = $borrowID";
                $delquery = "DELETE FROM borrowed_book WHERE borrowID = $borrowID";
                if(mysqli_query($conn, $delretquery)){
                    if(mysqli_query($conn, $delquery)){
                        echo "<script>alert('Approval Successful');</script>";
                    }
                    else{
                        echo "<script>alert('Deleting error');</script>";
                    }
                }
                else{
                    echo "<script>alert('Deleting error');</script>";
                }
            } else {
                echo "<script>alert('Update error');</script>";
            }
            
      }
        } catch (Exception $e) {
          echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
        }
        }
      }
    }

if(isset($_POST["retpen"])){
    $mail = new PHPMailer(true);
    $borrowID = $_POST["borrowID"];
    $receiptnum = $_POST["receipt"];
    $penaltycost = $_POST["cost"];
    // Remove commas from the penalty cost
    $penaltycost = str_replace(',', '', $penaltycost);

    $bdateres = mysqli_query($conn, "SELECT borrow_date FROM borrowed_book WHERE borrowID = $borrowID");
    while($rowbdate = mysqli_fetch_assoc($bdateres)){


      $emailquery = "SELECT email, book_name, receipt_number FROM return_form rf
      INNER JOIN borrowed_book bb
      ON rf.borrowID = bb.borrowID
      INNER JOIN patron_acc pa
      ON pa.patronID = bb.patronID
      INNER JOIN book b
      ON bb.bookID = b.bookID
      WHERE rf.borrowID = $borrowID";

      if(mysqli_query($conn, $emailquery)){
        $emailresult = mysqli_query($conn, $emailquery);
        $emailrow = mysqli_fetch_assoc($emailresult);
        $email = trim($emailrow['email']);
        $book = $emailrow['book_name'];
        $receipt = $emailrow['receipt_number'];

        $message = "Your request to return the book <b>'$book'</b> with receipt number: <b>'$receipt'</b> has been approved.";

        //dtldbwzroixdlthq
        try {
          //Server settings
          $mail->isSMTP();                                            //Send using SMTP
          $mail->SMTPAuth   = true;
          $mail->SMTPSecure = 'ssl';
          $mail->Host       = 'smtp.gmail.com';
          $mail->Port       = 465;
          $mail->Username   = 'adamson.scribe@gmail.com';                     //SMTP username
          $mail->Password   = 'qfwzlywxozzclfun';                               //SMTP password

          //Recipients
          $mail->setFrom('adamson.scribe@gmail.com', 'Adamson SCRIBE');
          $mail->addAddress($email);     //Add a recipient


          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Book Return Successful | SCRIBE';
          $mail->Body    = $message;


          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();

          $borrowdate = new DateTime($rowbdate["borrow_date"]);

          $insquery = "INSERT INTO returned_book (bookID, patronID, librarianID, borrow_date, return_date, penalty_paid, receipt_number)
          SELECT bookID, patronID, $id, borrow_date, '$currentDateTime', '$penaltycost', '$receiptnum'
          FROM borrowed_book
          WHERE borrowID = $borrowID";

          if(mysqli_query($conn, $insquery)){
            // Insert was successful, now update the book availability
            $updatequery = "UPDATE book SET availability = '1' WHERE bookID IN (SELECT bookID FROM borrowed_book WHERE borrowID = $borrowID)";
            
            if (mysqli_query($conn, $updatequery)) {
                $delretquery = "DELETE FROM return_form WHERE borrowID = $borrowID";
                $delquery = "DELETE FROM borrowed_book WHERE borrowID = $borrowID";
                if(mysqli_query($conn, $delretquery)){
                    if(mysqli_query($conn, $delquery)){
                        echo "<script>alert('Approval Successful');</script>";
                    }
                    else{
                        echo "<script>alert('Deleting error');</script>";
                    }
                }
                else{
                    echo "<script>alert('Deleting error');</script>";
                }
            } 
            else {
                echo "<script>alert('Update error');</script>";
            }
          }
            
        }
        catch (Exception $e) {
        echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
        } 
      }
      }
    }




if(isset($_POST["rej"])){
    $mail = new PHPMailer(true);
    $borrowID = $_POST["borrowID"];

    $emailquery = "SELECT email, book_name, receipt_number FROM return_form rf
    INNER JOIN borrowed_book bb
    ON rf.borrowID = bb.borrowID
    INNER JOIN patron_acc pa
    ON pa.patronID = bb.patronID
    INNER JOIN book b
    ON bb.bookID = b.bookID
    WHERE rf.borrowID = $borrowID";

    if(mysqli_query($conn, $emailquery)){
      $emailresult = mysqli_query($conn, $emailquery);
      $emailrow = mysqli_fetch_assoc($emailresult);
      $email = trim($emailrow['email']);
      $book = $emailrow['book_name'];
      $receipt = $emailrow['receipt_number'];

      $message = "Your request to return the book <b>'$book'</b> has been rejected.";

      try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 465;
        $mail->Username   = 'adamson.scribe@gmail.com';                     //SMTP username
        $mail->Password   = 'qfwzlywxozzclfun';                               //SMTP password

        //Recipients
        $mail->setFrom('adamson.scribe@gmail.com', 'Adamson SCRIBE');
        $mail->addAddress($email);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Book Return Rejected | SCRIBE';
        $mail->Body    = $message;


        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        // Prepare and execute the DELETE query
        $deleteQuery = "DELETE FROM return_form WHERE borrowID = $borrowID";

        if(mysqli_query($conn, $deleteQuery)){
            // Success message if the row is deleted
            echo "<script>alert('Return Request Rejected Successfully');</script>";
        } else {
            // Error message if deletion fails
            echo "<script>alert('Failed to delete return record');</script>";
        }
      }
      catch (Exception $e) {
        echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
      } 
    }
}

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDate = new DateTime();
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Return Request</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-H0WW0R2IM6V/Td7Zhi5il5Pa7xUkkBkoM2Uq21IxC1JBpSBnG3+g+JwNu9U5+vpf" crossorigin="anonymous">

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
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
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
                    <a href="returnapproval.php" class="nav-link active">
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
        <div class="row pt-4">
        <div class = "container py-4">
        <table id="example" class="table table-borderless" style="width:100%">
            <thead>
            <tr>
                <th class='text-uppercase'><h3>RETURN APPROVAL</h3></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT a.patronID, bb.borrowID, a.pt_name AS bf_name, ac.name AS lf_name, book_name, bb.borrow_date AS borrow_date, deadline, receipt_number FROM borrowed_book bb
            INNER JOIN book b on bb.bookID = b.bookID
            INNER JOIN patron_acc a on bb.patronID = a.patronID
            INNER JOIN lib_acc ac on bb.librarianID = ac.librarianID
            INNER JOIN return_form rf ON bb.borrowID = rf.borrowID;");
            while($row = mysqli_fetch_assoc($result)){
                
                $currentcost = "SELECT cost 
                FROM penalty_cost 
                ORDER BY penaltyID DESC 
                LIMIT 1";

                $costresult = mysqli_query($conn, $currentcost);

                if ($costresult && mysqli_num_rows($costresult) > 0) {
                    $currow = mysqli_fetch_assoc($costresult);
                    $latestCost = $currow['cost'];
                }

                // Assuming $row is fetched somewhere in the previous loop/iteration
                $brwdate = new DateTime($row["borrow_date"]);
                $currentDate = new DateTime(); 

                $intrvl = $brwdate->diff($currentDate);
                $mnt = $intrvl->y * 12 + $intrvl->m;
                $dys = $intrvl->d;

                $totday = ($mnt * 30) + $dys;
                $totpen = $totday * $latestCost;

                // Format the total penalty to two decimal places
                $totpenFormatted = number_format($totpen, 2);

                if(empty($row['receipt_number'])){
                    echo 
                    "<tr>
                        <td class='px-4 py-2'>
                            <div class='container'>
                                <div class='row border border-secondary rounded mt-1 mb-1'>
                                    <div class='col-3 text-break mt-1 mb-1 '>
                                            <h3 class='text-uppercase mb-0'>$row[bf_name]</h3>
                                    </div>
                                    
                                    <div class='col-7 text-break mt-1 mb-1'>
                                            <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                    </div>
    
                                    <div class='col-2 d-flex justify-content-end align-items-center'>
                                        <div class='mr-2'>
                                            <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>
                                            <button type='submit' class='btn btn-danger py-2' onclick='return rejectReturn()' id='rej' name='rej'><i class='fas fa-trash'></i></button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>
                                            <button type='submit' class='btn btn-primary py-2' onclick='return confirmReturn()' id='ret' name='ret'><i class='fas fa-check'></i></button>
                                            </form>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </td>
                    </tr>";
                }
                else{
                    echo 
                    "<tr>
                        <td class='px-4 py-2'>
                            <div class='container'>
                                <div class='row border border-secondary rounded mt-1 mb-1'>
                                    <div class='col-3 text-break mt-1 mb-1 '>
                                            <h3 class='text-uppercase mb-0'>$row[bf_name]</h3>
                                    </div>
                                    
                                    <div class='col-7 text-break mt-1 mb-1'>
                                            <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                            <h5 class='mb-0'> Receipt Number: $row[receipt_number]</h5>
                                            <h5 class='mt-2 text-danger'> Amount To Paid: $totpenFormatted</h5>
                                    </div>
    
                                    <div class='col-2 d-flex justify-content-end align-items-center'>
                                        <div class='mr-2'>
                                            <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>
                                            <button type='submit' class='btn btn-danger py-2' onclick='return rejectReturn()' id='rej' name='rej'><i class='fas fa-trash'></i></button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='receipt' name='receipt' value='$row[receipt_number]'>
                                            <input type='hidden' id='cost' name='cost' value='$totpenFormatted'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>
                                                <button type='submit' class='btn btn-danger py-2' onclick='return confirmReturn()' id='retpen' name='retpen'><i class='fas fa-check'></i></button>
                                            </form>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </td>
                    </tr>";
                }

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
<script>
    function confirmReturn() {
        return confirm('Press "OK" to confirm the book return. Press "Cancel" otherwise.');
    }
    
    function rejectReturn() {
        return confirm('Press "OK" to reject the book return. Press "Cancel" otherwise.');
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

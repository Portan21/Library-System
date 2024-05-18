<!DOCTYPE html>
<html lang="en">
<?php 

require 'config.php';

if(empty($_SESSION["accountID"])){
    header("Location: login.php");
  }
  
  if(empty($_SESSION["bookTitle"])){
      header("Location: catalogs.php");
  }
  else{
      $title = $_SESSION["bookTitle"];
      $id = $_SESSION["accountID"];
  }
  
  if(empty($_SESSION["typeID"])){
    header("Location: bookdetail.php");
  }
  
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      if (isset($_POST["submit"])) {
          // Get the values from the form
          $bookIdentity = mysqli_real_escape_string($conn, $_POST["bookID"]);
          $descriptionValue = mysqli_real_escape_string($conn, $_POST["description"]);
          $titlevalue = mysqli_real_escape_string($conn, $_POST["title"]);
          $authorvalue = mysqli_real_escape_string($conn, $_POST["author"]);
          $genresvalue = mysqli_real_escape_string($conn, $_POST["genres"]);
          $ratingvalue = mysqli_real_escape_string($conn, $_POST["rating"]);
          $availabilityvalue = mysqli_real_escape_string($conn, $_POST["availability"]);
  
          // Update the information in the database
            $updatequery = "UPDATE book SET 
            book_name = '$titlevalue',
            author = '$authorvalue',
            genres = '$genresvalue',
            rating = '$ratingvalue',
            availability = '$availabilityvalue',
            description = '$descriptionValue'
            WHERE bookID = '$bookIdentity'";

            if (mysqli_query($conn, $updatequery)) {

            date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
            $currentDateTime = date('Y-m-d H:i:s');

            $insertquery = "INSERT INTO edited_by (bookID, librarianID, edit_time) VALUES ('$bookIdentity', '$id', '$currentDateTime')";

            if (mysqli_query($conn, $insertquery)) {
                // Set a success message
                $_SESSION["editSuccessMessage"] = "Edit Successful";
                
                // Redirect to the same page to reflect the changes
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script> alert('Book Editing Not Successful'); </script>";
            }
            } else {
            // Handle the case where the update fails
            echo "Error updating record: " . mysqli_error($conn);
            }
      }
  }

?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Edit</title>
    <style>
        .table-borderless td,
        .table-borderless th {
            border: 0;
        }
        .alert {
        transition: opacity 1s ease-out;
        }
    </style>
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
                Catalog
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
                <a href="newcatalog.php" class="mt-2 text-decoration-none text-uppercase">< BACK TO LIBRARY CATALOG</a>
                
                <h1 class="mt-1 text-uppercase">EDIT BOOK DETAIL</h1>
            </div>
        </div>
            <form action="" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <?php
                        $result = mysqli_query($conn, "SELECT bookID, genres, book_name, author, description, rating, availability FROM book WHERE bookID = '$title'");
                
                        while($row = mysqli_fetch_assoc($result)){
                            $bookID = $row['bookID'];
                            $bookname = $row['book_name'];
                            $author = $row['author'];
                            $genres = $row['genres'];
                            $rating = $row['rating'];
                            $availability = $row['availability'];
                            $description = $row['description'];
                        }
                        ?>
                        <label for="title">Title</label>
                        <input type="text" class="form-control mb-2 mt-1" value="<?php echo $bookname ?>" name="title" placeholder="Title" required>

                        <label for="author">Author</label>
                        <input type="text" class="form-control mb-2 mt-1" value="<?php echo $author ?>" name="author" placeholder="Author" required>

                        <label for="description">Description</label>
                        <textarea class="form-control mb-2 mt-1" name="description" placeholder="Description" rows="15" cols="50" required><?php echo $description ?></textarea>

                    </div>

                    <div class="col-md-4 mb-5">
                        
                        <a>GENRES</a>
                        <textarea type="text" class="form-control mb-3 mt-1" name="genres" placeholder="Genres" rows="5" cols="50" required><?php echo $genres ?></textarea>

                        <a>RATINGS</a>
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                <input type="number" class="form-control mb-3" value="<?php echo $rating ?>" name="rating" placeholder="Ratings" step="0.01" min="0" max="5" required>
                            </div>
                        </div>

                        <a>AVAILABILITY</a>
                        <div class="row mb-4">
                            <div class="col-md-6 mt-1">
                                <select name="availability" id="sduration" class="form-select" aria-label="Default select example">
                                    <?php
                                    switch ($availability) {
                                        case '1':
                                            echo "
                                                <option value='1'>Available</option>
                                                <option value='4'>Removed</option>
                                            ";
                                            break;
                                        
                                        case '2':
                                            echo "
                                                <option value='2'>Reserved</option>
                                            ";
                                            break;

                                        case '3':
                                            echo "
                                                <option value='3'>Unavailable</option>
                                            ";
                                            break;

                                        case '4':
                                            echo "
                                                <option value='4'>Removed</option>
                                                <option value='1'>Available</option>
                                            ";
                                            break;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <?php
                            
                        $result = mysqli_query($conn, "SELECT name, edit_time FROM edited_by
                        JOIN lib_acc ON edited_by.librarianID = lib_acc.librarianID
                        WHERE edited_by.bookID = $bookID
                        ORDER BY edited_by.edit_time DESC
                        LIMIT 1;
                        ");

                        while($row = mysqli_fetch_assoc($result)){
                            $libname = $row['name'];
                            $editime = $row['edit_time'];
                            echo"
                            <p> Last edited by:<br> $libname ($editime) </p>
                            ";
                        }

                        ?>

                        <input type="hidden" id="bookID" name="bookID" value="<?php echo $bookID ?>">
                        
                        <?php
                        // Check if the success message exists in the session
                        if (isset($_SESSION["editSuccessMessage"])) {
                            // Display the success message
                            echo '<div id="editSuccessMessage" class="alert alert-success" role="alert">' . $_SESSION["editSuccessMessage"] . '</div>';

                            // Unset the session variable to ensure it is displayed only once
                            unset($_SESSION["editSuccessMessage"]);
                        }
                        ?>
                        <script>
                        // Fade out the success message after 1 second
                        setTimeout(function() {
                            var element = document.getElementById("editSuccessMessage");
                            if (element) {
                                element.style.opacity = 0;
                                setTimeout(function() {
                                    element.style.display = "none";
                                }, 1000); // 1 second transition duration
                            }
                        }, 1000); // 1000 milliseconds = 1 second
                        </script>

                        <button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg "><b>EDIT BOOK DETAILS</b></button>
                    </div>
                </div>
            </form>

    </div>
    
    <div class="container pb-5">
    </div>

    </section>
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

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
}


if(!empty($_SESSION["typeID"])){
  header("Location: bookedit.php");
}


//ADD NO LIBRARIAN ALLOWED


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["submit"])) {

      $bookTitle = $title;
      $accountid = $_SESSION["accountID"];
      $duration = $_POST["duration"];
      
        date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
        $currentDateTime = date('Y-m-d H:i:s');
        // Add 2 hours to the current date and time
        $futureDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +2 hours'));


      $result = mysqli_query($conn, "SELECT bookID, availability FROM book WHERE book_name = '$bookTitle'");
      $row = mysqli_fetch_assoc($result);

      $bookid = $row["bookID"];
      $availability = $row["availability"];

      if($availability == 1){
        $reqquery = "INSERT INTO book_request(patronID, bookID, duration, deadline) VALUES('$accountid','$bookid', '$duration', '$futureDateTime')";
        if(mysqli_query($conn,$reqquery)){
          // Update the 'book' table
          $updatequery = "UPDATE book SET availability = '2' WHERE bookID = '$bookid'";
          if (mysqli_query($conn, $updatequery)) {
              // The update was successful
          }
        }
        // For example, you can insert it into a database or perform any other necessary action.
        echo "<script> alert('Book:$bookTitle Borrowing Request Sent. Head to the Library to confirm your request and claim the book.'); </script>"; // You can provide a response if needed.
      }
      else{
        echo "<script> alert('Book:$bookTitle Currently Unavailable. Try borrowing another book.'); </script>";
      }

  } else {
      // Handle the case when 'bookTitle' is not received in the POST request.
      echo "<script> alert('BORROWING FAILED. Try again.'); </script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title> 
    <style>
        .table-borderless td,
        .table-borderless th {
            border: 0;
        }
    </style>
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="landing.php"><img src="../Pictures/logo.png" style="height: 9,5%; width: 9.5%;">SCRIBE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-lg-0 ms-auto">

            <li class="nav-item">
            <a class="nav-link active" href="catalogs.php">Catalog</a>
            </li>
	    <?php
	    if(!empty($_SESSION["typeID"])){
	    echo"
            <li class='nav-item'>
            <a class='nav-link' href='approval.php'>Approval</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='request.php'>Request</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='borrowed.php'>Borrowed</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='penalty.php'>Penalty</a>
            </li>";
	    }

	    ?>

            <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
    </nav>
    <div class="container">
        <div class="row mt-3"></div>

        <div class="row mt-5 mb-4">
            <div class="col">
                <a href="catalogs.php" class="mt-2 text-decoration-none text-uppercase">< BACK TO LIBRARY CATALOG</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-8 mb-3">
                <?php
                    $escapedTitle = mysqli_real_escape_string($conn, $title);
                    $result = mysqli_query($conn, "SELECT bookID, book_name, author, description, availability FROM book WHERE book_name = '$escapedTitle'");
        
                    while($row = mysqli_fetch_assoc($result)){
                        $bookID = $row['bookID'];
                        $author = $row['author'];
                        $description = $row['description'];
                        $avail = $row['availability'];
                    }
                ?>
                <h1 class="text-uppercase"><?php echo $title ?></h1>
                <h4 class="text-uppercase"><?php echo $author ?></h4>
                <p><?php echo $description ?></p>
            
            </div>
            <div class="col-md-4 mb-5">

                <h1 class="mb-4 text-uppercase">BOOK BORROW</h1>
                
                <form action="" method="post" autocomplete="off">
                    <a>TITLE</a>
                    <h4 class="mb-3 text-uppercase"><?php echo $title ?></h4>

                    <a>AUTHOR</a>
                    <h4 class="mb-3 text-uppercase"><?php echo $author ?></h4>

                    <a>DURATION OF BORROWING</a>
                    <div class="row mb-4">
                        <div class="col-md-6 mt-1">
                            <select name="duration" id="sduration" class="form-select" aria-label="Default select example">
                                <option value="7">One Week</option>
                                <option value="14">Two Weeks</option>
                                <option value="21">Three Weeks</option>
                                <option value="28">Four Weeks</option>
                            </select>
                        </div>
                    </div>
                    <?php
                    if($avail == '1'){
                        echo"
                            <button type='submit' name='submit' id='submit' class='btn btn-warning btn-lg mt-2'><b>REQUEST TO BORROW</b></button>
                        ";
                    }
                    else{
                        echo"
                            <button type='submit' name='submit' id='submit' class='btn btn-warning btn-lg mt-2' disabled><b>REQUEST TO BORROW</b></button>
                        ";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container mb-5">
        <div class="row mt-5">
            <h1 class="mt-2 text-decoration-none text-uppercase">Borrow History</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php
                $result = mysqli_query($conn, "SELECT patron_acc.pt_name, borrow_date, return_date
                    FROM returned_book
                    JOIN patron_acc ON returned_book.patronID = patron_acc.patronID
                    WHERE returned_book.bookID = $bookID
                    ORDER BY returned_book.return_date DESC
                    LIMIT 20;");

                if (mysqli_num_rows($result) > 0) {
                    // Display the table if there are borrow records
                    echo '<table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Patron Name</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tbody>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . $row['pt_name'] . '</td>
                                <td>' . $row['borrow_date'] . '</td>
                                <td>' . $row['return_date'] . '</td>
                            </tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    // Display a message if there are no borrow records
                    echo '<p>No borrow records available.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>
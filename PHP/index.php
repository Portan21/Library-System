<?php 
require 'config.php';

if(isset($_POST["login"])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM account WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        if(password_verify($password, $row["password"])){
            $_SESSION["login"] = true;
            $_SESSION["accountID"] = $row["accountID"];
            $_SESSION["idnumber"] = $row["idnumber"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["typeID"] = $row["typeID"];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
</head>
<body>
    <div class = "container py-5">
    <div class ="row">
    <table id="example" class="content-table" tyle="width:100%">
        <thead>
          <tr>
            <th>Book Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Rating</th>
            <th>Availability</th>
          </tr>
        </thead>
        <tbody>
		<?php
        $result = mysqli_query($conn, "SELECT book_name,author,genres,rating,availability,description FROM book ORDER BY bookID ASC");
        while($row = mysqli_fetch_assoc($result)){
          $bookName = htmlspecialchars($row['book_name']);
          $description = htmlspecialchars($row['description']);
          echo "<tr>
              <td class='px-4 py-2 text-center border'><a href='#' class='book-button' data-description='$description'>$bookName</a></td>
              <td class='px-4 py-2 text-center border'>$row[author]</td>
              <td class='px-4 py-2 text-center border'>$row[genres]</td>
              <td class='px-4 py-2 text-center border'>$row[rating]</td>
              <td class='px-4 py-2 text-center border'>$row[availability]</td>
          </tr>";
          
         }
         ?>
        </tbody>
      </table>
    </div>
</div>
	<!-- The modal container -->
<div id="myModal" class="modal2">
  <div class="modal-content2">
    <span class="close" id="closeModal">&times;</span>
    <h2 id="modal-title">Book Title</h2>
    <p id="modal-author">Author</p>
    <p id="modal-genres">Genres</p>
    <p id="modal-rating">Rating</p>
    <p id="modal-availability">Availability</p>
    <p id="modal-description">Description</p>
    <!-- Borrow button with ID for styling -->
    <button id="borrow-button">Borrow</button>

    <!-- Remove button with ID for styling 
    <button id="remove-button">Remove</button>-->

  </div>
</div>
    
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/index.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>
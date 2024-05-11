<?php
require 'config.php';

if(empty($_SESSION["accountID"])){
  header("Location: login.php");
}


if(empty($_SESSION["typeID"])){
  header("Location: bookdetail.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
        // Get the values from the form
        $descriptionValue = mysqli_real_escape_string($conn, $_POST["description"]);
        $titlevalue = mysqli_real_escape_string($conn, $_POST["title"]);
        $authorvalue = mysqli_real_escape_string($conn, $_POST["author"]);
        $genresvalue = mysqli_real_escape_string($conn, $_POST["genres"]);
        $ratingvalue = mysqli_real_escape_string($conn, $_POST["rating"]);

        $insertquery = "INSERT INTO book (book_name, author, genres, rating, availability, description) VALUES 
        ('$titlevalue', '$authorvalue', '$genresvalue', '$ratingvalue', '1', '$descriptionValue')";

            
        if (mysqli_query($conn, $insertquery)) {
            echo "<script> alert('Book Issuing Successful'); </script>";
        } else {
            echo "<script> alert('Book Issuing Not Successful'); </script>";
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
    <title>Issue Book</title> 
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
            <a class='nav-link' href='attendance(librarians)-records.php'>Records</a>
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

        <div class="row mt-4 mb-2">
            <div class="col">
                <a href="landing.php" class="mt-2 text-decoration-none text-uppercase">< BACK TO LANDING PAGE</a>
                
                <h1 class="mt-1 text-uppercase">ISSUE BOOK</h1>
            </div>
        </div>
            <form action="" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control mb-2 mt-1" value="" name="title" placeholder="Title" required>

                        <label for="author">Author</label>
                        <input type="text" class="form-control mb-2 mt-1" value="" name="author" placeholder="Author" required>

                        <label for="description">Description</label>
                        <textarea class="form-control mb-2 mt-1" name="description" placeholder="Description" rows="10" cols="50" required></textarea>

                    </div>

                    <div class="col-md-4 mb-5">
                        
                        <a>GENRES</a>
                        <textarea type="text" class="form-control mb-3 mt-1" name="genres" placeholder="['Genre1', 'Genre2']" rows="5" cols="50" required></textarea>

                        <a>RATINGS</a>
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                <input type="number" class="form-control mb-3" value="" name="rating" placeholder="0.00" step="0.01" min="0" max="5" required>
                            </div>
                        </div>

                        <button type="submit" name="submit" id="submit" class="btn btn-success btn-lg mt-2"><b>ISSUE BOOK</b></button>
                    </div>
                </div>
            </form>

    </div>

    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>
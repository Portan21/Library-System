<?php 
require 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
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
            <a class="nav-link" href="catalogs.php">Catalog</a>
            </li>
	    <?php
	    if(!empty($_SESSION["typeID"])){
	    echo"
            <li class='nav-item'>
            <a class='nav-link' href='request.php'>Request</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='borrowed.php'>Borrowed</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='penalty.php'>Penalty</a>
            </li>
            
            <li class='nav-item'>
            <a class='nav-link' href='librarianprofiles-records.php'>Records</a>
            </li>";
	    }

	    ?>

            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
    </nav>
    <div class = "container py-5">
    <div class ="row">
    <table id="example" class="content-table" style="width:100%">
    <thead>
        <tr>
            <th class='px-4 py-2 text-center'>Date</th>
            <th class='px-4 py-2 text-center'>Deadline</th>
            <th class='px-4 py-2 text-center'>Title</th>
        </tr>
        </thead>
        <tbody>
            <?php
                if(!empty($_SESSION["typeID"])){
                    $accID = $_SESSION["accountID"];
                    $result = mysqli_query($conn, "SELECT borrow_date,deadline,bookID
                    FROM borrowed_book
                    WHERE librarianID = '$accID'
                    ORDER BY borrow_date DESC
                    LIMIT 2;");

                    while($row = mysqli_fetch_assoc($result)){

                        $booknumber = $row["bookID"];
                        $result2 = mysqli_query($conn, "SELECT book_name
                        FROM book
                        WHERE bookID = '$booknumber';");

                        $row2 = mysqli_fetch_assoc($result2);

                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[borrow_date]</td>
                            <td class='px-4 py-2 text-center'>$row[deadline]</td>
                            <td class='px-4 py-2 text-center'>$row2[book_name]</td>
                        </tr>";
                    }
                }
                else{
                    $accID = $_SESSION["accountID"];
                    $result = mysqli_query($conn, "SELECT borrow_date,deadline,bookID
                    FROM borrowed_book
                    WHERE patronID = '$accID'
                    ORDER BY borrow_date DESC;");

                    while($row = mysqli_fetch_assoc($result)){

                        $booknumber = $row["bookID"];
                        $result2 = mysqli_query($conn, "SELECT book_name
                        FROM book
                        WHERE bookID = '$booknumber';");

                        $row2 = mysqli_fetch_assoc($result2);

                        echo "<tr>
                            <td class='px-4 py-2 text-center'>$row[borrow_date]</td>
                            <td class='px-4 py-2 text-center'>$row[deadline]</td>
                            <td class='px-4 py-2 text-center'>$row2[book_name]</td>
                        </tr>";
                    }     
                }
            ?>
        </tbody>
      </table>
    </div>
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/index.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>
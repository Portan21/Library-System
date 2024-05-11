<?php
require 'config.php';
if(empty($_SESSION["accountID"])){
    header("Location: login.php");
}
else{
    $id = $_SESSION["accountID"];
}

if(empty($_SESSION["typeID"])){
    header("Location: catalogs.php");
}

date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
$currentDateTime = date('Y-m-d H:i:s');

if(isset($_POST["ret"])){
    $borrowID = $_POST["borrowID"];

    $insquery = "INSERT INTO returned_book (bookID, patronID, librarianID, borrow_date, return_date, penalty_paid)
    SELECT bookID, patronID, $id, borrow_date, '$currentDateTime', 0
    FROM borrowed_book
    WHERE borrowID = $borrowID";

    if(mysqli_query($conn, $insquery)){
        // Insert was successful, now update the book availability
        $updatequery = "UPDATE book SET availability = '1' WHERE bookID IN (SELECT bookID FROM borrowed_book WHERE borrowID = $borrowID)";
        
        if (mysqli_query($conn, $updatequery)) {
            // The update was successful, now proceed with the delete query
            $delquery = "DELETE FROM borrowed_book WHERE borrowID = $borrowID";
            
            if(mysqli_query($conn, $delquery)){
            }
            else{
                echo "<script>alert('Deleting error');</script>";
            }
        } else {
            echo "<script>alert('Update error');</script>";
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
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="../CSS/approval.css">
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
        $acctype = $_SESSION["typeID"];
	    if($acctype != 4){
	    echo"
            <li class='nav-item'>
            <a class='nav-link' href='request.php'>Request</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link active' aria-current='page' href='borrowed.php'>Borrowed</a>
            </li>

            <li class='nav-item'>
            <a class='nav-link' href='penalty.php'>Penalty</a>
            </li>
            
            <li class='nav-item'>
            <a class='nav-link'  href='librarianprofiles-records.php'>Records</a>
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
    <div class = "container py-5">
        <div class ="row">
        <table id="example" class="table table-borderless" style="width:100%">
            <thead>
            <tr>
                <th class='text-uppercase'><h3>Borrowed Books</h3></th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            $result = mysqli_query($conn, "SELECT borrowID, a.pt_name AS bf_name, ac.name AS lf_name, book_name, deadline FROM borrowed_book bb
            INNER JOIN book b on bb.bookID = b.bookID
            INNER JOIN patron_acc a on bb.patronID = a.patronID
            INNER JOIN lib_acc ac on bb.librarianID = ac.librarianID
            WHERE deadline >= '$currentDateTime'");

            while($row = mysqli_fetch_assoc($result)){
                echo 
                "<tr>
                    <td class='px-4 py-2'>
                        <div class='container'>

                            <div class='row border border-secondary rounded mt-1 mb-1'>
                                <div class='col-4 text-break mt-1 mb-1 '>
                                        <h3 class='text-uppercase mb-0'>$row[book_name]</h3>
                                        <a>Borrowed by: $row[bf_name]</a><br>
                                </div>
                                
                                <div class='col-4 text-break mt-1 mb-1'>
                                        <a><b>Deadline:</b></a><br>
                                        <h3 class='text-uppercase mb-0'>$row[deadline]</h3>
                                        <a>Approved by: $row[lf_name]</a><br>
                                </div>

                                <div class='col-4 d-flex justify-content-end align-items-center'>
                                    <div>
                                        <form action='' method='post' autocomplete='off'>
                                            <input type='hidden' id='borrowID' name='borrowID' value='$row[borrowID]'>
                                            <button type='submit' class='btn btn-primary' onclick='return confirmReturn()' id='ret' name='ret'>RETURNED</button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
    
    <script>
    function confirmReturn() {
        return confirm('Press "OK" to confirm the book return. Press "Cancel" otherwise.');
    }
    </script>
    <script src = "https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src = "../JavaScript/app2.js"></script>
</body>
</html>
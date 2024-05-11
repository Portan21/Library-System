<?php
require 'config.php';
if(!empty($_SESSION["accountID"])){
    $id = $_SESSION["accountID"];
}
else{
    header("Location: login.php");
}

if(empty($_SESSION["typeID"])){
    header("Location: catalogs.php");
}

if(isset($_GET["appreq"]) && isset($_GET["appbook"])){

    $appreq = $_GET["appreq"];
    $appbook = $_GET["appbook"];
    $duration = $_GET["duration"];

    date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippines
    $currentDateTime = date('Y-m-d H:i:s');
    // Add 7 days to the current date and time
    $futureDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +' . $duration . ' days'));

    //INSERT VALUE to borrowed book
    $insquery = "INSERT INTO borrowed_book (bookID, patronID, librarianID, borrow_date, deadline)
    VALUES('$appbook', '$appreq', '$id', '$currentDateTime', '$futureDateTime')";

    if(mysqli_query($conn, $insquery)){

        //DELETE FROM book_reqeust
        $delquery = "DELETE FROM book_request WHERE patronID = $appreq AND bookID = $appbook";
        if(mysqli_query($conn, $delquery)){

            $updatequery = "UPDATE book SET availability = '3' WHERE bookID = '$appbook'";
            if (mysqli_query($conn, $updatequery)) {
                // The update was successful
            }
        }
        else{
            echo"<script>alert('DELETING ERROR');</script>";
        }
    }
    
}

header("location: request.php");
exit;

//echo "<script> alert('Time Right Now: $currentDateTime AND Deadline: $futureDateTime'); </script>";

?>